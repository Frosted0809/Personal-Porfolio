<?php
declare(strict_types=1);
session_start();
$ajax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'fetch';

function respond(bool $ok, string $msg, int $code = 200): void {
    global $ajax;
    if ($ajax) {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => $ok, 'message' => $msg]);
    } else {
        header('Location: ../index.php?sent=' . ($ok ? '1' : '0') . '#contact');
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') respond(false, 'POST only.', 405);
if (!hash_equals($_SESSION['csrf'] ?? '', (string)($_POST['csrf'] ?? ''))) respond(false, 'Session expired. Refresh the page and try again.', 403);
if (!empty($_POST['website'])) respond(true, 'Thanks!');                       // honeypot: bots fill this
if (time() - ($_SESSION['last_msg'] ?? 0) < 30) respond(false, 'Please wait a moment before sending again.', 429);

$email   = trim((string)($_POST['email'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 120) respond(false, 'Please enter a valid email.', 422);
$len = function_exists("mb_strlen") ? mb_strlen($message) : strlen($message);
if ($len < 5 || $len > 1000) respond(false, 'Message must be 5 to 1000 characters.', 422);

$row = json_encode(['time' => date('c'), 'email' => $email, 'message' => $message], JSON_UNESCAPED_UNICODE) . PHP_EOL;
if (file_put_contents(__DIR__ . '/../data/messages.jsonl', $row, FILE_APPEND | LOCK_EX) === false) respond(false, 'Could not save your message.', 500);

$_SESSION['last_msg'] = time();
respond(true, 'Thanks! Your message was sent.');
