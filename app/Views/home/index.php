<?php use App\Core\Csrf; use App\Core\View; ?>
<div class="tabs">
  <a class="tab active" href="<?= View::url('/') ?>">Главная</a>
  <a class="tab" href="<?= View::url('/catalog') ?>">Каталог</a>
  <a class="tab" href="<?= View::url('/about') ?>">О нас</a>
</div>

<section class="home-section hero-block card">
  <div>
    <h1>BLACKFORGE — премиальные диски для автомобилей премиум‑класса</h1>
    <p>Современный дизайн, инженерная точность и строгая черно‑золотая эстетика.</p>
    <a class="btn" href="<?= View::url('/catalog') ?>">Перейти в каталог</a>
  </div>
  <div class="hero-stats">
    <div><strong>5000+</strong><span>дисков в каталоге</span></div>
    <div><strong>24/7</strong><span>поддержка клиентов</span></div>
    <div><strong>12 мес.</strong><span>официальная гарантия</span></div>
  </div>
</section>

<section class="home-section card">
  <h2>Подбор дисков по автомобилю</h2>
  <form class="filters" method="get" action="<?= View::url('/catalog') ?>">
    <select name="brand">
      <option value="">Марка</option>
      <?php foreach ($autoData as $brand => $models): ?>
        <option value="<?= View::e($brand) ?>"><?= View::e($brand) ?></option>
      <?php endforeach; ?>
    </select>
    <select name="model"><option value="">Модель</option><option>M3</option><option>M5</option><option>Q7</option><option>911</option></select>
    <select name="year"><option value="">Год</option><?php for ($y = date('Y'); $y >= 2000; $y--): ?><option><?= $y ?></option><?php endfor; ?></select>
    <button class="btn">Подобрать</button>
  </form>
</section>

<section class="home-section">
  <div class="section-head"><h2>Популярные диски</h2><a class="card-link" href="<?= View::url('/catalog?sort=popular') ?>">Смотреть все</a></div>
  <div class="grid">
    <?php foreach ($popularProducts as $p): ?>
      <article class="card">
        <h3><?= View::e($p['name']) ?></h3>
        <p>R<?= View::e((string)$p['diameter']) ?> • <?= View::e($p['material']) ?></p>
        <p class="price"><?= number_format((float)$p['price'], 0, '.', ' ') ?> ₽</p>
        <a class="card-link" href="<?= View::url('/product/' . rawurlencode((string) $p['slug'])) ?>">Подробнее</a>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="home-section">
  <div class="section-head"><h2>Новинки</h2><a class="card-link" href="<?= View::url('/catalog?sort=new') ?>">Все новинки</a></div>
  <div class="grid">
    <?php foreach ($newProducts as $p): ?>
      <article class="card">
        <h3><?= View::e($p['name']) ?></h3>
        <p><?= View::e($p['color']) ?> • ET<?= View::e((string)$p['offset_et']) ?></p>
        <a class="card-link" href="<?= View::url('/product/' . rawurlencode((string) $p['slug'])) ?>">Смотреть</a>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="home-section grid">
  <article class="card"><h3>Качество</h3><p>Оригинальные диски и строгий контроль качества каждой партии.</p></article>
  <article class="card"><h3>Гарантия</h3><p>12 месяцев гарантии и программа быстрой замены при заводском браке.</p></article>
  <article class="card"><h3>Доставка</h3><p>Бережная упаковка и быстрая доставка по всей России.</p></article>
</section>

<section class="home-section grid">
  <form method="post" action="<?= View::url('/newsletter') ?>" class="card auth-form">
    <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
    <h3>Подписка на новости</h3>
    <input type="email" name="email" placeholder="Ваш email" required>
    <button class="btn">Подписаться</button>
  </form>
  <form method="post" action="<?= View::url('/chat') ?>" class="card auth-form">
    <input type="hidden" name="_csrf" value="<?= Csrf::token() ?>">
    <h3>Онлайн-чат</h3>
    <input type="text" name="message" placeholder="Ваш вопрос" required>
    <button class="btn ghost">Отправить</button>
  </form>
</section>
