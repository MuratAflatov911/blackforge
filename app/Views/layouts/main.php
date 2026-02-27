<?php use App\Core\Auth; use App\Core\Csrf; use App\Core\View; ?>
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
<header class="header">
    <a class="logo" href="<?= View::url('/') ?>">BLACKFORGE</a>
    <nav>
        <a href="<?= View::url('/catalog') ?>">Каталог</a>
        <a href="<?= View::url('/favorites') ?>">Избранное</a>
        <a href="<?= View::url('/cart') ?>">Корзина</a>
        <?php if (Auth::user()): ?>
            <a href="<?= View::url('/profile') ?>">Профиль</a>
            <form method="post" action="<?= View::url('/logout') ?>" class="inline">
                <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
                <button class="link-btn">Выход</button>
            </form>
        <?php else: ?>
            <a href="<?= View::url('/login') ?>">Вход</a>
        <?php endif; ?>
    </nav>
</header>

<main class="container">
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="flash"><?= View::e($_SESSION['flash']); unset($_SESSION['flash']); ?></div>
    <?php endif; ?>
    <?php require $contentView; ?>
</main>

<footer class="footer">© <?= date('Y') ?> BLACKFORGE</footer>
</body>
</html>
