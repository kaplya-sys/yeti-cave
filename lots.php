<?php
require_once('init.php');
require_once('models.php');
require_once('helpers/sql-helpers.php');
require_once('helpers/common-helpers.php');
require_once('helpers/date-helpers.php');
require_once('constant.php');

session_start();

$category_param = filter_input(INPUT_GET, 'category');
$page_param = filter_input(INPUT_GET, 'page') ?? 1;

if(!$category_param) {
  header('Location: 404.php');
  exit();
}

if(!$link) {
	throw new Error(mysqli_connect_error());
}

$query_categories = $get_query_categories();
$categories = get_categories($link, $query_categories);

$query_category = $get_query_category_by_name($category_param);
$category = get_mysqli_select_stmt_result($link, $query_category, [$category_param]);

$query_count_lots = $get_query_lots_count_by_category();
$lots = get_mysqli_select_stmt_result($link, $query_count_lots, [null, $category_param]);

$skip = ($page_param - 1) * $lot_limit;
$pages = ceil($lots[0]['count'] / $lot_limit);
$query_lots = $get_query_lots_by_category();
$lots = get_mysqli_select_stmt_result($link, $query_lots, [null, $category_param, $lot_limit, $skip]);

$lots_content = include_template(
  'lots.template.php',
  [
		'lots' => $lots,
		'category' => $category[0],
    'pages' => $pages,
    'current_page' => $page_param
	]
);
$navigation_content = include_template(
  'nav.template.php',
  [
    'categories' => $categories,
    'currentKey' => $category_param
  ]
);
$layout_content = include_template(
  'layout.template.php',
  [
    'title' => $page_title['lots'],
    'is_home' => false,
    'content' => $lots_content,
    'navigation' => $navigation_content
  ]
);

print($layout_content);
?>