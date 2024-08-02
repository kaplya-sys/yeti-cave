CREATE DATABASE IF NOT EXISTS yeti_cave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeti_cave;

CREATE TABLE users(
  user_id INT PRIMARY KEY AUTO_INCREMENT,
  user_name VARCHAR(20) NOT NULL,
  email VARCHAR(40) UNIQUE NOT NULL,
  password VARCHAR(32) NOT NULL,
  create_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  contacts TEXT NOT NULL
);

CREATE TABLE categories(
  category_id INT PRIMARY KEY AUTO_INCREMENT,
  category_name VARCHAR(20) NOT NULL,
  character_code ENUM('boards', 'attachment', 'boots', 'clothing', 'tools', 'other') NOT NULL
);

CREATE TABLE offers(
  offer_id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(120) NOT NULL,
  description TEXT NOT NULL,
  img VARCHAR(120) NOT NULL,
  price_num INT NOT NULL,
  expiration_date DATE NOT NULL,
  step_num INT NOT NULL,
  published_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  user_id INT,
  category_id INT,
  winner_id INT,
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (category_id) REFERENCES categories(category_id)
);

CREATE TABLE bets(
  bet_id INT PRIMARY KEY AUTO_INCREMENT,
  bet_num INT NOT NULL,
  published_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  user_id INT,
  offer_id INT,
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (offer_id) REFERENCES offers(offer_id)
);
