<?php
declare(strict_types=1);

// Bootstrap for PHPUnit tests
require_once __DIR__ . '/../src/config/database.php';
require_once __DIR__ . '/../src/helpers.php';

// Register autoloader for tests
spl_autoload_register(function (string $class): void {
    $baseDir = dirname(__DIR__) . '/src/';
    $testDir = __DIR__;

    $paths = [
        $baseDir . 'controllers/' . $class . '.php',
        $baseDir . 'models/' . $class . '.php',
        $testDir . 'Unit/' . $class . '.php',
        $testDir . 'Integration/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (is_file($path)) {
            require_once $path;
            return;
        }
    }
});
