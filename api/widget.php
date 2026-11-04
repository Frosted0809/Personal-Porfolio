<?php
require __DIR__ . '/../includes/functions.php';
header('X-Content-Type-Options: nosniff');
$id = preg_replace('/[^a-z0-9\-]/', '', $_GET['id'] ?? '');
foreach (load_projects() as $p) {
    if (($p['type'] ?? '') === 'php' && project_id($p) === $id && !empty($p['file'])) {
        $file = __DIR__ . '/../widgets/' . basename($p['file']);
        if (is_file($file)) { header('Content-Type: text/html; charset=utf-8'); header('Cache-Control: no-cache'); include $file; exit; }
    }
}
http_response_code(404);
header('Content-Type: text/plain; charset=utf-8');
echo 'Widget not found.';
