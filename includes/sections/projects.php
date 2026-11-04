<section id="projects">
  <div class="wrap">
    <h2 class="section-title">Projects</h2>
    <p class="section-sub">Live demos, loaded as you scroll. Try them right here.</p>
    <div class="grid" id="grid" data-endpoint="api/projects.php" aria-label="Projects">
      <noscript><?php foreach (load_projects() as $p) render_card($p); ?></noscript>
    </div>
  </div>
</section>
