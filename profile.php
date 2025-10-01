<?php
// profile.php
session_start();

// Vérifier si l'utilisateur est connecté
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Vérifier que c'est bien l'admin
if ($_SESSION['user']['login'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Connexion à la base
$host = 'localhost';
$db = 'moduleconnexion';
$user = 'root';
$pass = '780662aB2';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Récupérer tous les utilisateurs
    $stmt = $pdo->query("SELECT id, login, prenom, nom, paswword FROM utilisateurs ORDER BY id ASC");
    $utilisateurs = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <title>Liste des utilisateurs</title>
</head>
<body>
<div class="container" style="margin-top:30px;">
    <h1 class="title">Liste des utilisateurs</h1>

    <table class="table is-fullwidth is-striped is-hoverable">
        <thead>
        <tr>
            <th>ID</th>
            <th>Login</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Mot de passe</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($utilisateurs as $u): ?>
            <tr>
                <td><?= htmlspecialchars($u['id']) ?></td>
                <td><?= htmlspecialchars($u['login']) ?></td>
                <td><?= htmlspecialchars($u['prenom']) ?></td>
                <td><?= htmlspecialchars($u['nom']) ?></td>
                <td><?= htmlspecialchars($u['password']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <p><a class="button is-link" href="index.php">Retour à l'accueil</a></p>
</div>
</body>
</html>
