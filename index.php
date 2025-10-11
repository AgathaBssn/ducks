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
  <h1>Hide and ducks</h1>
  <div class="grid">
      <?php foreach ($ducks as $duck): ?>
          <div class="duck <?= htmlspecialchars($duck['place']) ?>">
              <img src="media/duck.png" alt="Image de canard" class="duck-image" />
              <strong><?= htmlspecialchars($duck['name']) ?></strong>
              <br />
              <div class="tooltip-zone">
                  <span class="duck-tooltip-trigger" tabindex="0">&#9432;</span>
                  <div class="tooltip-content">
                      Vu pour la dernière fois : <?= htmlspecialchars($duck['last_found']) ?><br />
                      <form method="post" action="change_place.php">
                          <!-- TOGGLE FOUND -->
                          <label class="switch">
                              <input type="checkbox" name="etat" value="trouvé" <?= $duck['etat'] === 'trouvé' ? 'checked' : '' ?>>
                              <span class="slider"></span>
                          </label>
                          <label for="etat">Trouvé</label>

                          <!-- CHANGE PLACE -->
                          <input type="hidden" name="duck_id" value="<?= htmlspecialchars($duck['id']) ?>" />
                          <label for="place_<?= htmlspecialchars($duck['id']) ?>">Changer la position :</label>
                          <select name="place" id="place_<?= htmlspecialchars($duck['id']) ?>">
                              <option value="AGATHA" <?= $duck['place'] === 'AGATHA' ? 'selected' : '' ?>>Agatha</option>
                              <option value="MATTHIEU" <?= $duck['place'] === 'MATTHIEU' ? 'selected' : '' ?>>Matthieu</option>
                              <option value="ELIAS" <?= $duck['place'] === 'ELIAS' ? 'selected' : '' ?>>Elias</option>
                              <!-- autres places -->
                          </select>
                          <button type="submit">Valider</button>
                      </form>
                  </div>
              </div>
          </div>

      <?php endforeach; ?>
  </div>


</body>
</html>
