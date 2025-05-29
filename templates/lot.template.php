<section class="lot-item container">
  <h2><?= htmlspecialchars($lot['title']); ?></h2>
  <div class="lot-item__content">
    <div class="lot-item__left">
      <div class="lot-item__image">
        <img src="../uploads/<?= htmlspecialchars($lot['img_path']); ?>" width="730" height="548" alt="">
      </div>
      <p class="lot-item__category">Категория: <span><?= htmlspecialchars($lot['category']); ?></span></p>
      <p class="lot-item__description"><?= htmlspecialchars($lot['description']); ?></p>
    </div>
    <div class="lot-item__right">
      <?php if(isset($_SESSION['user_id'])): ?>
        <div class="lot-item__state">
          <div class="lot-item__timer timer <?php if(is_less_hour($lot['expiration'])): ?>timer--finishing<?php endif; ?>">
            <?= htmlspecialchars(get_remaining_hours_minutes($lot['expiration'])); ?>
          </div>
          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <span class="lot-item__amount">Текущая цена</span>
              <span class="lot-item__cost"><?= htmlspecialchars(format_price($lot['price'])); ?></span>
            </div>
            <div class="lot-item__min-cost"> Мин. ставка <span><?= htmlspecialchars(format_price($lot['rate_step'])); ?> р</span></div>
          </div>
          <form class="lot-item__form" method="post" autocomplete="off">
            <p class="lot-item__form-item form__item <?php if(!empty($errors)): ?>form__item--invalid<?php endif; ?>">
              <label for="cost">Ваша ставка</label>
              <input
                id="cost"
                type="text"
                name="cost"
                value="<?= htmlspecialchars($inputs['cost']); ?>"
                placeholder="<?= htmlspecialchars($lot['price'] + $lot['rate_step']); ?>"
              >
              <?php foreach($errors as $error): ?>
                <span class="form__error"><?= htmlspecialchars($error); ?></span>
              <?php endforeach; ?>
            </p>
            <button type="submit" class="button">Сделать ставку</button>
          </form>
        </div>
      <?php endif; ?>
      <div class="history">
        <h3>История ставок (<span><?= count($bets); ?></span>)</h3>
        <table class="history__list">
          <?php foreach($bets as $bet) : ?>
            <tr class="history__item">
              <td class="history__name"><?= htmlspecialchars($bet['user_name']); ?></td>
              <td class="history__price"><?= htmlspecialchars(format_price($bet['bet'])); ?> р</td>
              <td class="history__time"><?= htmlspecialchars(get_time_since($bet['published_date'])); ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</section>