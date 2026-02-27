<?php

declare(strict_types=1);

use App\Core\Csrf;
use App\Core\Router;

require __DIR__ . '/../app/bootstrap.php';

$router = new Router();
require __DIR__ . '/../routes/web.php';

if (!headers_sent()) {
    header('Content-Type: text/html; charset=utf-8');
}

Csrf::token();
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
