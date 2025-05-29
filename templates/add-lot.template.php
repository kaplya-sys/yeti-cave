<form class="form form--add-lot container <?php if(count($errors)): ?>form--invalid<?php endif; ?>" action="add-lot.php" method="post" enctype="multipart/form-data">
  <h2>Добавление лота</h2>
  <div class="form__container-two">
    <div class="form__item <?php if($errors['lot-name']): ?>form__item--invalid<?php endif; ?>">
      <label for="lot-name">Наименование <sup>*</sup></label>
      <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?= htmlspecialchars($inputs['lot-name']); ?>">
      <span class="form__error"><?= htmlspecialchars($errors['lot-name']); ?></span>
    </div>
    <div class="form__item <?php if($errors['lot-category']): ?>form__item--invalid<?php endif; ?>">
      <label for="lot-category">Категория <sup>*</sup></label>
      <select id="lot-category" name="lot-category">
        <option value="">Выберите категорию</option>
        <?php foreach($categories as $key => $value): ?>
          <option value="<?= htmlspecialchars($key); ?>" <?php if($inputs['lot-category'] === $key): ?>selected<?php endif; ?>><?= htmlspecialchars($value); ?></option>
        <?php endforeach; ?>
      </select>
      <span class="form__error"><?= htmlspecialchars($errors['lot-category']); ?></span>
    </div>
  </div>
  <div class="form__item form__item--wide <?php if($errors['lot-description']): ?>form__item--invalid<?php endif; ?>">
    <label for="lot-description">Описание <sup>*</sup></label>
    <textarea id="lot-description" name="lot-description" placeholder="Напишите описание лота"><?= htmlspecialchars($inputs['lot-description']); ?></textarea>
    <span class="form__error"><?= htmlspecialchars($errors['lot-description']); ?></span>
  </div>
  <div class="form__item form__item--file <?php if($errors['file']): ?>form__item--invalid<?php endif; ?>">
    <label>Изображение <sup>*</sup></label>
    <div class="form__input-file">
      <input class="visually-hidden" type="file" id="lot-img" name="image">
      <label for="lot-img">Добавить</label>
      <span class="form__error"><?= htmlspecialchars($errors['file']); ?></span>
    </div>
  </div>
  <div class="form__container-three">
    <div class="form__item form__item--small <?php if($errors['lot-rate']): ?>form__item--invalid<?php endif; ?>">
      <label for="lot-rate">Начальная цена <sup>*</sup></label>
      <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?= htmlspecialchars($inputs['lot-rate']); ?>">
      <span class="form__error"><?= htmlspecialchars($errors['lot-rate']); ?></span>
    </div>
    <div class="form__item form__item--small <?php if($errors['lot-step']): ?>form__item--invalid<?php endif; ?>">
      <label for="lot-step">Шаг ставки <sup>*</sup></label>
      <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?= htmlspecialchars($inputs['lot-step']); ?>">
      <span class="form__error"><?= htmlspecialchars($errors['lot-step']); ?></span>
    </div>
    <div class="form__item <?php if($errors['lot-date']): ?>form__item--invalid<?php endif; ?>">
      <label for="date-fp">Дата окончания торгов <sup>*</sup></label>
      <input class="form__input-date" id="date-fp" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= htmlspecialchars($inputs['lot-date']); ?>">
      <span class="form__error"><?= $errors['lot-date']; ?></span>
    </div>
  </div>
  <?php if(!empty($errors)): ?>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <?php endif ?>
  <button type="submit" class="button">Добавить лот</button>
</form>