<?php use App\Core\View; ?>
<h1>Личный кабинет</h1>
<p>Email: <?= View::e($user['email']) ?></p>
<h2>История заказов</h2>
<?php foreach ($orders as $order): ?>
  <div class="row">
    <span>#<?= (int)$order['id'] ?></span>
    <span><?= View::e($order['status']) ?></span>
    <span><?= number_format((float)$order['total_amount'], 0, '.', ' ') ?> ₽</span>
  </div>
<?php endforeach; ?>
