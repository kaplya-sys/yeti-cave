<?php
require_once('helpers.php');
?>

<section class="promo">
  <h2 class="promo__title">Нужен стафф для катки?</h2>
  <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
  <ul class="promo__list">
    <?php foreach ($categories as $key => $value) : ?>
      <li class="promo__item promo__item--<?= $key; ?>">
        <a class="promo__link" href="pages/all-lots.html"><?= $value; ?></a>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
<section class="lots">
  <div class="lots__header">
    <h2>Открытые лоты</h2>
  </div>
  <ul class="lots__list">
    <?php foreach ($offers as $offer) : ?>
      <li class="lots__item lot">
        <div class="lot__image">
          <img src="<?= $offer["img_url"]; ?>" width="350" height="260" alt="<?= htmlspecialchars($offer["title"]); ?>">
        </div>
        <div class="lot__info">
          <span class="lot__category"><?= $offer["category"]; ?></span>
          <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?= htmlspecialchars($offer["title"]); ?></a></h3>
          <div class="lot__state">
            <div class="lot__rate">
              <span class="lot__amount">Стартовая цена</span>
              <span class="lot__cost"><?= format_price(htmlspecialchars($offer["price"])); ?></span>
            </div>
            <?php [$hour, $minutes] = get_dt_range(htmlspecialchars($offer["expiration"])); ?>
            <div class="lot__timer timer <?php if ($hour < 1): ?>timer--finishing<?php endif; ?>">
              <?= "$hour:$minutes" ?>
            </div>
          </div>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</section>
