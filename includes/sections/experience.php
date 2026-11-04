<section id="experience">
  <div class="wrap">
    <h2 class="section-title">Experience</h2>
    <p class="section-sub">Each card shows what I can do and the proof for it. Levels: Learning, Foundational, Comfortable, Strong.</p>
    <div class="exp-grid">
      <?php foreach ($cfg['experience'] as $x): ?>
        <article class="exp-card">
          <div class="exp-card__top">
            <i class="<?= e($x['icon']) ?>"></i>
            <span class="level"><?= e($x['level']) ?></span>
          </div>
          <h3><?= e($x['title']) ?></h3>
          <p class="muted small"><?= e($x['since']) ?></p>
          <p><?= e($x['proof']) ?></p>
          <ul class="tags"><?php foreach ($x['tags'] as $t): ?><li><?= e($t) ?></li><?php endforeach; ?></ul>
          <?php if (!empty($x['link'])): ?><a class="more" href="<?= e($x['link']) ?>">See certificate &rarr;</a><?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
