<?php
// PHP port of my Python Password Strength Checker (main.py).
// Same rule-based scoring + entropy. Two fixes vs the original:
//  1) uppercase letters now add 26 to the charset (the Python version checked lowercase twice)
//  2) a top verdict "Very Strong" (the Python version returned "Strong" for both of the top tiers)

const COMMON_PASSWORDS = ['123456', 'password', '123456789', '12345678', '12345', 'qwerty',
                          'abc123', 'password1', 'admin', 'letmein', 'welcome', 'monkey'];
const PW_MAX_SCORE = 90;   // sum of all rules below

function pw_length(string $p): int {
    $n = preg_match_all('/./us', $p);
    return $n === false ? strlen($p) : $n;
}

function pw_flags(string $p): array {
    return [
        'lower'  => (bool)preg_match('/\p{Ll}/u', $p),
        'upper'  => (bool)preg_match('/\p{Lu}/u', $p),
        'digit'  => (bool)preg_match('/[0-9]/', $p),
        'symbol' => (bool)preg_match('#[!-/:-@\[-`{-~]#', $p),
        'space'  => (bool)preg_match('/\s/', $p),
    ];
}

function calculate_entropy(string $p): float {
    $f = pw_flags($p);
    $charset = ($f['lower'] ? 26 : 0) + ($f['upper'] ? 26 : 0) + ($f['digit'] ? 10 : 0)
             + ($f['symbol'] ? 32 : 0) + ($f['space'] ? 1 : 0);
    return $charset === 0 ? 0.0 : round(pw_length($p) * log($charset, 2), 2);
}

function analyze_password(string $p): array {
    $len = pw_length($p);
    $f = pw_flags($p);
    $entropy = calculate_entropy($p);
    $common = in_array(strtolower($p), COMMON_PASSWORDS, true);

    $score = 0;
    if ($len >= 8)  $score += 20;
    if ($len >= 12) $score += 10;
    if ($f['lower']) $score += 10;
    if ($f['upper']) $score += 10;
    if ($f['digit']) $score += 10;
    if ($f['symbol']) $score += 10;
    if ($entropy >= 50) $score += 20;
    if ($common) $score = max(0, $score - 40);

    $verdict = $score < 40 ? 'Weak' : ($score < 60 ? 'Moderate' : ($score < 80 ? 'Strong' : 'Very strong'));
    if ($len === 0) $verdict = '';

    return [
        'length' => $len, 'entropy' => $entropy, 'score' => $score, 'max' => PW_MAX_SCORE,
        'verdict' => $verdict, 'common' => $common,
        'checks' => [
            ['label' => '8+ characters',        'ok' => $len >= 8],
            ['label' => '12+ characters',       'ok' => $len >= 12],
            ['label' => 'Lowercase letter',     'ok' => $f['lower']],
            ['label' => 'Uppercase letter',     'ok' => $f['upper']],
            ['label' => 'Number',               'ok' => $f['digit']],
            ['label' => 'Symbol',               'ok' => $f['symbol']],
            ['label' => 'Not a common password','ok' => $len > 0 && !$common],
        ],
    ];
}
