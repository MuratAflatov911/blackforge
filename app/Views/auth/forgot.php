<?php use App\Core\Csrf; use App\Core\View; ?>
<div class="tabs auth-tabs">
  <a class="tab" href="<?= View::url('/login') ?>">Вход</a>
  <a class="tab active" href="<?= View::url('/forgot-password') ?>">Восстановление</a>
</div>
<h1>Восстановление пароля</h1>
<form method="post" action="<?= View::url('/forgot-password') ?>" class="auth-form card">
  <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
  <input type="email" name="email" placeholder="Email аккаунта" required>
  <button class="btn">Отправить ссылку</button>
</form>
