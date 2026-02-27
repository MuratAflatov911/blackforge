<?php use App\Core\View; ?>
<div class="tabs">
  <a class="tab active" href="<?= View::url('/catalog') ?>">Каталог</a>
  <a class="tab" href="<?= View::url('/compare') ?>">Сравнение</a>
  <a class="tab" href="<?= View::url('/delivery') ?>">Доставка</a>
</div>

<h1>Каталог BLACKFORGE</h1>
<form class="filters card" method="get">
  <select name="diameter"><option value="">Диаметр</option><?php for($i=15;$i<=24;$i++): ?><option value="<?= $i ?>" <?= (string)$filters['diameter']===(string)$i?'selected':'' ?>>R<?= $i ?></option><?php endfor; ?></select>
  <input type="text" name="pcd" placeholder="PCD (например 5x112)" value="<?= View::e((string)($filters['pcd'] ?? '')) ?>">
  <input type="number" step="0.1" name="width" placeholder="Ширина" value="<?= View::e((string)($filters['width'] ?? '')) ?>">
  <input type="number" name="offset_et" placeholder="ET" value="<?= View::e((string)($filters['offset_et'] ?? '')) ?>">
  <select name="manufacturer_id"><option value="">Производитель</option><?php foreach ($manufacturers as $m): ?><option value="<?= (int)$m['id'] ?>" <?= (string)$filters['manufacturer_id']===(string)$m['id']?'selected':'' ?>><?= View::e($m['name']) ?></option><?php endforeach; ?></select>
  <select name="material"><option value="">Материал</option><option value="литые">Литые</option><option value="кованые">Кованые</option></select>
  <select name="type"><option value="">Тип</option><option value="спортивные">Спортивные</option><option value="люкс">Люкс</option><option value="премиальные">Премиальные</option></select>
  <input type="text" name="color" placeholder="Цвет" value="<?= View::e((string)($filters['color'] ?? '')) ?>">
  <input type="number" name="price_min" placeholder="Цена от" value="<?= View::e((string)($filters['price_min'] ?? '')) ?>">
  <input type="number" name="price_max" placeholder="Цена до" value="<?= View::e((string)($filters['price_max'] ?? '')) ?>">
  <select name="in_stock"><option value="">Наличие</option><option value="1">В наличии</option></select>
  <select name="sort"><option value="new">По новизне</option><option value="popular">По популярности</option><option value="price_asc">Цена ↑</option><option value="price_desc">Цена ↓</option></select>
  <button class="btn">Применить</button>
</form>
<div class="grid">
  <?php foreach ($products as $p): ?>
    <article class="card">
      <h3><?= View::e($p['name']) ?></h3>
      <p><?= View::e($p['manufacturer_name']) ?> • <?= View::e($p['type']) ?></p>
      <p>R<?= View::e((string)$p['diameter']) ?> • <?= View::e($p['pcd']) ?> • ET<?= View::e((string)$p['offset_et']) ?></p>
      <p class="price"><?= number_format((float)$p['price'], 0, '.', ' ') ?> ₽</p>
      <a class="card-link" href="<?= View::url('/product/' . rawurlencode((string) $p['slug'])) ?>">Карточка товара</a>
    </article>
  <?php endforeach; ?>
</div>
