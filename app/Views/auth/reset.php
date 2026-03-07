<?php use App\Core\Csrf; use App\Core\View; ?>
<h1>Новый пароль</h1>
<form method="post" action="<?= View::url('/reset-password') ?>" class="auth-form card">
  <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
  <input type="password" name="password" placeholder="Новый пароль" required>
  <button class="btn">Сохранить пароль</button>
</form>
