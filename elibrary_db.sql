-- Create Database
CREATE DATABASE IF NOT EXISTS elibrary_db;
USE elibrary_db;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user'
);

-- Books Table
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    availability BOOLEAN DEFAULT TRUE
);

-- Sample Books (1000)
DELIMITER $$
CREATE PROCEDURE seed_books()
BEGIN
  DECLARE i INT DEFAULT 1;
  WHILE i <= 1000 DO
    INSERT INTO books (title, author, availability) 
    VALUES (
      CONCAT('Sample Book #', i), 
      CONCAT('Author ', i), 
      TRUE
    );
    SET i = i + 1;
  END WHILE;
END$$
DELIMITER ;

CALL seed_books();
DROP PROCEDURE IF EXISTS seed_books;

-- Reservations Table (optional)
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    book_id INT,
    reserved_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    due_date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (book_id) REFERENCES books(id)
);

-- Notifications Table (optional)
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    message TEXT,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert Admin + Sample User
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@example.com', '$2y$10$KbQOx6zUzkHXY3VGbBCeTe2ghbuhZKRGTA/hAw45cP7UHGKcd3OjO', 'admin'),
('user1', 'user1@example.com', '$2y$10$KbQOx6zUzkHXY3VGbBCeTe2ghbuhZKRGTA/hAw45cP7UHGKcd3OjO', 'user');
