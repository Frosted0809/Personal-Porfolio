<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
$cfg = require __DIR__ . '/config.php';

// No projects yet? Hide the Projects section and its nav link. They return when you add one.
if (!load_projects()) unset($cfg['nav']['projects']);

include __DIR__ . '/includes/header.php';
echo "<main>\n";
foreach (array_keys($cfg['nav']) as $section) {
    include __DIR__ . "/includes/sections/{$section}.php";
}
echo "</main>\n";
include __DIR__ . '/includes/footer.php';
