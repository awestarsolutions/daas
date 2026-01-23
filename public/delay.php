<?php
declare(strict_types=1);

/*
 * Delay as a Service (DaaS) — v1
 * Secure, stateless, best-effort
 */

// --------------------------------------------------
// Security headers
// --------------------------------------------------
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: no-referrer');
header('Cache-Control: no-store, no-cache, must-revalidate');

// --------------------------------------------------
// Configuration
// --------------------------------------------------
$MIN_DELAY_MS     = 300;
$MAX_DELAY_MS     = 2500;
$MAX_ALLOWED_MS   = 5000;

$RATE_LIMIT       = 20;   // requests per window
$RATE_WINDOW_SEC = 60;   // seconds
$MAX_CONCURRENT   = 5;    // concurrent requests per IP

$TMP_DIR = sys_get_temp_dir() . '/daas';

// --------------------------------------------------
// Prepare temp directory
// --------------------------------------------------
if (!is_dir($TMP_DIR)) {
    @mkdir($TMP_DIR, 0700, true);
}

// --------------------------------------------------
// Identify client (best-effort)
// --------------------------------------------------
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$ip_hash = hash('sha256', $ip);
$now = time();

// --------------------------------------------------
// Rate limiting (per IP)
// --------------------------------------------------
$rate_file = "$TMP_DIR/rate_$ip_hash.json";
$rate_data = ['count' => 0, 'start' => $now];

if (file_exists($rate_file)) {
    $rate_data = json_decode(file_get_contents($rate_file), true) ?? $rate_data;

    if ($now - $rate_data['start'] > $RATE_WINDOW_SEC) {
        $rate_data = ['count' => 0, 'start' => $now];
    }
}

$rate_data['count']++;

if ($rate_data['count'] > $RATE_LIMIT) {
    http_response_code(429);
    echo json_encode([
        'status'  => 'rate_limited',
        'message' => 'Too many requests. Please slow down.'
    ]);
    exit;
}

file_put_contents($rate_file, json_encode($rate_data), LOCK_EX);

// --------------------------------------------------
// Concurrency limiting (per IP)
// --------------------------------------------------
$locks = glob("$TMP_DIR/lock_{$ip_hash}_*");

if (count($locks) >= $MAX_CONCURRENT) {
    http_response_code(429);
    echo json_encode([
        'status'  => 'busy',
        'message' => 'Too many concurrent requests.'
    ]);
    exit;
}

$lock_id   = uniqid('', true);
$lock_path = "$TMP_DIR/lock_{$ip_hash}_$lock_id";
file_put_contents($lock_path, '1');

// --------------------------------------------------
// Input validation
// --------------------------------------------------
$requested = filter_input(INPUT_GET, 'ms', FILTER_VALIDATE_INT);

if ($requested !== null && $requested !== false) {
    if ($requested < 100 || $requested > $MAX_ALLOWED_MS) {
        unlink($lock_path);
        http_response_code(400);
        echo json_encode([
            'status'  => 'invalid_request',
            'message' => 'Delay must be between 100 and 5000 milliseconds.'
        ]);
        exit;
    }
    $delay_ms = $requested;
} else {
    $delay_ms = random_int($MIN_DELAY_MS, $MAX_DELAY_MS);
}

// --------------------------------------------------
// Apply delay
// --------------------------------------------------
usleep($delay_ms * 1000);

// --------------------------------------------------
// Cleanup
// --------------------------------------------------
unlink($lock_path);

// --------------------------------------------------
// Successful response
// --------------------------------------------------
http_response_code(200);

echo json_encode([
    'status'   => 'ok',
    'delay_ms'=> $delay_ms
]);
