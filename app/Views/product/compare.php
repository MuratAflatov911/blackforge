<?php use App\Core\View; ?>
<div class="tabs">
  <a class="tab" href="<?= View::url('/catalog') ?>">Каталог</a>
  <a class="tab active" href="<?= View::url('/compare') ?>">Сравнение</a>
</div>
<h1>Сравнение товаров</h1>
<?php if (empty($products)): ?>
  <p>Добавьте до 4 товаров для сравнения.</p>
<?php else: ?>
  <div class="grid">
    <?php foreach ($products as $p): ?>
      <article class="card">
        <h3><?= View::e($p['name']) ?></h3>
        <p>R<?= View::e((string)$p['diameter']) ?> • ET<?= View::e((string)$p['offset_et']) ?> • <?= View::e($p['pcd']) ?></p>
        <p><?= View::e($p['material']) ?> • <?= View::e($p['type']) ?></p>
        <p class="price"><?= number_format((float)$p['price'], 0, '.', ' ') ?> ₽</p>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
