<?php
require_once('helpers.php');
require_once('data.php');

$main_content = include_template(
  'main.php',
  [
    'categories' => $categories,
    'offers' => $offers
  ]
);
$layout_content = include_template(
  'layout.php',
  [
    'title' => $page_title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories,
    'content' => $main_content
  ]
);

print($layout_content);
?>
