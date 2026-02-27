<?php use App\Core\Csrf; use App\Core\View; ?>
<div class="tabs auth-tabs">
  <a class="tab" href="<?= View::url('/login') ?>">Вход</a>
  <a class="tab active" href="<?= View::url('/register') ?>">Регистрация</a>
</div>
<h1>Создание аккаунта</h1>
<form method="post" action="<?= View::url('/register') ?>" class="auth-form card register-form">
  <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
  <div class="form-grid">
    <input type="text" name="first_name" placeholder="Имя" required>
    <input type="text" name="last_name" placeholder="Фамилия" required>
  </div>
  <input type="tel" name="phone" placeholder="Телефон (+7...)" required>
  <input type="email" name="email" placeholder="Email" required>
  <div class="form-grid">
    <input type="password" name="password" placeholder="Пароль (мин. 8)" required>
    <input type="password" name="password_confirm" placeholder="Повторите пароль" required>
  </div>
  <label>Сложная CAPTCHA: решите <?= View::e($captchaQuestion ?? '(2 + 2) × 2') ?></label>
  <input type="number" name="captcha" required>
  <button class="btn">Зарегистрироваться</button>
  <a class="card-link" href="<?= View::url('/verify-email') ?>">Подтвердить email (демо)</a>
</form>
