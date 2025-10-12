<?php

$host = 'db5018716797.hosting-data.io';
$dbname = 'dbs14811708'; 
$user = 'dbu1917480';    
$pass = 'canardsLeDrapeau2025!'; 
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    die("Erreur de connexion : " . $e->getMessage());
}

?>
