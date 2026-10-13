
<?php

$host = '127.0.0.1';
$dbName = 'professionnel_du_loiret';
$user = 'root';
$password = '';

$dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    throw new RuntimeException( 'Impossible de se connecter à la base de données.');
}
