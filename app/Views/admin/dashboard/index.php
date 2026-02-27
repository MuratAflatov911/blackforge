<h1>Админ-панель</h1>
<p>Заказы: <?= (int)$stats['sales']['orders_count'] ?></p>
<p>Выручка: <?= number_format((float)$stats['sales']['revenue'], 0, '.', ' ') ?> ₽</p>
<h2>Популярные товары</h2>
<?php foreach ($stats['popular'] as $p): ?>
  <div class="row"><span><?= htmlspecialchars($p['name']) ?></span><span><?= (int)$p['sold'] ?> шт.</span></div>
<?php endforeach; ?>
