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
use App\Controllers\SupportController;

$router->get('/', [HomeController::class, 'index']);
$router->get('/catalog', [CatalogController::class, 'index']);
$router->get('/product/{slug}', [ProductController::class, 'show']);
$router->post('/product/{slug}/review', [ProductController::class, 'addReview']);
$router->post('/compare/toggle', [ProductController::class, 'compareToggle']);
$router->get('/compare', [ProductController::class, 'compare']);

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
$router->get('/forgot-password', [AuthController::class, 'forgotForm']);
$router->post('/forgot-password', [AuthController::class, 'sendReset']);
$router->get('/reset-password', [AuthController::class, 'resetForm']);
$router->post('/reset-password', [AuthController::class, 'resetPassword']);
$router->get('/verify-email', [AuthController::class, 'verifyEmail']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/profile', [ProfileController::class, 'index']);
$router->post('/profile/update', [ProfileController::class, 'update']);
$router->post('/profile/change-password', [ProfileController::class, 'changePassword']);
$router->post('/profile/repeat-order', [ProfileController::class, 'repeatOrder']);
$router->post('/profile/stock-notify', [ProfileController::class, 'stockNotify']);

$router->get('/about', [SupportController::class, 'about']);
$router->get('/delivery', [SupportController::class, 'delivery']);
$router->get('/warranty', [SupportController::class, 'warranty']);
$router->get('/privacy', [SupportController::class, 'privacy']);
$router->post('/newsletter', [SupportController::class, 'newsletter']);
$router->post('/chat', [SupportController::class, 'chat']);

$router->get('/admin/login', [AuthController::class, 'loginForm']);
$router->get('/admin', [DashboardController::class, 'index']);
$router->get('/admin/products', [ProductAdminController::class, 'index']);
$router->post('/admin/products', [ProductAdminController::class, 'store']);
$router->get('/admin/orders', [OrderAdminController::class, 'index']);
$router->get('/admin/users', [UserAdminController::class, 'index']);
