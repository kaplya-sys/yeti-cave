<?php
require_once('init.php');
require_once('models.php');
require_once('helpers/sql-helpers.php');
require_once('helpers/common-helpers.php');
require_once('helpers/date-helpers.php');
require_once('constant.php');

session_start();

$page_param = filter_input(INPUT_GET, 'page') ?? 1;
$search_param = filter_input(INPUT_GET, 'search');

if(!$link) {
	throw new Error(mysqli_connect_error());
}

$query_categories = $get_query_categories();
$categories = get_categories($link, $query_categories);

$search = htmlspecialchars(trim($_GET['search']));

if ($search) {
  $skip = ($page_param - 1) * $lot_limit;
  $query_lots = $get_query_search_lots();
  $lots = get_mysqli_select_stmt_result($link, $query_lots, [null, $search, $lot_limit, $skip]);
  $pages = ceil(count($lots) / $lot_limit);
}

$search_content = include_template(
  'search.template.php',
  [
		'lots' => $lots,
    'search_value' => $search,
    'pages' => $pages,
    'current_page' => $page_param
	]
);
$navigation_content = include_template(
  'nav.template.php',
  ['categories' => $categories]
);
$layout_content = include_template(
  'layout.template.php',
  [
    'title' => $page_title['search'],
    'is_home' => false,
    'content' => $search_content,
    'navigation' => $navigation_content
  ]
);

print($layout_content);
?>