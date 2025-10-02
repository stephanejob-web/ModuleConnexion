<?php
// profile.php
session_start(); // Démarre la session PHP
require 'bd.php'; // Inclut la connexion à la base de données

// Vérifie si l'utilisateur est connecté, sinon redirige vers la page de login
if (empty($_SESSION['user'])) {
    header('Location: login.php'); exit;
}

$pdo = getPDO(); // Récupère l'objet PDO pour la base de données
$id = (int) $_SESSION['user']['id']; // Récupère l'ID de l'utilisateur connecté

// Charge les informations actuelles de l'utilisateur
$stmt = $pdo->prepare("SELECT id, login, prenom, nom FROM utilisateurs WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();
if (!$user) { die("Utilisateur introuvable."); } // Arrête si l'utilisateur n'existe pas

$erreurs = []; // Tableau pour stocker les erreurs
$ok = false;   // Indique si la mise à jour a réussi

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login   = trim($_POST['login'] ?? '');   // Récupère et nettoie le login
    $prenom  = trim($_POST['prenom'] ?? '');  // Récupère et nettoie le prénom
    $nom     = trim($_POST['nom'] ?? '');     // Récupère et nettoie le nom
    $passNew = $_POST['password'] ?? '';      // Récupère le nouveau mot de passe (peut être vide)

    // Vérifie que tous les champs obligatoires sont remplis
    if ($login === '' || $prenom === '' || $nom === '') {
        $erreurs[] = "Tous les champs (sauf mot de passe) sont requis.";
    } else {
        try {
            // Si un nouveau mot de passe est fourni, le met à jour en clair
            if ($passNew !== '') {
                // ATTENTION: le mot de passe est enregistré en clair (à éviter en vrai projet)
                $stmt = $pdo->prepare("UPDATE utilisateurs SET login=?, prenom=?, nom=?, password=? WHERE id=?");
                $stmt->execute([$login, $prenom, $nom, $passNew, $id]);
            } else {
                // Sinon, met à jour seulement les autres champs
                $stmt = $pdo->prepare("UPDATE utilisateurs SET login=?, prenom=?, nom=? WHERE id=?");
                $stmt->execute([$login, $prenom, $nom, $id]);
            }
            // Met à jour la session avec les nouvelles valeurs
            $_SESSION['user']['login']  = $login;
            $_SESSION['user']['prenom'] = $prenom;
            $_SESSION['user']['nom']    = $nom;
            $ok = true;

            // Recharge les données utilisateur pour afficher le formulaire à jour
            $stmt = $pdo->prepare("SELECT id, login, prenom, nom FROM utilisateurs WHERE id = ?");
            $stmt->execute([$id]);
            $user = $stmt->fetch();
        } catch (PDOException $e) {
            // En cas d'erreur SQL, ajoute le message d'erreur
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

    <!-- Affiche une notification si la mise à jour a réussi -->
    <?php if ($ok): ?>
        <div class="notification is-success">Profil mis à jour ✅</div>
    <?php endif; ?>

    <!-- Affiche les erreurs éventuelles -->
    <?php if (!empty($erreurs)): ?>
        <div class="notification is-danger">
            <?php foreach ($erreurs as $err): ?>
                <p><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire de modification du profil -->
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
