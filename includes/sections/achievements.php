<section id="achievements">
  <div class="wrap">
    <h2 class="section-title">Achievements</h2>
    <?php foreach ($cfg['achievements'] as $a): ?>
      <article class="ach">
        <button type="button" class="ach__thumb" data-full="<?= e($a['image']) ?>" data-alt="<?= e($a['alt']) ?>" aria-label="View certificate larger">
          <img src="<?= e($a['image']) ?>" alt="<?= e($a['alt']) ?>" loading="lazy" width="1100" height="778">
        </button>
        <div class="ach__text">
          <p class="eyebrow"><?= e($a['type']) ?></p>
          <h3><?= e($a['title']) ?></h3>
          <p class="muted">Issued by <?= e($a['issuer']) ?> &middot; <?= e($a['date']) ?></p>
          <p><?= e($a['description'] ?? 'Click the certificate to view it full size.') ?></p>
          <?php if (!empty($a['link'])): ?><a class="more" href="<?= e($a['link']) ?>" target="_blank" rel="noopener">View badge on Credly &rarr;</a><?php endif; ?>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>
