<section id="projects">
  <div class="wrap">
    <h2 class="section-title">Projects</h2>
    <p class="section-sub">Click Live Demo on a project to try it right here.</p>
    <div class="project-grid" id="grid" data-endpoint="api/projects.php" aria-label="Projects">
      <noscript><?php foreach (load_projects() as $p) render_card($p); ?></noscript>
    </div>
  </div>
</section>
