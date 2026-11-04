<?php
require __DIR__ . '/../includes/functions.php';
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: public, max-age=60');
$json = json_encode(['projects' => array_map('public_project', load_projects())], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
$etag = '"' . md5($json) . '"';
header("ETag: $etag");
if (($_SERVER['HTTP_IF_NONE_MATCH'] ?? '') === $etag) { http_response_code(304); exit; }
echo $json;
