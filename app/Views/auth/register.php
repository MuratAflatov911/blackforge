<?php use App\Core\Csrf; ?>
<h1>Регистрация</h1>
<form method="post" action="/register" class="auth-form">
  <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Пароль (мин. 8)" required>
  <label>CAPTCHA: введите сумму <?= (int)$captcha ?></label>
  <input type="number" name="captcha" required>
  <button class="btn">Зарегистрироваться</button>
</form>
