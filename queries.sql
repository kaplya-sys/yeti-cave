INSERT users(
  user_name,
  email,
  password,
  contacts
)
  VALUES
    ('Александр', 'alex@mail.ru', '123456', 'Телефон +7 900 667-84-48, Скайп: Vlas92. Звонить с 14 до 20'),
    ('Дмитрий', 'dm@mail.ru', '123456', 'Телефон +7 909 895-11-89'),
    ('Алексей', 'casper@list.ru', '123456', 'Телефон +7 919 547-22-33, Telegram: @casper');

INSERT categories(
  category_name,
  character_code
)
  VALUES
    ('Доски и лыжи', 'boards'),
    ('Крепления', 'attachment'),
    ('Ботинки', 'boots'),
    ('Одежда', 'clothing'),
    ('Инструменты', 'tools'),
    ('Разное', 'other');

INSERT offers(
  title,
  description,
  img,
  price_num,
  expiration_date,
  step_num,
  user_id,
  category_id
)
  VALUES
    ('2014 Rossignol District Snowboard', 'Легкий маневренный сноуборд, готовый дать жару в любом парке.', 'img/lot-1.jpg', 10999, '2024-07-29', 100, 1, 1),
    ('DC Ply Mens 2016/2017 Snowboard', 'Популярный сноуборд Ply по ощущениям немного напоминает скейтборд.', 'img/lot-2.jpg', 15999, '2024-08-14', 200, 3, 1),
    ('Крепления Union Contact Pro 2015 года размер L/XL', 'Подростковые сноуборд крепления Contact Pro подойдут для молодых райдеров.', 'img/lot-3.jpg', 8000, '2024-08-21', 200, 3, 2),
    ('Ботинки для сноуборда DC Mutiny Charocal', 'Стильные и комфортные ботинки для сноуборда.', 'img/lot-4.jpg', 10999, '2024-09-02', 200, 2, 3),
    ('Куртка для сноуборда DC Mutiny Charocal', 'Водостойкая и дышащая мембрана Weather Defense 10K (10 000 мм / 5000 г).', 'img/lot-5.jpg', 7500, '2024-09-05', 200, 1, 4),
    ('Маска Oakley Canopy', 'Технология High Definition Optics обеспечит непревзойденную визуальную четкость на всех углах обзора.', 'img/lot-6.jpg', 5400, '2024-08-06', 200, 3, 6);

INSERT bets(
  bet_num,
  user_id,
  offer_id
)
  VALUES
    (1200, 2, 1),
    (9400, 3, 5);

SELECT character_code, category_name AS 'categories' FROM categories;

SELECT o.title, o.img, o.price_num, c.category_name AS 'category'
  FROM offers AS o
  JOIN categories AS c
  ON o.category_id = c.category_id
  WHERE expiration_date >= NOW();

SELECT o.offer_id, o.title, o.description, o.img, o.price_num, o.expiration_date, o.step_num, o.published_date, c.category_name AS 'category'
  FROM offers AS o
  JOIN categories AS c
  ON o.category_id = c.category_id
  WHERE o.offer_id = 1;

SELECT b.bet_id, b.bet_num, b.published_date, o.title, u.user_name
  FROM bets AS b
  JOIN offers AS o
  ON b.offer_id = o.offer_id
  JOIN users AS u
  ON b.user_id = u.user_id
  WHERE offer_id = 1
  ORDER BY published_date DESC;

UPDATE offers SET title = 'DC Ply Mens 2023/2024 Snowboard' WHERE offer_id = 2;
