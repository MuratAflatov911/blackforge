<?php use App\Core\View; ?>
<section class="hero">
  <h1>Премиальные диски для премиальных авто</h1>
  <p>Люксовые, спортивные, кованые и литые модели в строгом стиле BLACKFORGE.</p>
  <a class="btn" href="<?= View::url('/catalog') ?>">Перейти в каталог</a>
</section>
<section>
  <h2>Популярные модели</h2>
  <div class="grid">
    <?php foreach ($products as $p): ?>
      <article class="card">
        <h3><?= View::e($p['name']) ?></h3>
        <p>R<?= View::e((string)$p['diameter']) ?> • <?= View::e($p['material']) ?></p>
        <p class="price"><?= number_format((float)$p['price'], 0, '.', ' ') ?> ₽</p>
        <a href="<?= View::url('/product/' . rawurlencode((string) $p['slug'])) ?>">Подробнее</a>
      </article>
    <?php endforeach; ?>
  </div>
</section>
