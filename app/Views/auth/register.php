<?php use App\Core\Csrf; use App\Core\View; ?>
<div class="tabs auth-tabs">
  <a class="tab" href="<?= View::url('/login') ?>">Вход</a>
  <a class="tab active" href="<?= View::url('/register') ?>">Регистрация</a>
</div>
<h1>Регистрация</h1>
<form method="post" action="<?= View::url('/register') ?>" class="auth-form card">
  <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Пароль (мин. 8)" required>
  <label>CAPTCHA: решите <?= View::e($captchaQuestion ?? '1 + 1') ?></label>
  <input type="number" name="captcha" required>
  <button class="btn">Зарегистрироваться</button>
</form>
