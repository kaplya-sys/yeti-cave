<?= $navigation; ?>
<div class="container">
  <section class="lots">
    <h2>Результаты поиска по запросу «<span><?= htmlspecialchars($search_value); ?></span>»</h2>
    <?php if(empty($lots)): ?>
      <p>Ничего не найдено по вашему запросу.</p>
    <?php else: ?>
      <ul class="lots__list">
        <?php foreach($lots as $lot): ?>
          <li class="lots__item lot">
            <div class="lot__image">
              <img src="../uploads/<?= htmlspecialchars($lot['img_path']); ?>" width="350" height="260" alt="">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?= htmlspecialchars($category['name']); ?></span>
              <h3 class="lot__title">
                <a class="text-link" href="lot.php?id=<?= htmlspecialchars($lot['id']); ?>"><?= htmlspecialchars($lot['title']); ?></a>
              </h3>
              <div class="lot__state">
                <div class="lot__rate">
                  <span class="lot__amount">Стартовая цена</span>
                  <span class="lot__cost"><?= htmlspecialchars(format_price($lot['price'])); ?><b class="rub">р</b></span>
                </div>
                <div class="lot__timer timer <?php if(is_less_hour($lot['expiration'])): ?>timer--finishing<?php endif; ?>">
                  <?= htmlspecialchars(get_remaining_time($lot['expiration'])); ?>
                </div>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </section>
  <?php if($pages > 1): ?>
    <ul class="pagination-list">
      <li class="pagination-item pagination-item-prev">
        <?php if($current_page > 1): ?>
          <a href="lots.php?search=<?= htmlspecialchars($search_value); ?>&page=<?= $current_page - 1 ?>">Назад</a>
        <?php else: ?>
          <span href="#">Назад</span>
        <?php endif; ?>
      </li>
      <?php for($i = 1; $i <= $pages; $i++): ?>
        <li class="pagination-item <?php if($current_page === $i) : ?>pagination-item-active<?php endif; ?>">
          <a href="search.php?search=<?= htmlspecialchars($search_value); ?>&page=<?= $i ?>"><?= $i ?></a>
        </li>
      <?php endfor; ?>
      <li class="pagination-item pagination-item-next">
        <?php if($current_page < $pages): ?>
          <a href="lots.php?search=<?= htmlspecialchars($search_value); ?>&page=<?= $current_page + 1 ?>">Вперед</a>
        <?php else: ?>
          <span href="#">Вперед</span>
        <?php endif; ?>
      </li>
    </ul>
  <?php endif; ?>
</div> 