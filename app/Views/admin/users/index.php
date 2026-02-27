<?php use App\Core\View; ?>
<h1>Пользователи</h1>
<?php foreach ($users as $u): ?>
  <div class="row"><span><?= View::e($u['email']) ?></span><span><?= View::e($u['role_name']) ?></span></div>
<?php endforeach; ?>
