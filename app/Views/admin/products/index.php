<?php use App\Core\Csrf; use App\Core\View; ?>
<div class="tabs">
  <a class="tab" href="<?= View::url('/admin') ?>">Дашборд</a>
  <a class="tab active" href="<?= View::url('/admin/products') ?>">Товары / CRUD</a>
  <a class="tab" href="<?= View::url('/admin/orders') ?>">Заказы</a>
</div>
<h1>Управление товарами</h1>
<form method="post" action="<?= View::url('/admin/products') ?>" class="card auth-form">
  <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
  <input type="text" name="name" placeholder="Название">
  <input type="text" name="slug" placeholder="Slug">
  <input type="number" name="price" placeholder="Цена">
  <input type="number" name="stock" placeholder="Наличие">
  <input type="text" name="image_url" placeholder="URL изображения">
  <button class="btn">Добавить товар</button>
</form>
<p>Для загрузки с устройства используйте папку <code>public/assets/images</code>. Для URL — поле выше.</p>
<?php foreach ($products as $p): ?>
  <div class="row card"><span><?= View::e($p['name']) ?></span><span><?= number_format((float)$p['price'], 0, '.', ' ') ?> ₽</span><span>stock: <?= (int)$p['stock'] ?></span></div>
<?php endforeach; ?>
