<?php
require_once 'PDO.php';
$count = countAllDucks($pdo);
// Nombre de canards cachés
$stmt = $pdo->query("SELECT COUNT(*) FROM ducks WHERE etat = 'caché'");
$count_hidden = $stmt->fetchColumn();

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
          <div class="duck <?= htmlspecialchars($duck['place']) ?> <?= $duck['etat'] === 'trouvé' ? 'found' : '' ?>">
              <div class="duck-image-container">
                  <img src="media/duck.png" alt="Image de canard" class="duck-image" />
                  <div class="duck-id"><?= htmlspecialchars($duck['id']) ?></div>
                  <?php if ($duck['etat'] === 'trouvé'): ?>
                      <img src="media/check.png" alt="Check" class="check-overlay" />
                  <?php endif; ?>
              </div>
              <strong><?= htmlspecialchars($duck['name']) ?></strong>
              <br>
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

  <button id="toggleSidebar" class="sidebar-toggle">☰</button>

  <aside id="sidebar" class="sidebar">
      <h2>Légende des couleurs</h2>
      <ul>
          <li><span class="legend-color AGATHA"></span> Agatha</li>
          <li><span class="legend-color MATTHIEU"></span> Matthieu</li>
          <li><span class="legend-color ELIAS"></span> Elias</li>
      </ul>

      <h2>Statistiques</h2>
      <p>Canards cachés : <strong><?= $count_hidden ?></strong></p>
      <p>Nombre total : <strong><?= $count ?></strong></p>
  </aside>



</body>
<script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });
</script>

</html>
