<?php use App\Core\Csrf; use App\Core\View; ?>
<h1>Товары (CRUD)</h1>
<form method="post" action="/admin/products">
  <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
  <button class="btn">Создать товар (демо)</button>
</form>
<?php foreach ($products as $p): ?>
  <div class="row"><span><?= View::e($p['name']) ?></span><span><?= number_format((float)$p['price'], 0, '.', ' ') ?> ₽</span></div>
<?php endforeach; ?>
