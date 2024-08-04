<?php
require_once('helpers.php');
require_once('data.php');

$mysqli = mysqli_connect('MySQL-8.2', 'root', '', 'yeti_cave');

if(!$mysqli) {
  print(mysqli_connect_error());
}

$query_categories = "SELECT character_code AS 'key', category_name AS 'value' FROM categories";
$query_offers = "SELECT o.title, o.img AS 'img_url', o.price_num AS 'price', o.expiration_date AS 'expiration', c.category_name AS 'category'
  FROM offers AS o
  JOIN categories AS c
  ON o.category_id = c.category_id
  WHERE expiration_date >= NOW()";

$sql_categories = mysqli_query($mysqli, $query_categories);
$sql_offers = mysqli_query($mysqli, $query_offers);

if(!$sql_categories or !$sql_offers) {
  print(mysqli_error($mysqli));
}

$categories = mysqli_fetch_all($sql_categories, MYSQLI_ASSOC);
$offers = mysqli_fetch_all($sql_offers, MYSQLI_ASSOC);

foreach($categories as $index => $item) {
  $categories[$item['key']] = $item['value'];
  unset($categories[$index]);
}

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
