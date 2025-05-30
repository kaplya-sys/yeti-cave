<?php
require_once('init.php');
require_once('models.php');
require_once('helpers/sql-helpers.php');
require_once('helpers/common-helpers.php');
require_once('helpers/date-helpers.php');
require_once('constant.php');
require_once('add-winner.php');

session_start();

if(!$link) {
  throw new Error(mysqli_connect_error());
}

$query_categories = $get_query_categories();
$categories = get_categories($link, $query_categories);

$query_lots = $get_query_lots();
$lots = get_mysqli_select_stmt_result($link, $query_lots, [null]);

$main_content = include_template(
  'main.template.php',
  [
    'categories' => $categories,
    'lots' => $lots
  ]
);
$navigation_content = include_template(
  'nav.template.php',
  ['categories' => $categories]
);
$layout_content = include_template(
  'layout.template.php',
  [
    'title' => $page_title['main'],
    'is_home' => true,
    'content' => $main_content,
    'navigation' => $navigation_content
  ]
);

print($layout_content);
?>
