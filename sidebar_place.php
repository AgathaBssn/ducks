<?php
require_once 'PDO.php';

function randomColor() {
    // Génère une couleur hex aléatoire bien visible (exclut les très claires)
    $r = rand(50, 200);
    $g = rand(50, 200);
    $b = rand(50, 200);
    return sprintf("#%02X%02X%02X", $r, $g, $b);
}

// Lors de l'ajout d'un lieu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add' && !empty($_POST['new_place'])) {
    $color = randomColor();
    // new place to upper
    $_POST['new_place'] = mb_strtoupper(trim($_POST['new_place']));

    $stmt = $pdo->prepare("INSERT IGNORE INTO places (label, color) VALUES (:label, :color)");
    $stmt->execute([
        ':label' => $_POST['new_place'],
        ':color' => $color
    ]);
    header('Location: index.php');
    exit;
}


// Suppression d'un lieu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete' && !empty($_POST['place_id'])) {
    $place_id = intval($_POST['place_id']);

    // Avant de supprimer, vérifier si des canards sont assignés à ce lieu
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM ducks WHERE place = (SELECT label FROM places WHERE id = :id)");
    $stmt->execute([':id' => $place_id]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Aucun canard n'est assigné, on peut supprimer
        $stmt = $pdo->prepare("DELETE FROM places WHERE id = :id");
        $stmt->execute([':id' => $place_id]);
    } else {
        // Ne pas supprimer, peut-être afficher un message d'erreur
        // Pour simplifier, on ignore la suppression dans ce cas
    }

    header('Location: index.php');
    exit;
}
?>
