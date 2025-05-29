<?php
require_once('init.php');
require_once('models.php');
require_once('helpers/sql-helpers.php');
require_once('helpers/common-helpers.php');
require_once('helpers/date-helpers.php');
require_once('helpers/validate-helpers.php');
require_once('constant.php');

session_start();

$query_param = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if(!$query_param) {
  header('Location: 404.php');
  exit();
}

if(!$link) {
	throw new Error(mysqli_connect_error());
}

$errors = [];
$inputs = [];

$query_categories = $get_query_categories();
$categories = get_categories($link, $query_categories);

$query_lot = $get_query_lot_by_id();
$lot = get_mysqli_select_stmt_result($link, $query_lot, [$query_param]);

if(empty($lot)) {
  header('Location: 404.php');
  exit();
}
$lot = $lot[0];

$query_bets = $get_query_bets_by_lot_id();
$bets = get_mysqli_select_stmt_result($link, $query_bets, [$query_param]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $required = ['cost'];
  $price = $lot['price'] + $lot['rate_step'];
  $rules = [
    'cost' => function($value) use($price) {
      return validate_bet($value, $price);
    }
  ];

  $fields = [
    'cost' => FILTER_DEFAULT
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

  if($lot['user_id'] === $_SESSION['user_id']) {
    $errors['user_id'] = 'Нельзя сделать ставку на свой лот.';
  }

  $errors = array_filter($errors);

  if(empty($errors)) {
    $bet_query = $get_query_create_bet();
    $new_bet_id = get_mysqli_insert_stmt_result($link, $bet_query, [$inputs['cost'], $_SESSION['user_id'], $query_param]);
    $inputs = [];
    header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $query_param);
    exit();
  }
}

$lot_content = include_template(
  'lot.template.php',
  [
		'lot' => $lot,
    'bets' => $bets,
    'errors' => $errors,
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
    'title' => $lot['title'],
    'is_home' => false,
    'content' => $lot_content,
    'navigation' => $navigation_content
  ]
);

print($layout_content);
?>