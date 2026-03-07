<?php use App\Core\View; ?>
<div class="tabs">
  <a class="tab active" href="<?= View::url('/admin') ?>">Аналитика</a>
  <a class="tab" href="<?= View::url('/admin/products') ?>">Товары</a>
  <a class="tab" href="<?= View::url('/admin/orders') ?>">Заказы</a>
  <a class="tab" href="<?= View::url('/admin/users') ?>">Пользователи</a>
</div>
<h1>Админ-панель</h1>
<div class="grid">
  <div class="card"><h3>Общий доход</h3><p class="price"><?= number_format((float)$stats['sales']['revenue'], 0, '.', ' ') ?> ₽</p></div>
  <div class="card"><h3>Количество заказов</h3><p><?= (int)$stats['sales']['orders_count'] ?></p></div>
  <div class="card"><h3>Конверсия</h3><p>3.8% (демо)</p></div>
  <div class="card"><h3>График продаж</h3><p>Неделя: +14% (демо)</p></div>
</div>
<h2>Популярные товары</h2>
<?php foreach ($stats['popular'] as $p): ?>
  <div class="row card"><span><?= htmlspecialchars($p['name']) ?></span><span><?= (int)$p['sold'] ?> шт.</span></div>
<?php endforeach; ?>
<section class="card">
  <h2>SEO и контент</h2>
  <p>Управление meta-тегами, ЧПУ, sitemap и статическими страницами доступно через файлы `app/Views/pages/*` и `public/sitemap.xml`.</p>
</section>
<section class="card">
  <h2>Логирование</h2>
  <p>Логи входа и действий администраторов в демо режиме хранятся в `storage/logs`.</p>
</section>
