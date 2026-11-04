<?php
function e(?string $s): string { return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }

function load_projects(): array {
    $data = json_decode(@file_get_contents(__DIR__ . '/../data/projects.json'), true);
    return is_array($data) ? $data : [];
}

function project_id(array $p): string {
    $id = $p['id'] ?? strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $p['title'] ?? ''), '-'));
    return preg_replace('/[^a-z0-9\-]/', '', $id);
}

// Only https URLs or plain same-site relative paths are allowed.
function safe_url(string $u): string {
    if (preg_match('#^https://#i', $u)) return $u;
    if (preg_match('#^[A-Za-z0-9_\-./]+$#', $u) && !str_contains($u, '..')) return $u;
    return '';
}

function public_project(array $p): array {
    $type = $p['type'] ?? 'link';
    $module = '';
    if ($type === 'php' && !empty($p['file'])) {
        $js = 'widgets/' . basename($p['file'], '.php') . '.js';
        if (is_file(__DIR__ . '/../' . $js)) $module = $js;
    }
    return [
        'id' => project_id($p), 'title' => $p['title'] ?? 'Untitled', 'description' => $p['description'] ?? '',
        'tags' => array_values($p['tags'] ?? []),
        'size' => in_array($p['size'] ?? '', ['wide', 'tall'], true) ? $p['size'] : 'default',
        'type' => $type, 'embed' => $type === 'embed' ? safe_url($p['url'] ?? '') : '',
        'module' => $module, 'repo' => safe_url($p['repo'] ?? ''), 'live' => safe_url($p['live'] ?? ''),
    ];
}

// Static card for the no-JavaScript fallback.
function render_card(array $p): void { $p = public_project($p); ?>
    <article class="card card--<?= e($p['size']) ?>">
      <header><h3><?= e($p['title']) ?></h3><p><?= e($p['description']) ?></p></header>
      <footer>
        <ul class="tags"><?php foreach ($p['tags'] as $t): ?><li><?= e($t) ?></li><?php endforeach; ?></ul>
        <span class="links">
          <?php if ($p['live']): ?><a href="<?= e($p['live']) ?>">Open live</a><?php endif; ?>
          <?php if ($p['repo']): ?><a href="<?= e($p['repo']) ?>">Source</a><?php endif; ?>
        </span>
      </footer>
    </article>
<?php }
