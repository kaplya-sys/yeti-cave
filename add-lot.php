<?php
require_once('init.php');
require_once('models.php');
require_once('helpers/sql-helpers.php');
require_once('helpers/common-helpers.php');
require_once('helpers/date-helpers.php');
require_once('helpers/validate-helpers.php');
require_once('constant.php');

session_start();

if (!isset($_SESSION['user_id'])) {
  http_response_code(403);
  header('Content-Type: text/html; charset=utf-8');
  exit('<h1>403 Доступ запрещен</h1><p>Для доступа к этой странице требуется авторизация.</p>');
}

if(!$link) {
	throw new Error(mysqli_connect_error());
}

$errors = [];
$inputs = [];
$query_categories = $get_query_categories();
$categories = get_categories($link, $query_categories);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $required = ['lot-name', 'lot-category', 'lot-description', 'lot-rate', 'lot-step', 'lot-date'];
  $rules = [
    'lot-name' => function($value) use($lot_name_length) {
      return validate_value_length($value, $lot_name_length['min'], $lot_name_length['max']);
    },
    'lot-category' => function($value) use($categories) {
      return validate_category($value, $categories);
    },
    'lot-description' => function($value) use($lot_description_length) {
      return validate_value_length($value, $lot_description_length['min'], $lot_description_length['max']);
    },
    'lot-rate' => function($value) {
      return validate_number($value);
    },
    'lot-step' => function($value) {
      return validate_number($value);
    },
    'lot-date' => function($value) {
      return validate_date($value);
    }
  ];

  $fields = [
    'lot-name' => FILTER_DEFAULT,
    'lot-category' => FILTER_DEFAULT,
    'lot-description' => FILTER_DEFAULT,
    'lot-rate' => FILTER_DEFAULT,
    'lot-step' => FILTER_DEFAULT,
    'lot-date' => FILTER_DEFAULT,
  ];

  $inputs = filter_input_array(INPUT_POST, $fields, true);

  foreach($inputs as $key => $value) {
    if (in_array($key, $required) && empty($value)) {
        $errors[$key] = "Поле обязательно для заполнения";
    } elseif (isset($rules[$key])) {
        $error = $rules[$key]($value);
        if ($error) {
            $errors[$key] = $error;
        }
    }
  }

  if (!empty($_FILES['image']['name'])) {
    $tmp_name = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_extension = array_pop(explode('.', $_FILES['image']['name']));
    $file_name = uniqid();
    $file = $file_name . '.' . $file_extension;

    if ($file_type !== $image_type['jpeg'] && $file_type !== $image_type['png']) {
      $errors['file'] = 'Не верный формат файла';
    } else {
      move_uploaded_file($tmp_name, 'uploads/' . $file);
      $lot_img['path'] = $file;
    }
  } else {
    $errors['file'] = 'Загрузите файл в формате: png, jpg или jpeg';
  }

  $errors = array_filter($errors);

  if(empty($errors)) {
    $query_category = $get_query_category_by_name();
    $category = get_mysqli_select_stmt_result($link, $query_category, [$inputs['lot-category']]);
    $lot_query = $get_query_create_lot();
    $new_lot_id = get_mysqli_insert_stmt_result($link, $lot_query, [
      $inputs['lot-name'],
      $inputs['lot-description'],
      $lot_img['path'],
      $inputs['lot-rate'],
      $inputs['lot-step'],
      $inputs['lot-date'],
      $_SESSION['user_id'],
      $category[0]['id']
    ]);
    $lot_query = $get_query_lot_by_id();
    $lot = get_mysqli_select_stmt_result($link, $lot_query, [$new_lot_id]);
    $lot_id = $lot[0]['id'];
    header("Location: /lot.php?id=$lot_id");
    $inputs = [];
    exit();
  }
}

$form_content = include_template(
  'add-lot.template.php',
  [
    'errors' => $errors,
    'categories' => $categories,
    'inputs' => $inputs
  ]
);
$navigation_content = include_template(
  'nav.template.php',
  ['categories' => $categories]
);
$layout_content = include_template(
  'layout.template.php',
  [
    'title' => $page_title['add-lot'],
    'is_home' => false,
    'content' => $form_content,
    'navigation' => $navigation_content
  ]
);

print($layout_content);
?>