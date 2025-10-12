<?php
require_once 'PDO.php';

function randomColor() {
    $r = rand(50, 200);
    $g = rand(50, 200);
    $b = rand(50, 200);
    return sprintf("#%02X%02X%02X", $r, $g, $b);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'add' && !empty($_POST['new_place'])) {
        $new_place = mb_strtoupper(trim($_POST['new_place']));
        $color = randomColor();

        $stmt = $pdo->prepare("INSERT IGNORE INTO places (label, color) VALUES (:label, :color)");
        $stmt->execute([':label' => $new_place, ':color' => $color]);

        header('Location: index.php');
        exit;
    }

    if ($_POST['action'] === 'delete' && !empty($_POST['delete_place_id'])) {
        $place_id = intval($_POST['delete_place_id']);

        // Récupérer label lieu
        $stmt = $pdo->prepare("SELECT label FROM places WHERE id = :id");
        $stmt->execute([':id' => $place_id]);
        $place = $stmt->fetch();

        if (!$place) {
            die("Lieu introuvable.");
        }

        $place_label = $place['label'];

        // Compter canards assignés
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM ducks WHERE place = :label");
        $stmt->execute([':label' => $place_label]);
        $count_ducks = $stmt->fetchColumn();

        if ($count_ducks > 0) {
            // Rediriger vers confirmation
            header("Location: confirm_delete.php?id=$place_id&count=$count_ducks");
            exit;
        } else {
            // Suppression directe
            $stmt = $pdo->prepare("DELETE FROM places WHERE id = :id");
            $stmt->execute([':id' => $place_id]);
            header('Location: index.php');
            exit;
        }
    }
}
