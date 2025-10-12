<?php
require_once 'PDO.php';

// Ajout d'un lieu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add' && !empty($_POST['new_place'])) {
    //traitement to upper the place
    $_POST['new_place'] = strtoupper(trim($_POST['new_place']));
    $stmt = $pdo->prepare("INSERT IGNORE INTO places (label) VALUES (:label)");
    $stmt->execute([':label' => $_POST['new_place']]);
    header('Location: index.php'); // recharge la page principale
    exit;
}

// Suppression d'un lieu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete' && !empty($_POST['delete_place_id'])) {
    $stmt = $pdo->prepare("DELETE FROM places WHERE id = :id");
    $stmt->execute([':id' => intval($_POST['delete_place_id'])]);
    header('Location: index.php');
    exit;
}
?>
