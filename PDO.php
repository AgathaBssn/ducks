<?php
require_once 'config.php';

/// returns all ducks from the database
function getAllDucks($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM ducks");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}

/// returns the number of ducks in the database
function countAllDucks($pdo) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM ducks");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }

}