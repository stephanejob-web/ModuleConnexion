
<?php
// db.php
$host = 'localhost';
$db   = 'moduleconnexion';
$user = 'root';
$pass = '780662aB2';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // erreurs en exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // résultats en tableaux associatifs
    PDO::ATTR_EMULATE_PREPARES   => false,                  // vraies requêtes préparées
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// --- INSERT ---
$sql = "INSERT INTO utilisateurs (login, prenom, nom, paswword) VALUES (:login, :prenom, :nom, :paswword)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'login'  => 'Alice',
    'prenom'  => 'alice',
    'nom' => 'alice',
    'paswword'  => 'alice',
]);
$nouvelId = $pdo->lastInsertId();
echo "👤 Utilisateur créé avec ID = $nouvelId<br>";

// --- SELECT ---
$sql = "SELECT id, login, prenom,nom,paswword FROM utilisateurs ORDER BY id DESC LIMIT 5";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll();

echo "<h3>Liste des utilisateurs :</h3>";
foreach ($users as $u) {
    echo "ID: {$u['id']} | Login: {$u['login']} | Prenom: {$u['prenom']} | Nom: {$u['nom']}  | Password: {$u['paswword']}<br>";
}

// --- UPDATE (on modifie le nom par exemple)
$sql = "UPDATE utilisateurs SET nom = :n WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'n' => 'Alice Modifiée',
    'id' => 5
]);
echo "✏️ Nom mis à jour pour l’ID $nouvelId<br>";

 //--- DELETE (on supprime le même utilisateur)
$sql = "DELETE FROM utilisateurs WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => 5]);
echo "🗑️ Utilisateur ID 5 supprimé<br>";