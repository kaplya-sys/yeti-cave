<form class="form container <?php if(count($errors)): ?>form--invalid<?php endif; ?>" action="sign-in.php" method="post">
  <h2>Вход</h2>
  <div class="form__item <?php if($errors['email']): ?>form__item--invalid<?php endif; ?>">
    <label for="email">E-mail <sup>*</sup></label>
    <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= htmlspecialchars($inputs['email']); ?>">
    <span class="form__error"><?= htmlspecialchars($errors['email']); ?></span>
  </div>
  <div class="form__item form__item--last <?php if($errors['password']): ?>form__item--invalid<?php endif; ?>">
    <label for="password">Пароль <sup>*</sup></label>
    <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= htmlspecialchars($inputs['password']); ?>">
    <span class="form__error"><?= htmlspecialchars($errors['password']); ?></span>
  </div>
  <?php if(empty($errors)): ?>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <?php endif ?>
  <button type="submit" class="button">Войти</button>
</form>