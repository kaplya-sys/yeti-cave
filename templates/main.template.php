<section class="promo">
  <h2 class="promo__title">Нужен стафф для катки?</h2>
  <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
  <ul class="promo__list">
    <?php foreach($categories as $key => $value): ?>
      <li class="promo__item promo__item--<?= htmlspecialchars($key); ?>">
        <a class="promo__link" href="lots.php?category=<?= htmlspecialchars($key); ?>"><?= htmlspecialchars($value); ?></a>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
<section class="lots">
  <div class="lots__header">
    <h2>Открытые лоты</h2>
  </div>
  <ul class="lots__list">
    <?php foreach($lots as $lot): ?>
      <li class="lots__item lot">
        <div class="lot__image">
          <img src="../uploads/<?= htmlspecialchars($lot["img_path"]); ?>" width="350" height="260" alt="<?= htmlspecialchars($lot["title"]); ?>">
        </div>
        <div class="lot__info">
          <span class="lot__category"><?= htmlspecialchars($lot["category"]); ?></span>
          <h3 class="lot__title">
            <a class="text-link" href="lot.php?id=<?= htmlspecialchars($lot['id']); ?>"><?= htmlspecialchars($lot["title"]); ?></a>
          </h3>
          <div class="lot__state">
            <div class="lot__rate">
              <span class="lot__amount">Стартовая цена</span>
              <span class="lot__cost"><?= htmlspecialchars(format_price($lot["price"])); ?> ₽</span>
            </div>
            <div class="lot__timer timer <?php if(htmlspecialchars(is_less_hour($lot['expiration']))): ?>timer--finishing<?php endif; ?>">
              <?= htmlspecialchars(get_remaining_time($lot["expiration"])); ?>
            </div>
          </div>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
