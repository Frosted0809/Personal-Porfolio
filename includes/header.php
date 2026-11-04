<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="color-scheme" content="dark">
  <title><?= e($cfg['short']) ?> | Portfolio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css">
  <link rel="stylesheet" href="assets/style.css">
  <script type="module" src="assets/app.js"></script>
</head>
<body>
<header class="site-header">
  <a href="#about" class="logo"><?= e($cfg['name']) ?></a>
  <button class="menu-toggle" id="menu-toggle" aria-label="Menu" aria-expanded="false" aria-controls="nav-links">
    <i class="fa-solid fa-bars-staggered"></i>
  </button>
  <ul class="nav-links" id="nav-links">
    <?php foreach ($cfg['nav'] as $id => $label): ?>
      <li><a href="#<?= e($id) ?>"><?= e($label) ?></a></li>
    <?php endforeach; ?>
  </ul>
  <a class="visit-btn" href="<?= e($cfg['github']) ?>" target="_blank" rel="noopener">Visit My Works | Github</a>
</header>
