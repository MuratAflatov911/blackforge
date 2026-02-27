<?php use App\Core\View; ?>
<h1>Управление заказами</h1>
<?php foreach ($orders as $order): ?>
  <div class="row">
    <span>#<?= (int)$order['id'] ?></span>
    <span><?= View::e($order['status']) ?></span>
    <span><?= View::e($order['email'] ?? $order['customer_email']) ?></span>
  </div>
<?php endforeach; ?>
