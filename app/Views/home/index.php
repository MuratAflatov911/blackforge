<?php use App\Core\View; ?>
<div class="tabs">
  <a class="tab active" href="<?= View::url('/') ?>">Обзор</a>
  <a class="tab" href="<?= View::url('/catalog') ?>">Модели</a>
  <a class="tab" href="<?= View::url('/favorites') ?>">Избранное</a>
</div>

<section class="hero">
  <h1>Минимализм. Статус. BLACKFORGE.</h1>
  <p>Премиальные диски в строгой черно‑золотой эстетике для современных автомобилей.</p>
  <a class="btn" href="<?= View::url('/catalog') ?>">Открыть каталог</a>
</section>
<section>
  <h2>Популярные модели</h2>
  <div class="grid">
    <?php foreach ($products as $p): ?>
      <article class="card">
        <h3><?= View::e($p['name']) ?></h3>
        <p>R<?= View::e((string)$p['diameter']) ?> • <?= View::e($p['material']) ?></p>
        <p class="price"><?= number_format((float)$p['price'], 0, '.', ' ') ?> ₽</p>
        <a class="card-link" href="<?= View::url('/product/' . rawurlencode((string) $p['slug'])) ?>">Подробнее</a>
      </article>
    <?php endforeach; ?>
  </div>
</section>
