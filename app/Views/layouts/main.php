<?php use App\Core\Auth; use App\Core\Csrf; use App\Core\View; ?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= View::e($meta['title'] ?? 'BLACKFORGE') ?></title>
    <meta name="description" content="<?= View::e($meta['description'] ?? 'Премиальные автомобильные диски') ?>">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header class="header">
    <a class="logo" href="/">BLACKFORGE</a>
    <nav>
        <a href="/catalog">Каталог</a>
        <a href="/favorites">Избранное</a>
        <a href="/cart">Корзина</a>
        <?php if (Auth::user()): ?>
            <a href="/profile">Профиль</a>
            <form method="post" action="/logout" class="inline">
                <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
                <button class="link-btn">Выход</button>
            </form>
        <?php else: ?>
            <a href="/login">Вход</a>
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
