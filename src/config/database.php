<?php
declare(strict_types=1);

define('DB_HOST', 'localhost');
define('DB_NAME', 'bogoe_portalen');
define('DB_USER', 'bogoe');
define('DB_PASS', 'portalen'); // Ændr dette til en sikker kode, som kun du kender.
define('DB_CHARSET', 'utf8mb4');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

