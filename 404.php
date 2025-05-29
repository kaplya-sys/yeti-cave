<?php
require_once('init.php');
require_once('models.php');
require_once('helpers.php');
require_once('data.php');

if(!$link) {
	die(mysqli_connect_error());
}

$query_categories = $get_query_categories();
$categories = get_categories($link, $query_categories);

$not_found_content = include_template('404.template.php');
$navigation_content = include_template(
  'nav.template.php',
  ['categories' => $categories]
);
$layout_content = include_template(
  'layout.template.php',
  [
    'title' => '404',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'is_home' => false,
    'content' => $not_found_content,
    'navigation' => $navigation_content
  ]
);

print($layout_content);
?>