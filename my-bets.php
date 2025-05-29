<?php
require_once('init.php');
require_once('models.php');
require_once('helpers/sql-helpers.php');
require_once('helpers/common-helpers.php');
require_once('helpers/date-helpers.php');
require_once('constant.php');

session_start();

if(!$link) {
	throw new Error(mysqli_connect_error());
}

$query_categories = $get_query_categories();
$categories = get_categories($link, $query_categories);
$query_beats = $get_query_bets_by_user_id();
$user_bets = get_mysqli_select_stmt_result($link, $query_beats, [$_SESSION['user_id']]);

$bets_content = include_template(
  'my-bets.template.php',
  [
    'bets' => $user_bets,
    'bet_win' => false
  ]
);
$navigation_content = include_template(
  'nav.template.php',
  ['categories' => $categories]
);
$layout_content = include_template(
  'layout.template.php',
  [
    'title' => $page_title['bets'],
    'is_home' => false,
    'content' => $bets_content,
    'navigation' => $navigation_content
  ]
);

print($layout_content);
?>