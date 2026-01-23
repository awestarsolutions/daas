<?php
declare(strict_types=1);

// Security headers
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Cache-Control: no-store, no-cache, must-revalidate');

// Delay configuration (milliseconds)
$MIN_DELAY_MS = 300;
$MAX_DELAY_MS = 2500;
$MAX_ALLOWED_MS = 5000;

// Read requested delay
$requested = filter_input(INPUT_GET, 'ms', FILTER_VALIDATE_INT);

// Decide delay
if ($requested !== null && $requested !== false && $requested >= 100 && $requested <= $MAX_ALLOWED_MS) {
    $delay_ms = $requested;
} else {
    $delay_ms = random_int($MIN_DELAY_MS, $MAX_DELAY_MS);
}

// Apply delay
usleep($delay_ms * 1000);

// Respond
echo json_encode([
    'status' => 'ok',
    'delay_ms' => $delay_ms,
    'message' => 'Response delivered after delay.'
]);
