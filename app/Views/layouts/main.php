<?php use App\Core\Auth; use App\Core\Csrf; use App\Core\View; ?>
<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$basePath = defined('APP_BASE_PATH') ? rtrim(APP_BASE_PATH, '/') : '';
if ($basePath !== '' && str_starts_with($currentPath, $basePath)) {
    $currentPath = substr($currentPath, strlen($basePath)) ?: '/';
}
$mainTabs = [
    '/' => 'Главная',
    '/catalog' => 'Каталог',
    '/favorites' => 'Избранное',
    '/cart' => 'Корзина',
];
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= View::e($meta['title'] ?? 'BLACKFORGE') ?></title>
    <meta name="description" content="<?= View::e($meta['description'] ?? 'Премиальные автомобильные диски') ?>">
    <link rel="stylesheet" href="<?= View::url('/assets/css/style.css') ?>">
</head>
<body>
<div class="site-shell">
<header class="header">
    <a class="logo" href="<?= View::url('/') ?>">BLACKFORGE</a>
    <nav class="main-menu">
        <?php foreach ($mainTabs as $path => $label): ?>
            <a class="menu-link <?= $currentPath === $path ? 'active' : '' ?>" href="<?= View::url($path) ?>"><?= View::e($label) ?></a>
        <?php endforeach; ?>
        <?php if (Auth::user()): ?>
            <a class="menu-link <?= str_starts_with($currentPath, '/profile') ? 'active' : '' ?>" href="<?= View::url('/profile') ?>">Профиль</a>
            <form method="post" action="<?= View::url('/logout') ?>" class="inline">
                <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
                <button class="menu-link menu-btn">Выход</button>
            </form>
        <?php else: ?>
            <a class="menu-link <?= str_starts_with($currentPath, '/login') || str_starts_with($currentPath, '/register') ? 'active' : '' ?>" href="<?= View::url('/login') ?>">Войти</a>
        <?php endif; ?>
    </nav>
</header>

<main class="container">
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="flash"><?= View::e($_SESSION['flash']); unset($_SESSION['flash']); ?></div>
    <?php endif; ?>
    <?php require $contentView; ?>
</main>

<footer class="footer">© <?= date('Y') ?> BLACKFORGE • Premium Wheels</footer>
</div>
</body>
</html>
