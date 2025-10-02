<?php
// login.php
session_start();
require 'bd.php';

$erreurs = [];
$success = null;

// Si déjà connecté, on redirige
if (!empty($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if ($login === '' || $pass === '') {
        $erreurs[] = "Veuillez remplir le login et le mot de passe.";
    } else {
        try {
            $pdo = getPDO();
            // ✅ On sélectionne login + mot de passe
            $stmt = $pdo->prepare("
                SELECT id, login, prenom, nom
                FROM utilisateurs
                WHERE login = ? AND paswword = ?
                LIMIT 1
            ");
            $stmt->execute([$login, $pass]);
            $user = $stmt->fetch();

            if ($user) {
                // Connexion réussie
                $_SESSION['user'] = [
                        'id'     => $user['id'],
                        'login'  => $user['login'],
                        'prenom' => $user['prenom'],
                        'nom'    => $user['nom'],
                ];

                $success = "Connexion réussie ✅ Bienvenue {$user['prenom']} !";
                // Redirection après 2 secondes
                // Redirection immédiate
                header('Location: index.php');
                exit;
            } else {
                $erreurs[] = "Login ou mot de passe incorrect.";
            }
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
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <link rel="stylesheet" href="style/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container" style="max-width: 600px; margin-top: 50px;">
    <?php if (!empty($erreurs)): ?>
        <div class="notification is-danger">
            <?php foreach ($erreurs as $err): ?>
                <p><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <h1 class="title">Connexion</h1>

    <form method="post" class="box" novalidate>
        <div class="field">
            <label class="label" for="login">Login</label>
            <div class="control">
                <input id="login" class="input" type="text" name="login" placeholder="Votre login"
                       value="<?= htmlspecialchars($_POST['login'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
            </div>
        </div>

        <div class="field">
            <label class="label" for="password">Mot de passe</label>
            <div class="control">
                <input id="password" class="input" type="password" name="password" placeholder="Votre mot de passe">
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">Se connecter</button>
            </div>
        </div>
    </form>

    <p>Pas encore de compte ? <a href="register.php">Créer un compte</a></p>
</div>
</body>
</html>
