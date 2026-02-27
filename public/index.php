<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\Router;

require __DIR__ . '/../app/bootstrap.php';

$configuredBasePath = (string) ($GLOBALS['config']['app']['base_path'] ?? '');
if ($configuredBasePath !== '') {
    $basePath = '/' . trim($configuredBasePath, '/');
} else {
    $scriptDir = str_replace('\\', '/', dirname((string) ($_SERVER['SCRIPT_NAME'] ?? '')));
    $basePath = rtrim($scriptDir, '/');
    if (str_ends_with($basePath, '/public')) {
        $basePath = substr($basePath, 0, -7);
    }
    if ($basePath === '/' || $basePath === '.') {
        $basePath = '';
    }
}
define('APP_BASE_PATH', $basePath);

$router = new Router();
require __DIR__ . '/../routes/web.php';

if (!headers_sent()) {
    header('Content-Type: text/html; charset=utf-8');
}

Csrf::token();
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'], APP_BASE_PATH);
