<form class="form container <?php if(count($errors)): ?>form--invalid<?php endif; ?>" action="sign-up.php" method="post" autocomplete="off">
  <h2>Регистрация нового аккаунта</h2>
  <div class="form__item <?php if($errors['email']): ?>form__item--invalid<?php endif; ?>">
    <label for="email">E-mail <sup>*</sup></label>
    <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= htmlspecialchars($inputs['email']); ?>">
    <span class="form__error"><?= htmlspecialchars($errors['email']); ?></span>
  </div>
  <div class="form__item <?php if($errors['password']): ?>form__item--invalid<?php endif; ?>">
    <label for="password">Пароль <sup>*</sup></label>
    <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= htmlspecialchars($inputs['password']); ?>">
    <span class="form__error"><?= htmlspecialchars($errors['password']); ?></span>
  </div>
  <div class="form__item <?php if($errors['name']): ?>form__item--invalid<?php endif; ?>">
    <label for="name">Имя <sup>*</sup></label>
    <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= htmlspecialchars($inputs['name']); ?>">
    <span class="form__error"><?= htmlspecialchars($errors['name']); ?></span>
  </div>
  <div class="form__item <?php if($errors['contacts']): ?>form__item--invalid<?php endif; ?>">
    <label for="contacts">Контактные данные <sup>*</sup></label>
    <textarea id="contacts" name="contacts" placeholder="Напишите как с вами связаться" ><?= htmlspecialchars($inputs['contacts']); ?></textarea>
    <span class="form__error"><?= htmlspecialchars($errors['contacts']); ?></span>
  </div>
  <?php if(empty($errors)): ?>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <?php endif ?>
  <button type="submit" class="button">Зарегистрироваться</button>
  <a class="text-link" href="sign-in.php">Уже есть аккаунт</a>
</form>