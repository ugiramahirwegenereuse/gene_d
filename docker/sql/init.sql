-- init.sql: creates table tbl_users
CREATE DATABASE IF NOT EXISTS `25rp19942_shareride_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `25rp19942_shareride_db`;

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `user_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_firstname` VARCHAR(100) NOT NULL,
  `user_lastname` VARCHAR(100) NOT NULL,
  `user_gender` VARCHAR(10),
  `user_email` VARCHAR(255) NOT NULL UNIQUE,
  `user_password` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
