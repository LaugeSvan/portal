<?php
// Development router for PHP built-in server.
// Serves existing files directly, otherwise forwards to index.php.

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
$file = __DIR__ . $path;

if ($path !== '/' && is_file($file)) {
    return false; // Let the built-in server handle static files
}

require __DIR__ . '/index.php';

