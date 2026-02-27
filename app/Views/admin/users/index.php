<?php use App\Core\View; ?>
<div class="tabs">
  <a class="tab" href="<?= View::url('/admin') ?>">Дашборд</a>
  <a class="tab active" href="<?= View::url('/admin/users') ?>">Пользователи</a>
</div>
<h1>Пользователи</h1>
<?php foreach ($users as $u): ?>
  <div class="row card"><span><?= View::e($u['email']) ?></span><span><?= View::e($u['role_name']) ?></span><span>История заказов</span><span>Блокировка/смена роли (демо)</span></div>
<?php endforeach; ?>
