<?php use App\Core\Csrf; use App\Core\View; ?>
<div class="tabs">
  <a class="tab active" href="<?= View::url('/profile') ?>">Профиль</a>
  <a class="tab" href="<?= View::url('/favorites') ?>">Избранное (<?= (int)$favoritesCount ?>)</a>
  <a class="tab" href="<?= View::url('/cart') ?>">Корзина</a>
</div>
<h1>Личный кабинет</h1>
<div class="grid">
  <section class="card">
    <h2>Редактирование профиля</h2>
    <form method="post" action="<?= View::url('/profile/update') ?>" class="auth-form">
      <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
      <input type="text" name="full_name" placeholder="Имя" value="<?= View::e((string)($user['full_name'] ?? '')) ?>">
      <input type="text" name="phone" placeholder="Телефон" value="<?= View::e((string)($user['phone'] ?? '')) ?>">
      <button class="btn">Сохранить</button>
    </form>
  </section>
  <section class="card">
    <h2>Смена пароля</h2>
    <form method="post" action="<?= View::url('/profile/change-password') ?>" class="auth-form">
      <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
      <input type="password" name="new_password" placeholder="Новый пароль" required>
      <button class="btn ghost">Обновить пароль</button>
    </form>
  </section>
</div>

<h2>История заказов</h2>
<?php foreach ($orders as $order): ?>
  <div class="row card">
    <span>#<?= (int)$order['id'] ?></span>
    <span>Статус: <?= View::e($order['status']) ?></span>
    <span><?= number_format((float)$order['total_amount'], 0, '.', ' ') ?> ₽</span>
    <form method="post" action="<?= View::url('/profile/repeat-order') ?>">
      <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
      <input type="hidden" name="order_id" value="<?= (int)$order['id'] ?>">
      <button class="btn ghost">Повторить заказ</button>
    </form>
  </div>
<?php endforeach; ?>

<?php if (!empty($_SESSION['last_order'])): ?>
  <section class="card">
    <h2>Последнее подтверждение заказа</h2>
    <p>Заказ #<?= (int)$_SESSION['last_order']['id'] ?>: <?= View::e($_SESSION['last_order']['delivery']) ?>, <?= View::e($_SESSION['last_order']['payment']) ?>, <?= View::e($_SESSION['last_order']['address']) ?></p>
  </section>
<?php endif; ?>
