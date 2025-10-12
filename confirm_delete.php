<?php
require_once 'PDO.php';

if (empty($_GET['id']) || empty($_GET['count'])) {
    header('Location: index.php');
    exit;
}

$place_id = intval($_GET['id']);
$count = intval($_GET['count']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    if ($_POST['confirm'] === 'yes') {
        $stmt = $pdo->prepare("SELECT label FROM places WHERE id = :id");
        $stmt->execute([':id' => $place_id]);
        $place = $stmt->fetch();

        if (!$place) {
            die("Lieu introuvable.");
        }

        $place_label = $place['label'];

        $pdo->prepare("UPDATE ducks SET place = NULL WHERE place = :label")->execute([':label' => $place_label]);
        $pdo->prepare("DELETE FROM places WHERE id = :id")->execute([':id' => $place_id]);

        header('Location: index.php');
        exit;
    } else {
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Confirmer suppression</title></head>
<body>
<h2>Confirmer la suppression</h2>
<p>Il y a <?= $count ?> canards assignés à ce lieu.<br />
    Voulez-vous vraiment supprimer ce lieu et mettre leur place à vide ?</p>
<form method="post">
    <button type="submit" name="confirm" value="yes">Oui</button>
    <button type="submit" name="confirm" value="no">Non</button>
</form>
</body>
</html>
