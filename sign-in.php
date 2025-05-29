<?php
require_once('init.php');
require_once('models.php');
require_once('helpers/sql-helpers.php');
require_once('helpers/common-helpers.php');
require_once('helpers/validate-helpers.php');
require_once('constant.php');

if(!$link) {
	throw new Error(mysqli_connect_error());
}

$errors = [];
$inputs = [];
$query_categories = $get_query_categories();
$categories = get_categories($link, $query_categories);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $required = ['email', 'password'];
  $rules = [
    'email' => function($value) {
      return validate_email($value);
    },
    'password' => function($value) use($password_length) {
      return validate_value_length($value, $password_length['min'], $password_length['max']);
    }
  ];

  $fields = [
    'email' => FILTER_SANITIZE_EMAIL,
    'password' => FILTER_DEFAULT
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

  if ($inputs['email']) {
    $user_query = $get_user_by_email();
    $existing_user = get_mysqli_select_stmt_result($link, $user_query, [$inputs['email']]);

    if (!$existing_user) {
      $errors['email'] = "Пользователь с данным email " . $inputs['email'] . " не зарегистрирован в системе.";
    }

    if ($existing_user) {
      $errors['password'] = validate_password_hash($inputs['password'], $existing_user[0]['password']);
    }
  }
  $errors = array_filter($errors);

  if(empty($errors)) {
    session_start();
    $_SESSION['user_name']  = $existing_user[0]['user_name'];
    $_SESSION['user_id']  = $existing_user[0]['id'];
    header("Location: /index.php");
    $inputs = [];
    exit();
  }
}

$form_content = include_template(
  'sign-in.template.php',
  [
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
    'title' => $page_title['sign-in'],
    'is_home' => false,
    'content' => $form_content,
    'navigation' => $navigation_content
  ]
);

print($layout_content);
?>