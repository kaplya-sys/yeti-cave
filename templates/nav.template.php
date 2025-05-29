<nav class="nav">
  <ul class="nav__list container">
    <?php foreach($categories as $key => $value): ?>
      <li class="nav__item <?php if($key === $currentKey): ?>nav__item--current<?php endif; ?>">
        <a href="lots.php?category=<?= htmlspecialchars($key); ?>"><?= htmlspecialchars($value); ?></a>
      </li>
    <?php endforeach; ?>
  </ul>
</nav>