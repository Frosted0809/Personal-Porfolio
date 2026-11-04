<?php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['error' => 'POST only']); exit; }

function caesar(string $text, int $shift): string {
    $shift = (($shift % 26) + 26) % 26;
    return preg_replace_callback('/[a-z]/i', function ($m) use ($shift) {
        $base = ctype_upper($m[0]) ? 65 : 97;
        return chr((ord($m[0]) - $base + $shift) % 26 + $base);
    }, $text);
}

$raw   = (string)($_POST["text"] ?? "");
$text  = function_exists("mb_substr") ? mb_substr($raw, 0, 1000) : substr($raw, 0, 1000);
$shift = $_POST['shift'] ?? '3';

if ($shift === 'all') {
    $all = [];
    for ($i = 1; $i < 26; $i++) $all[] = ['shift' => $i, 'text' => caesar($text, $i)];
    echo json_encode(['all' => $all], JSON_UNESCAPED_UNICODE);
    exit;
}
echo json_encode(['result' => caesar($text, (int)$shift)], JSON_UNESCAPED_UNICODE);
