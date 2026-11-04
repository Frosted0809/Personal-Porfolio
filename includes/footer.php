<footer class="site-footer">
  <ul>
    <?php foreach ($cfg['nav'] as $id => $label): ?>
      <li><a href="#<?= e($id) ?>"><?= e($label) ?></a></li>
    <?php endforeach; ?>
  </ul>
  <p>&copy; <?= date('Y') ?> <?= e($cfg['short']) ?>. All rights reserved.</p>
</footer>
<dialog id="lightbox" aria-label="Certificate preview">
  <button type="button" class="lightbox__close" aria-label="Close">&times;</button>
  <img src="" alt="">
</dialog>
</body>
</html>
