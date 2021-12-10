
# Creazione Database 
CREATE DATABASE IF NOT EXISTS `tagazon`;

# Creazione tabelle

CREATE TABLE IF NOT EXISTS `tagazon`.`users` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `surname` VARCHAR(255) NOT NULL,
);

CREATE TABLE IF NOT EXISTS `tagazon`.`sellers` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `rag_soc` VARCHAR(255) NOT NULL,
    `piva` VARCHAR(255) NOT NULL,
);

CREATE TABLE IF NOT EXISTS `tagazon`.`tags` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `tagazon`.`categories` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `tagazon`.`tags_categories` (
    `tag` INT NOT NULL,
    `category` INT NOT NULL,
    PRIMARY KEY (`tag`, `category`),
    FOREIGN KEY (`tag`) REFERENCES `tags`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`category`) REFERENCES `categories`(`id`) ON DELETE CASCADE
);