<?php

declare(strict_types=1);

session_start();

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/';

    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($file)) {
        require $file;
    }
});

$configPath = __DIR__ . '/../config/config.php';
if (!is_file($configPath)) {
    $configPath = __DIR__ . '/../config/config.example.php';
}

$GLOBALS['config'] = require $configPath;
