<?php
$get_query_categories = function() {
    return "SELECT character_code AS 'key', category_name AS 'value' FROM categories";
};

$get_query_offers = function() {
  return "SELECT o.title, o.img AS 'img_url', o.price_num AS 'price', o.expiration_date AS 'expiration', c.category_name AS 'category'
    FROM offers AS o
    JOIN categories AS c
    ON o.category_id = c.category_id
    WHERE expiration_date >= NOW()
    ORDER BY published_date DESC
    LIMIT ?";
}
  ?>
