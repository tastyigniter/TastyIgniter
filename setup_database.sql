CREATE DATABASE IF NOT EXISTS tastyigniter CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'tastyigniter_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON tastyigniter.* TO 'tastyigniter_user'@'localhost';
FLUSH PRIVILEGES;
