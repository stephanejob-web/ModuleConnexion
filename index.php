<?php
// index.php
session_start();

// Si l'utilisateur n'est pas connecté, on le redirige
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
// récupérer les infos utilisateur en session
$user = $_SESSION['user'];
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <title>Accueil</title>
</head>
<body>
<?php include 'hero.php'; ?>
<?php if ($user['login'] === 'admin'): ?>
    <!-- Bloc spécial visible seulement pour l’admin -->
    <div class="notification is-primary">
        <strong>Section Administrateur</strong>
        <p>Ici tu peux gérer le site, accéder au profil admin, etc.</p>
        <a class="button is-link" href="profile.php">Aller au profil</a>
    </div>
<?php endif; ?>
</body>
</html>
