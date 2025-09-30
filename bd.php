<?php
function getPDO(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;

    $host = '127.0.0.1'; $port = 3306; $db = 'moduleconnexion';
    $user = 'root'; $pass = '780662aB2';
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

    return $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
}
