<?php

require 'bd.php';

$erreurs = [];
$success = null;
$login = $prenom = $nom = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération simple des champs
    $login     = trim($_POST['login'] ?? '');
    $prenom    = trim($_POST['firstname'] ?? '');
    $nom       = trim($_POST['lastname'] ?? '');
    $pass1     = $_POST['password'] ?? '';
    $pass2     = $_POST['password_confirm'] ?? '';

    if ($login === '' || $prenom === '' || $nom === '' || $pass1 === '' || $pass2 === '') {
        $erreurs[] = "Tous les champs sont obligatoires.";
    } elseif ($pass1 !== $pass2) {
        $erreurs[] = "Les mots de passe ne correspondent pas.";
    }

    if (empty($erreurs)) {
        try {
            $pdo = getPDO();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("
                INSERT INTO utilisateurs (`login`, `prenom`, `nom`, `paswword`)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$login, $prenom, $nom, $pass1]);

            $success = "Inscription effectuée ✅";

            $login = $prenom = $nom = '';
            // ✅ Redirection après inscription
            header("Refresh: 3; URL=login.php");
            exit;
        } catch (PDOException $e) {
            $erreurs[] = "Erreur base de données : " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Inscription simple</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
</head>
<body>
<div class="container" style="max-width:800px; margin-top:40px;">

    <?php if (!empty($erreurs)): ?>
        <div class="notification is-danger">
            <?php foreach ($erreurs as $err): ?>
                <p><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endforeach; ?>
        </div>
    <?php elseif (!empty($success)): ?>
        <div class="notification is-success">
            <p><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
    <?php endif; ?>

    <h1 class="title">Inscription</h1>

    <form method="post" class="box" novalidate>
        <div class="field">
            <label class="label" for="login">Login</label>
            <div class="control">
                <input id="login" class="input" type="text" name="login" placeholder="login"
                       value="<?= htmlspecialchars($login, ENT_QUOTES, 'UTF-8') ?>">
            </div>
        </div>

        <div class="field">
            <label class="label" for="firstname">Prénom</label>
            <div class="control">
                <input id="firstname" class="input" type="text" name="firstname" placeholder="Prénom"
                       value="<?= htmlspecialchars($prenom, ENT_QUOTES, 'UTF-8') ?>">
            </div>
        </div>

        <div class="field">
            <label class="label" for="lastname">Nom</label>
            <div class="control">
                <input id="lastname" class="input" type="text" name="lastname" placeholder="Nom"
                       value="<?= htmlspecialchars($nom, ENT_QUOTES, 'UTF-8') ?>">
            </div>
        </div>

        <div class="field">
            <label class="label" for="password">Mot de passe</label>
            <div class="control">
                <input id="password" class="input" type="password" name="password" placeholder="Mot de passe">
            </div>
        </div>

        <div class="field">
            <label class="label" for="password_confirm">Confirmer le mot de passe</label>
            <div class="control">
                <input id="password_confirm" class="input" type="password" name="password_confirm" placeholder="Confirmer le mot de passe">
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">Valider</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
