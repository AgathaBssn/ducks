<?php
require_once 'PDO.php';

if (isset($_POST['duck_id'], $_POST['place'])) {
    $duck_id = intval($_POST['duck_id']);
    $new_place = $_POST['place'];
    $new_etat = (isset($_POST['etat']) && $_POST['etat'] === 'trouvé') ? 'trouvé' : 'caché';

    // Vérifie si la place existe dans la table places
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM places WHERE label = :label");
    $stmt->execute([':label' => $new_place]);
    $place_exists = $stmt->fetchColumn();

    if (!$place_exists) {
        die('Place non autorisée.');
    }

    // Met à jour la place, last_found et l'état dans la base
    $stmt = $pdo->prepare("UPDATE ducks SET place = :place, last_found = NOW(), etat = :etat WHERE id = :id");
    $stmt->execute([
        ':place' => $new_place,
        ':etat' => $new_etat,
        ':id' => $duck_id
    ]);

    header('Location: index.php');
    exit;
} else {
    die('Données manquantes.');
}
?>
