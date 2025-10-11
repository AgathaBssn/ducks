<?php
require_once 'PDO.php';
$count = countAllDucks($pdo);
$ducks = getAllDucks($pdo);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
  <title>Accueil</title>
</head>
<body>
  <h1>Bienvenue sur la page d'accueil</h1>
  <p>Nombre de canards dans la base : <strong><?= htmlspecialchars($count) ?></strong></p>

  <h2>Liste des canards :</h2>
    <h1>Grille des 100 canards</h1>
  <div class="grid">
      <?php foreach ($ducks as $duck): ?>
          <div class="duck <?= htmlspecialchars($duck['place']) ?>">
              <img src="media/duck.png" alt="Image de canard" class="duck-image">
              <strong><?= htmlspecialchars($duck['name']) ?></strong>
              <br>
              Place: <?= htmlspecialchars($duck['place']) ?><br>
              Vu le: <?= htmlspecialchars($duck['last_found']) ?>
          </div>
      <?php endforeach; ?>
  </div>

</body>
</html>
