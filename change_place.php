<?php
require_once 'PDO.php';

if (isset($_POST['duck_id']) && isset($_POST['place'])) {
    $duck_id = intval($_POST['duck_id']);
    $new_place = $_POST['place'];

    // Valide que la place est autorisée
    $allowed_places = ['AGATHA', 'MATTHIEU', 'ELIAS'];

    if (!in_array($new_place, $allowed_places)) {
        die('Place non autorisée.');
    }

    // Met à jour seulement la place et last_found à maintenant
    $stmt = $pdo->prepare("UPDATE ducks SET place = :place, last_found = NOW() WHERE id = :id");
    $stmt->execute([
        ':place' => $new_place,
        ':id' => $duck_id
    ]);

    // Redirection vers la page principale pour voir la mise à jour
    header('Location: index.php'); // adapte si ton fichier principal est différent
    exit;
} else {
    die('Données manquantes.');
}
?>
