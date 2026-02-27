<?php use App\Core\Csrf; use App\Core\View; ?>
<h1>Корзина</h1>
<form method="post" action="<?= View::url('/cart/update') ?>">
  <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
  <?php foreach ($cart['items'] as $item): ?>
    <div class="row">
      <strong><?= View::e($item['name']) ?></strong>
      <span><?= number_format((float)$item['price'], 0, '.', ' ') ?> ₽</span>
      <input type="number" min="0" name="qty[<?= (int)$item['id'] ?>]" value="<?= (int)$item['quantity'] ?>">
      <span><?= number_format((float)$item['line'], 0, '.', ' ') ?> ₽</span>
    </div>
  <?php endforeach; ?>
  <button class="btn">Обновить корзину</button>
</form>
<p class="price">Итого: <?= number_format((float)$cart['total'], 0, '.', ' ') ?> ₽</p>
<form method="post" action="<?= View::url('/checkout') ?>" class="checkout">
  <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
  <input type="email" name="email" required placeholder="Email для заказа">
  <input type="text" name="promo" placeholder="Промокод">
  <button class="btn">Оформить заказ</button>
</form>
