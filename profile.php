<?php
// profile.php
session_start();
require 'bd.php';

if (empty($_SESSION['user'])) {
    header('Location: login.php'); exit;
}

$pdo = getPDO();
$id = (int) $_SESSION['user']['id'];

// Charger les infos actuelles
$stmt = $pdo->prepare("SELECT id, login, prenom, nom FROM utilisateurs WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();
if (!$user) { die("Utilisateur introuvable."); }

$erreurs = [];
$ok = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login   = trim($_POST['login'] ?? '');
    $prenom  = trim($_POST['prenom'] ?? '');
    $nom     = trim($_POST['nom'] ?? '');
    $passNew = $_POST['password'] ?? ''; // peut être vide

    if ($login === '' || $prenom === '' || $nom === '') {
        $erreurs[] = "Tous les champs (sauf mot de passe) sont requis.";
    } else {
        try {
            if ($passNew !== '') {
                $hash = password_hash($passNew, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE utilisateurs SET login=?, prenom=?, nom=?, password=? WHERE id=?");
                $stmt->execute([$login, $prenom, $nom, $hash, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE utilisateurs SET login=?, prenom=?, nom=? WHERE id=?");
                $stmt->execute([$login, $prenom, $nom, $id]);
            }
            // Mets à jour la session pour refléter les nouveaux champs
            $_SESSION['user']['login']  = $login;
            $_SESSION['user']['prenom'] = $prenom;
            $_SESSION['user']['nom']    = $nom;
            $ok = true;

            // Recharge les données pour réafficher le formulaire à jour
            $stmt = $pdo->prepare("SELECT id, login, prenom, nom FROM utilisateurs WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();
        } catch (PDOException $e) {
            $erreurs[] = "Erreur DB : " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon profil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
</head>
<body>
<div class="container" style="margin-top:30px; max-width:700px;">
    <h1 class="title">Mon profil</h1>

    <?php if ($ok): ?>
        <div class="notification is-success">Profil mis à jour ✅</div>
    <?php endif; ?>

    <?php if (!empty($erreurs)): ?>
        <div class="notification is-danger">
            <?php foreach ($erreurs as $err): ?>
                <p><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" class="box">
        <div class="field">
            <label class="label">Login</label>
            <div class="control">
                <input class="input" type="text" name="login" value="<?= htmlspecialchars($user['login']) ?>" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Prénom</label>
            <div class="control">
                <input class="input" type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Nom</label>
            <div class="control">
                <input class="input" type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required>
            </div>
        </div>

        <div class="field">
            <label class="label">Nouveau mot de passe</label>
            <div class="control">
                <input class="input" type="password" name="password" placeholder="Laisser vide pour ne pas changer">
            </div>
        </div>

        <button class="button is-success" type="submit">Enregistrer</button>
        <a class="button is-light" href="index.php">Retour</a>
    </form>
</div>
</body>
</html>
