<?php
require_once 'PDO.php';

if (isset($_POST['duck_id']) && isset($_POST['place'])) {
    $duck_id = intval($_POST['duck_id']);
    $new_place = $_POST['place'];
    // Récupérer l’état, par défaut 'caché' si non défini
    $new_etat = isset($_POST['etat']) && $_POST['etat'] === 'trouvé' ? 'trouvé' : 'caché';

    // Valide que la place est autorisée
    $allowed_places = ['AGATHA', 'MATTHIEU', 'ELIAS'];
    if (!in_array($new_place, $allowed_places)) {
        die('Place non autorisée.');
    }

    // Met à jour la place, last_found et l'état dans la base
    $stmt = $pdo->prepare("UPDATE ducks SET place = :place, last_found = NOW(), etat = :etat WHERE id = :id");
    $stmt->execute([
        ':place' => $new_place,
        ':etat' => $new_etat,
        ':id' => $duck_id
    ]);

    // Redirige vers la page principale
    header('Location: index.php');
    exit;
} else {
    die('Données manquantes.');
}
?>
