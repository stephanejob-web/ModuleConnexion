<?php
require_once __DIR__ . '/db.php';

$erreurs = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login   = trim($_POST['login'] ?? '');
    $prenom  = trim($_POST['prenom'] ?? '');
    $nom     = trim($_POST['nom'] ?? '');
    $pass1   = $_POST['password'] ?? '';
    $pass2   = $_POST['password_confirm'] ?? '';

    if ($login === '' || $prenom === '' || $nom === '' || $pass1 === '' || $pass2 === '') {
        $erreurs[] = "Tous les champs sont obligatoires.";
    }
    if ($pass1 !== $pass2) {
        $erreurs[] = "Les mots de passe ne correspondent pas.";
    }

    if (!$erreurs) {
        try {
            $pdo = getPDO();
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (login, prenom, nom, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$login, $prenom, $nom, password_hash($pass1, PASSWORD_DEFAULT)]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $erreurs[] = "Erreur : " . $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
<section class="section">
    <div class="container">
        <h1 class="title">Inscription</h1>

        <?php if ($erreurs): ?>
            <div class="notification is-danger">
                <ul>
                    <?php foreach ($erreurs as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" class="box">
            <div class="field">
                <label class="label">Login</label>
                <div class="control">
                    <input class="input" type="text" name="login" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Prénom</label>
                <div class="control">
                    <input class="input" type="text" name="prenom" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Nom</label>
                <div class="control">
                    <input class="input" type="text" name="nom" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Mot de passe</label>
                <div class="control">
                    <input class="input" type="password" name="password" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Confirmer mot de passe</label>
                <div class="control">
                    <input class="input" type="password" name="password_confirm" required>
                </div>
            </div>

            <div class="field is-grouped">
                <div class="control">
                    <button type="submit" class="button is-link">S’inscrire</button>
                </div>
                <div class="control">
                    <a href="index.php" class="button is-light">Annuler</a>
                </div>
            </div>
        </form>
    </div>
</section>
</body>
</html>
