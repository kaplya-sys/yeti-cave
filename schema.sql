CREATE DATABASE IF NOT EXISTS yeti_cave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeti_cave;

CREATE FULLTEXT INDEX lot_search
  ON lots(title, description);

CREATE TABLE users(
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_name VARCHAR(20) NOT NULL,
  email VARCHAR(40) UNIQUE NOT NULL,
  password VARCHAR(64) NOT NULL,
  create_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  contacts TEXT NOT NULL
);

CREATE TABLE categories(
  id INT PRIMARY KEY AUTO_INCREMENT,
  category_name VARCHAR(20) NOT NULL,
  character_code ENUM('boards', 'attachment', 'boots', 'clothing', 'tools', 'other') NOT NULL
);

CREATE TABLE lots(
  id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(120) NOT NULL,
  description TEXT NOT NULL,
  img_path VARCHAR(120) NOT NULL,
  price INT NOT NULL,
  expiration_date DATE NOT NULL,
  rate_step INT NOT NULL,
  published_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  user_id INT,
  category_id INT,
  winner_id INT,
  FOREIGN KEY (user_id) REFERENCES users (id),
  FOREIGN KEY (category_id) REFERENCES categories (id)
);

CREATE TABLE bets(
  id INT PRIMARY KEY AUTO_INCREMENT,
  bet INT NOT NULL,
  published_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  user_id INT,
  lot_id INT,
  FOREIGN KEY (user_id) REFERENCES users (id),
  FOREIGN KEY (lot_id) REFERENCES lots (id)
);

CREATE TABLE winners(
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT,
  lot_id INT,
  FOREIGN KEY (user_id) REFERENCES users (id),
  FOREIGN KEY (lot_id) REFERENCES lots (id)
);

ALTER TABLE lots ADD FULLTEXT (title, description);
