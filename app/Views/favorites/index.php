<?php use App\Core\View; ?>
<div class="tabs">
  <a class="tab" href="<?= View::url('/catalog') ?>">Каталог</a>
  <a class="tab active" href="<?= View::url('/favorites') ?>">Избранное</a>
  <a class="tab" href="<?= View::url('/cart') ?>">Корзина</a>
</div>
<h1>Избранное</h1>
<p>Товаров в избранном: <?= count($favorites) ?></p>
<p>Для авторизованных пользователей список хранится в таблице <code>favorites</code>, для гостей — в сессии.</p>
