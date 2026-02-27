<?php use App\Core\Csrf; use App\Core\View; ?>
<div class="tabs">
  <a class="tab" href="<?= View::url('/catalog') ?>">Каталог</a>
  <a class="tab active" href="#"><?= View::e($product['name']) ?></a>
  <a class="tab" href="<?= View::url('/compare') ?>">Сравнение</a>
</div>
<article class="product card">
  <h1><?= View::e($product['name']) ?></h1>
  <div class="gallery" id="gallery">
    <?php foreach (($product['images'] ?: [['image_url' => '/assets/images/placeholder.svg']]) as $img): ?>
      <a href="<?= View::e($img['image_url']) ?>" target="_blank" title="Открыть zoom"><img loading="lazy" src="<?= View::e($img['image_url']) ?>" alt="<?= View::e($product['name']) ?>"></a>
    <?php endforeach; ?>
  </div>
  <p><?= View::e($product['description']) ?></p>
  <ul>
    <li>Диаметр: R<?= View::e((string)$product['diameter']) ?></li>
    <li>Ширина: <?= View::e((string)$product['width']) ?></li>
    <li>Вылет ET: <?= View::e((string)$product['offset_et']) ?></li>
    <li>Разболтовка: <?= View::e($product['pcd']) ?></li>
    <li>DIA: 66.6</li>
    <li>Материал: <?= View::e($product['material']) ?></li>
    <li>Вес: <?= number_format(((float)$product['width'] * 1.7), 1) ?> кг</li>
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
  <form method="post" action="<?= View::url('/compare/toggle') ?>" class="inline">
    <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
    <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
    <button class="btn ghost">Сравнить</button>
  </form>
  <form method="post" action="<?= View::url('/profile/stock-notify') ?>" class="inline">
    <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
    <button class="btn ghost">Уведомить о поступлении</button>
  </form>
</article>

<section class="card">
  <h2>Отзывы и рейтинг</h2>
  <p>Средний рейтинг: <?= number_format((float)$rating, 1) ?>/5</p>
  <?php foreach ($reviews as $r): ?>
    <div class="row"><strong><?= View::e($r['email'] ?? 'Покупатель') ?></strong><span><?= str_repeat('★', (int)$r['rating']) ?></span><span><?= View::e($r['comment']) ?></span></div>
  <?php endforeach; ?>
  <form method="post" action="<?= View::url('/product/' . rawurlencode((string) $product['slug']) . '/review') ?>" class="auth-form">
    <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
    <select name="rating"><option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option></select>
    <input type="text" name="comment" placeholder="Ваш отзыв" required>
    <button class="btn">Отправить отзыв</button>
  </form>
</section>

<section>
  <h2>Рекомендуемые товары</h2>
  <div class="grid">
    <?php foreach ($recommended as $p): ?>
      <article class="card">
        <h3><?= View::e($p['name']) ?></h3>
        <p class="price"><?= number_format((float)$p['price'], 0, '.', ' ') ?> ₽</p>
        <a class="card-link" href="<?= View::url('/product/' . rawurlencode((string) $p['slug'])) ?>">Открыть</a>
      </article>
    <?php endforeach; ?>
  </div>
</section>
