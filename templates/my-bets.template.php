<section class="rates container">
  <h2>Мои ставки</h2>
  <table class="rates__list">
    <?php foreach($bets as $bet): ?>
      <?php
        echo "time: " . get_interval($bet['lot_expiration_date'])->invert;
        if($bet['winner']) {
          $rates_item_class_name = 'rates__item rates__item--win';
          $rates_timer_class_name = 'timer timer--win';
          $rates_timer_content = 'Ставка выиграла';
        } elseif(get_interval($bet['lot_expiration_date'])->invert === 1) {
          $rates_item_class_name = 'rates__item rates__item--end';
          $rates_timer_class_name = 'timer timer--end';
          $rates_timer_content = 'Торги окончены';
        } elseif(is_less_hour($bet['lot_expiration_date'])) {
          $rates_timer_class_name = 'timer timer--finishing';
          $rates_timer_content = htmlspecialchars(get_remaining_time($bet['lot_expiration_date']));
        } else {
          $rates_item_class_name = 'rates__item';
          $rates_timer_class_name = 'timer';
          $rates_timer_content = htmlspecialchars(get_remaining_time($bet['lot_expiration_date']));;
        }
      ?>
      <tr class="<?= $rates_item_class_name; ?>">
        <td class="rates__info">
          <div class="rates__img">
            <img src="../uploads/<?= htmlspecialchars($bet['lot_img_path']); ?>" width="54" height="40" alt="">
          </div>
          <h3 class="rates__title">
            <a href="lot.php?id=<?= htmlspecialchars($bet['lot_id']); ?>"><?= htmlspecialchars($bet['lot_title']); ?></a>
            <p><?= htmlspecialchars($bet['user_contacts']); ?></p>
          </h3>
        </td>
        <td class="rates__category"><?= htmlspecialchars($bet['category_name']); ?></td>
        <td class="rates__timer">
          <div class="<?= $rates_timer_class_name; ?>"><?= $rates_timer_content; ?></div> 
        </td>
        <td class="rates__price"><?= htmlspecialchars(format_price($bet['lot_price'])); ?> р</td>
        <td class="rates__time"><?= htmlspecialchars(get_time_since($bet['published_date'])); ?></td>
      </tr>
    <?php endforeach ?>
  </table>
</section>