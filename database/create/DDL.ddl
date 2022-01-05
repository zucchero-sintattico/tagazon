
# Creazione Database 
CREATE DATABASE IF NOT EXISTS `my_tagazon`;

# Creazione tabelle

CREATE TABLE IF NOT EXISTS `my_tagazon`.`sellers` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(128) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `rag_soc` VARCHAR(128) NOT NULL,
    `piva` VARCHAR(255) NOT NULL,
    UNIQUE(`email`),
    UNIQUE(`rag_soc`)
);

CREATE TABLE IF NOT EXISTS `my_tagazon`.`buyers` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(128) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `surname` VARCHAR(255) NOT NULL,
    UNIQUE(`email`)
);

CREATE TABLE IF NOT EXISTS `my_tagazon`.`categories` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(128) NOT NULL,
    `description` TEXT NOT NULL,
    UNIQUE(`name`)
);

CREATE TABLE IF NOT EXISTS `my_tagazon`.`tags` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(128) NOT NULL,
    `description` TEXT NOT NULL,
    `example` TEXT NOT NULL,
    `example_desc` TEXT NOT NULL,
    `seller` INT NOT NULL,
    `price` FLOAT NOT NULL,
    `sale_price` FLOAT,
    UNIQUE(`name`),
    FOREIGN KEY (`seller`) REFERENCES `sellers`(`id`)
);

CREATE TABLE IF NOT EXISTS `my_tagazon`.`tag_categories` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tag` INT NOT NULL,
    `category` INT NOT NULL,
    UNIQUE (`tag`, `category`),
    FOREIGN KEY (`tag`) REFERENCES `tags`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`category`) REFERENCES `categories`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `my_tagazon`.`wishlists` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(128) NOT NULL,
    `buyer` INT NOT NULL,
    UNIQUE(`buyer`, `name`),
    FOREIGN KEY (`buyer`) REFERENCES `buyers`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `my_tagazon`.`wishlist_tags` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tag` INT NOT NULL,
    `wishlist` INT NOT NULL,
    UNIQUE(`tag`, `wishlist`),
    FOREIGN KEY (`tag`) REFERENCES `tags`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`wishlist`) REFERENCES `wishlists`(`id`) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS `my_tagazon`.`shoppingcart_tags` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tag` INT NOT NULL,
    `buyer` INT NOT NULL,
    `quantity` INT NOT NULL DEFAULT 1,
    UNIQUE(`tag`, `buyer`),
    FOREIGN KEY (`tag`) REFERENCES `tags`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`buyer`) REFERENCES `buyers`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `my_tagazon`.`orders` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `buyer` INT NOT NULL,
    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `status` VARCHAR(255) NOT NULL,
    `amount` FLOAT NOT NULL,
    FOREIGN KEY (`buyer`) REFERENCES `buyers`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `my_tagazon`.`order_tags` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tag` INT NOT NULL,
    `order` INT NOT NULL,
    `quantity` INT NOT NULL,
    UNIQUE(`tag`, `order`),
    FOREIGN KEY (`tag`) REFERENCES `tags`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`order`) REFERENCES `orders`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `my_tagazon`.`payments` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `order` INT NOT NULL,
    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `card-owner` VARCHAR(255) NOT NULL,
    `card-number` INT NOT NULL,
    `card-expiry-year` VARCHAR(2) NOT NULL,
    `card-expiry-month` VARCHAR(2) NOT NULL,
    `card-cvc` INT NOT NULL,
    `amount` FLOAT NOT NULL,
    UNIQUE(`order`),
    FOREIGN KEY (`order`) REFERENCES `orders`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `my_tagazon`.`notifications` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `order` INT NOT NULL,
    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `title` TEXT NOT NULL,
    `message` TEXT NOT NULL,
    `received` BOOLEAN NOT NULL DEFAULT FALSE,
    `seen` BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (`order`) REFERENCES `orders`(`id`) ON DELETE CASCADE
);



