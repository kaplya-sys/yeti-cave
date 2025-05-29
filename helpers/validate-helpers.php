<?php
require_once('date-helpers.php');

function validate_value_length(string $value, int $min, int $max) {
  $length = mb_strlen($value, 'UTF-8');

  if ($length < $min) {
    return "Длина поля не менее $min символов.";
  }

  if ($length > $max) {
    return "Длина поля не более $max символов.";
  }

  return null;
}

function validate_email(string $value) {
  if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
    return "Некорректный email адрес";
  }

  return null;
}

function validate_password_hash(string $password, string $hash) {
  if (!password_verify($password, $hash)) {
    return "Вы ввели неверный пароль.";
  }

  return null;
}

function validate_category(string $value, array $categories) {
  if (!array_key_exists($value, $categories)) {
    return "Не удалось найти данную категорию.";
  }

  return null;
}

function validate_date(string $value) {
  if (!is_date_valid($value)) {
    return "Не верный формат даты.";
  }

  return null;
}

function validate_number(int $value) {
  if (!is_int($value) || $value <= 0) {
    return "Должно быть целое число больше нуля.";
  }

  return null;
}

function validate_bet(int $value, int $current_price) {
  if (!is_int($value) || $value < $current_price) {
    return "Ваша ставка должна быть больше или равна, чем текущая цена лота + мин. ставка.";
  }

  return null;
}
?>