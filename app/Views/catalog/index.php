<?php use App\Core\View; ?>
<h1>Каталог BLACKFORGE</h1>
<form class="filters" method="get">
  <select name="diameter"><option value="">Диаметр</option><?php for($i=15;$i<=22;$i++): ?><option value="<?= $i ?>" <?= (string)$filters['diameter']===(string)$i?'selected':'' ?>>R<?= $i ?></option><?php endfor; ?></select>
  <select name="material"><option value="">Материал</option><option value="литые">Литые</option><option value="кованые">Кованые</option></select>
  <select name="type"><option value="">Тип</option><option value="спортивные">Спортивные</option><option value="люкс">Люкс</option></select>
  <select name="manufacturer_id"><option value="">Производитель</option><?php foreach ($manufacturers as $m): ?><option value="<?= (int)$m['id'] ?>"><?= View::e($m['name']) ?></option><?php endforeach; ?></select>
  <select name="sort"><option value="new">Новизна</option><option value="popular">Популярность</option><option value="price_asc">Цена ↑</option><option value="price_desc">Цена ↓</option></select>
  <button class="btn">Применить</button>
</form>
<div class="grid">
  <?php foreach ($products as $p): ?>
    <article class="card">
      <h3><?= View::e($p['name']) ?></h3>
      <p><?= View::e($p['manufacturer_name']) ?> • <?= View::e($p['type']) ?></p>
      <p class="price"><?= number_format((float)$p['price'], 0, '.', ' ') ?> ₽</p>
      <a href="<?= View::url('/product/' . rawurlencode((string) $p['slug'])) ?>">Карточка товара</a>
    </article>
  <?php endforeach; ?>
</div>
