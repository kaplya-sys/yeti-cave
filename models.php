<?php
$get_query_categories = function() {
  return "SELECT character_code AS 'key', category_name AS 'value'
    FROM categories";
};

$get_query_category_by_name = function() {
  return "SELECT id, category_name AS 'name', character_code AS 'code'
    FROM categories
    WHERE character_code = ?";
};

$get_query_category_by_id = function() {
  return "SELECT id, category_name AS 'name'
    FROM categories
    WHERE id = ?";
};

$get_query_lots = function() {
  return "SELECT l.id, l.title, l.img_path, l.price, l.expiration_date AS 'expiration', c.category_name AS 'category'
    FROM lots AS l
    JOIN categories AS c
    ON l.category_id = c.id
    WHERE expiration_date >= COALESCE(?, NOW())
    ORDER BY published_date DESC";
};

$get_query_lot_by_id = function() {
  return "SELECT l.id, l.title, l.description, l.img_path, l.price, l.rate_step, l.expiration_date AS 'expiration', c.category_name AS 'category', u.id AS 'user_id'
    FROM lots AS l
    JOIN categories AS c
    ON l.category_id = c.id
    JOIN users AS u
    ON l.user_id = u.id
    WHERE l.id = ?";
};

$get_query_lots_count_by_category = function() {
  return "SELECT count(*) as 'count'
    FROM lots AS l
    JOIN categories AS c
    ON expiration_date >= COALESCE(?, NOW()) AND l.category_id = c.id
    WHERE c.character_code = ?";
};

$get_query_lots_by_category = function() {
  return "SELECT l.id, l.title, l.img_path, l.price, l.expiration_date AS 'expiration', c.category_name AS 'category'
    FROM lots AS l
    JOIN categories AS c
    ON l.category_id = c.id
    WHERE expiration_date >= COALESCE(?, NOW()) AND c.character_code = ?
    ORDER BY published_date DESC
    LIMIT ? OFFSET ?";
};

$get_query_search_lots = function() {
  return "SELECT l.id, l.title, l.img_path, l.price, l.expiration_date AS 'expiration', c.category_name AS 'category'
    FROM lots AS l
    JOIN categories AS c
    ON l.category_id = c.id
    WHERE expiration_date >= COALESCE(?, NOW()) AND MATCH(title, description) AGAINST(?)
    ORDER BY published_date DESC
    LIMIT ? OFFSET ?";
};

$get_query_create_lot = function() {
  return "INSERT INTO lots (title, description, img_path, price, rate_step, expiration_date, user_id, category_id)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
};

$get_query_bets_by_lot_id = function() {
  return "SELECT b.bet, b.published_date, u.user_name
    FROM bets AS b
    JOIN users AS u
    ON b.user_id = u.id
    WHERE b.lot_id = ?";
};

$get_query_bets_by_user_id = function() {
  return "SELECT
      b.bet,
      b.published_date,
      u.user_name,
      u.contacts AS 'user_contacts',
      l.id AS 'lot_id',
      l.price AS 'lot_price',
      l.img_path AS 'lot_img_path',
      l.title AS 'lot_title',
      l.expiration_date AS 'lot_expiration_date',
      c.category_name,
      w.id AS winner_id
    FROM bets AS b
    JOIN users AS u
    ON b.user_id = u.id
    JOIN lots AS l
    ON b.lot_id = l.id
    JOIN categories AS c
    ON l.category_id = c.id
    LEFT JOIN winners AS w
    ON w.lot_id = l.id
    WHERE b.user_id = ?";
};

$get_query_max_bet_by_user_id = function() {
  return "SELECT b.user_id, MAX(b.bet) as max_bet
    FROM bets AS b
    WHERE b.lot_id = ?
    GROUP BY b.user_id
    ORDER BY max_bet DESC
    LIMIT 1";
};

$get_query_lots_by_no_winner = function() {
  return "SELECT l.id, l.title, l.img_path, l.expiration_date, u.user_name
    FROM lots AS l
    LEFT JOIN winners AS w
    ON l.id = w.lot_id
    JOIN users AS u
    ON u.id = l.user_id
    WHERE l.expiration_date <= NOW() AND w.lot_id IS NULL";
};

$get_query_winner_by_user_id = function() {
  return "SELECT * 
    FROM winners AS w
    WHERE w.user_id = ?";
};

$get_user_by_email = function() {
  return "SELECT * 
    FROM users
    WHERE email = ?";
};

$get_user_by_id = function() {
  return "SELECT * 
    FROM users
    WHERE id = ?";
};

$get_query_create_user = function() {
  return "INSERT INTO users (email, password, user_name, contacts)
    VALUES (?, ?, ?, ?)";
};

$get_query_create_winner = function() {
  return "INSERT INTO winners (user_id, lot_id)
    VALUES (?, ?)";
};

$get_query_create_bet = function() {
  return "INSERT INTO bets (bet, user_id, lot_id)
    VALUES (?, ?, ?)";
};
?>
