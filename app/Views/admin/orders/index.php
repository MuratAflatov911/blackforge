<?php use App\Core\View; ?>
<div class="tabs">
  <a class="tab" href="<?= View::url('/admin') ?>">Дашборд</a>
  <a class="tab" href="<?= View::url('/admin/products') ?>">Товары</a>
  <a class="tab active" href="<?= View::url('/admin/orders') ?>">Заказы</a>
</div>
<h1>Управление заказами</h1>
<?php foreach ($orders as $order): ?>
  <div class="row card">
    <span>#<?= (int)$order['id'] ?></span>
    <span><?= View::e($order['status']) ?></span>
    <span><?= View::e($order['email'] ?? $order['customer_email']) ?></span>
    <span>Печать накладной (демо)</span>
  </div>
<?php endforeach; ?>
<p>Статусы: Новый, В обработке, Отправлен, Доставлен, Отменён.</p>
