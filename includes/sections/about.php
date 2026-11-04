<section id="about" class="about">
  <div class="wrap about__grid">
    <img class="about__photo" src="<?= e($cfg['photo']) ?>" alt="<?= e($cfg['name']) ?>" width="320" height="320">
    <div>
      <p class="eyebrow">Hi, I'm</p>
      <h1><?= e($cfg['name']) ?></h1>
      <p class="role"><?= e($cfg['role']) ?></p>
      <p class="bio"><?= e($cfg['bio']) ?></p>
      <ul class="social">
        <?php foreach ($cfg['social'] as [$label, $url, $icon]): ?>
          <li><a href="<?= e($url) ?>" target="_blank" rel="noopener" aria-label="<?= e($label) ?>"><i class="<?= e($icon) ?>"></i></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
