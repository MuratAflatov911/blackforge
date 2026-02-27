<?php use App\Core\Csrf; use App\Core\View; ?>
<div class="tabs auth-tabs">
  <a class="tab active" href="<?= View::url('/login') ?>">Вход</a>
  <a class="tab" href="<?= View::url('/register') ?>">Регистрация</a>
  <a class="tab" href="<?= View::url('/forgot-password') ?>">Восстановление</a>
</div>
<h1>Авторизация</h1>
<form method="post" action="<?= View::url('/login') ?>" class="auth-form card">
  <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Пароль" required>
  <label>CAPTCHA: решите <?= View::e($captchaQuestion ?? '1 + 1') ?></label>
  <input type="number" name="captcha" required>
  <button class="btn">Войти</button>
  <a class="card-link" href="<?= View::url('/forgot-password') ?>">Забыли пароль?</a>
</form>
