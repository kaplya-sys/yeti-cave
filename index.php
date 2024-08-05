<?php
require_once('init.php');
require_once('models.php');
require_once('helpers.php');
require_once('data.php');


if(!$link) {
  die(mysqli_connect_error());
}

$query = $get_query_categories();
$result = mysqli_query($link, $query);

if(!$result) {
  die(mysqli_error($link));
}

$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach($categories as $index => $item) {
  $categories[$item['key']] = $item['value'];
  unset($categories[$index]);
}

$query = $get_query_offers();
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, 'i', $offer_count);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if(!$result) {
  die(mysqli_error($link));
}

$offers = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
