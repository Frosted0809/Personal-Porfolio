<?php
declare(strict_types=1);
require __DIR__ . '/../includes/password_checker.php';
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');            // never cache anything about a password
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['error' => 'POST only']); exit; }
// The password is analysed in memory and never stored or logged.
echo json_encode(analyze_password(substr((string)($_POST['password'] ?? ''), 0, 128)), JSON_UNESCAPED_UNICODE);
