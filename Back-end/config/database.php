<?php
$host = '127.0.0.1';
$dbName = 'professionnel_du_loiret';
$user = 'root';
$password = '';
$dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";

$pdo=new PDO($dsn, $user, $password);

try {
    $pdo=new PDO($dsn, $user, $password);
}
catch (PDOException $e) {
    echo "Erreur de connexion" . $e->getMessage();
}