<?php use App\Core\Csrf; use App\Core\View; ?>
<div class="tabs">
  <a class="tab" href="<?= View::url('/catalog') ?>">Каталог</a>
  <a class="tab active" href="#"><?= View::e($product['name']) ?></a>
</div>
<article class="product card">
  <h1><?= View::e($product['name']) ?></h1>
  <div class="gallery">
    <?php foreach (($product['images'] ?: [['image_url' => '/assets/images/placeholder.svg']]) as $img): ?>
      <img loading="lazy" src="<?= View::e($img['image_url']) ?>" alt="<?= View::e($product['name']) ?>">
    <?php endforeach; ?>
  </div>
  <p><?= View::e($product['description']) ?></p>
  <ul>
    <li>Диаметр: R<?= View::e((string)$product['diameter']) ?></li>
    <li>Ширина: <?= View::e((string)$product['width']) ?></li>
    <li>Вылет ET: <?= View::e((string)$product['offset_et']) ?></li>
    <li>Разболтовка: <?= View::e($product['pcd']) ?></li>
    <li>Цвет: <?= View::e($product['color']) ?></li>
    <li>Наличие: <?= (int)$product['stock'] > 0 ? 'В наличии' : 'Нет в наличии' ?></li>
  </ul>
  <p class="price"><?= number_format((float)$product['price'], 0, '.', ' ') ?> ₽</p>

  <form method="post" action="<?= View::url('/cart/add') ?>" class="inline">
    <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
    <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
    <input type="number" name="quantity" min="1" value="1">
    <button class="btn">Добавить в корзину</button>
  </form>
  <form method="post" action="<?= View::url('/favorites/toggle') ?>" class="inline">
    <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
    <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
    <button class="btn ghost">В избранное</button>
  </form>
</article>
