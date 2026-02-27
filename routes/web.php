<?php

declare(strict_types=1);

use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\OrderAdminController;
use App\Controllers\Admin\ProductAdminController;
use App\Controllers\Admin\UserAdminController;
use App\Controllers\AuthController;
use App\Controllers\CartController;
use App\Controllers\CatalogController;
use App\Controllers\CheckoutController;
use App\Controllers\FavoriteController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\ProfileController;

$router->get('/', [HomeController::class, 'index']);
$router->get('/catalog', [CatalogController::class, 'index']);
$router->get('/product/{slug}', [ProductController::class, 'show']);

$router->get('/cart', [CartController::class, 'index']);
$router->post('/cart/add', [CartController::class, 'add']);
$router->post('/cart/update', [CartController::class, 'update']);
$router->post('/checkout', [CheckoutController::class, 'create']);

$router->get('/favorites', [FavoriteController::class, 'index']);
$router->post('/favorites/toggle', [FavoriteController::class, 'toggle']);

$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'registerForm']);
$router->post('/register', [AuthController::class, 'register']);
$router->post('/logout', [AuthController::class, 'logout']);
$router->get('/profile', [ProfileController::class, 'index']);

$router->get('/admin', [DashboardController::class, 'index']);
$router->get('/admin/products', [ProductAdminController::class, 'index']);
$router->post('/admin/products', [ProductAdminController::class, 'store']);
$router->get('/admin/orders', [OrderAdminController::class, 'index']);
$router->get('/admin/users', [UserAdminController::class, 'index']);
