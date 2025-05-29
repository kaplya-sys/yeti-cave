<?php
/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $query string SQL запрос в виде строки
 * @param array $data Данные для вставки
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $query, $data = []) {
  $stmt = mysqli_prepare($link, $query);

  if ($stmt === false) {
    die('Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link));
  }

  if ($data) {
    $types = '';
    $stmt_data = [];

    foreach ($data as $value) {
      $type = 's';

      if (is_int($value)) {
        $type = 'i';
      }
      else if (is_string($value)) {
        $type = 's';
      }
      else if (is_double($value)) {
        $type = 'd';
      }

      if ($type) {
        $types .= $type;
        $stmt_data[] = $value;
      }
    }

    mysqli_stmt_bind_param($stmt, $types, ...$stmt_data);
    mysqli_stmt_execute($stmt);

    if (mysqli_errno($link) > 0) {
      die('Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link));
    }
  }

  return $stmt;
}
/**
 * Создает подготовленное выражение на основе готового SQL запроса и возвращает результат успешного запроса
 *
 * @param $link mysqli Ресурс соединения
 * @param $query string SQL запрос в виде строки
 *
 * @return array Одна строка результата в виде ассоциативного массива или все строки в виде массива
 */
function get_mysqli_result(mysqli $link, string $query) {
  $result = mysqli_query($link, $query);

  if(!$result) {
    die(mysqli_error($link));
  }

  return mysqli_fetch_all($result, MYSQLI_ASSOC);
};
/**
 * Создает подготовленное выражение на основе готового SQL, переданных данных запроса и возвращает результат успешного запроса
 *
 * @param $link mysqli Ресурс соединения
 * @param $query string SQL запрос в виде строки
 * @param array $data Данные для вставки
 *
 * @return array Одна строка результата в виде ассоциативного массива или все строки в виде массива
 */
function get_mysqli_select_stmt_result(mysqli $link, string $query, array $data) {
  $stmt = db_get_prepare_stmt($link, $query, $data);
  $result = mysqli_stmt_get_result($stmt);

  if(!$result) {
    die(mysqli_error($link));
  }

  return mysqli_fetch_all($result, MYSQLI_ASSOC);
};
/**
 * Создает подготовленное выражение на основе готового SQL, переданных данных запроса и возвращает id новой записи
 *
 * @param $link mysqli Ресурс соединения
 * @param $query string SQL запрос в виде строки
 * @param array $data Данные для вставки
 *
 * @return array Одна строка результата в виде ассоциативного массива или все строки в виде массива
 */
function get_mysqli_insert_stmt_result(mysqli $link, string $query, array $data) {
  db_get_prepare_stmt($link, $query, $data);
  $new_record_id = mysqli_insert_id($link);

  if(!$new_record_id) {
    die(mysqli_error($link));
  }

  return $new_record_id;
};
/**
 * Возвращает ассоциативный массив категорий в виде "имя категории => кодовое имя категории"
 *
 * @param $link mysqli Ресурс соединения
 * @param $query string SQL запрос в виде строки
 *
 * @return array Ассоциативный массив категорий
 */
function get_categories(mysqli $link, string $query) {
  $categories = get_mysqli_result($link, $query);

  foreach($categories as $index => $item) {
    $categories[$item['key']] = $item['value'];
    unset($categories[$index]);
  }

  return $categories;
};
?>