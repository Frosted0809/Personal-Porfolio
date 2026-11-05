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
<dialog id="demo" aria-labelledby="demo-title">
  <div class="demo__head">
    <h3 id="demo-title" data-demo-title></h3>
    <button type="button" class="demo__close" data-demo-close aria-label="Close">&times;</button>
  </div>
  <div data-demo-body></div>
</dialog>
</body>
</html>
