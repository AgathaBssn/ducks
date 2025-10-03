<?php

$host = 'localhost';
$dbname = 'ducks';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $username, $password, $options);

    echo "Connexion réussie à la base de données !";

} catch (PDOException $e) {
    // Gestion des erreurs de connexion
    die("Erreur de connexion : " . $e->getMessage());
}

// Exemple d'utilisation - Requête SELECT
try {
    $stmt = $pdo->query("SELECT * FROM votre_table LIMIT 5");
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        echo "<br>" . print_r($row, true);
    }
} catch (PDOException $e) {
    echo "Erreur lors de la requête : " . $e->getMessage();
}

// Exemple avec requête préparée (recommandé pour éviter les injections SQL)
try {
    $id = 1;
    $stmt = $pdo->prepare("SELECT * FROM votre_table WHERE id = ?");
    $stmt->execute([$id]);
    $result = $stmt->fetch();

    print_r($result);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>