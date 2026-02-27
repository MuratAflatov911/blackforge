<?php use App\Core\Csrf; use App\Core\View; ?>
<h1>Вход</h1>
<form method="post" action="<?= View::url('/login') ?>" class="auth-form">
  <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Пароль" required>
  <button class="btn">Войти</button>
</form>
