
# Creazione Database 
CREATE DATABASE IF NOT EXISTS `tagazon`;

# Creazione tabelle

CREATE TABLE IF NOT EXISTS `tagazon`.`tags` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL,
    `seller` INT NOT NULL,
    `price` FLOAT NOT NULL,
    `sale_price` FLOAT,
    FOREIGN KEY (`seller`) REFERENCES `sellers`(`id`)
);

CREATE TABLE IF NOT EXISTS `tagazon`.`sellers` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `rag_soc` VARCHAR(255) NOT NULL,
    `piva` VARCHAR(255) NOT NULL,
    UNIQUE(`email`),
    UNIQUE(`piva`),
    UNIQUE(`rag_soc`)
);

CREATE TABLE IF NOT EXISTS `tagazon`.`buyers` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `surname` VARCHAR(255) NOT NULL,
    UNIQUE(`email`)
);

CREATE TABLE IF NOT EXISTS `tagazon`.`categories` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `tagazon`.`tag_categories` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tag` INT NOT NULL,
    `category` INT NOT NULL,
    UNIQUE (`tag`, `category`),
    FOREIGN KEY (`tag`) REFERENCES `tags`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`category`) REFERENCES `categories`(`id`) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS `tagazon`.`wishlists` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `buyer` INT NOT NULL,
    UNIQUE(`buyer`, `name`),
    FOREIGN KEY (`buyer`) REFERENCES `buyers`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `tagazon`.`wishlist_tags` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tag` INT NOT NULL,
    `wishlist` INT NOT NULL,
    UNIQUE(`tag`, `wishlist`),
    FOREIGN KEY (`tag`) REFERENCES `tags`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`wishlist`) REFERENCES `wishlists`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `tagazon`.`shoppingcarts` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `buyer` INT NOT NULL,
    UNIQUE(`buyer`),
    FOREIGN KEY (`buyer`) REFERENCES `buyers`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `tagazon`.`shoppingcart_tags` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tag` INT NOT NULL,
    `shoppingcart` INT NOT NULL,
    `quantity` INT NOT NULL,
    UNIQUE(`tag`, `shoppingcart`),
    FOREIGN KEY (`tag`) REFERENCES `tags`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`shoppingcart`) REFERENCES `shoppingcarts`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `tagazon`.`orders` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `buyer` INT NOT NULL,
    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `status` VARCHAR(255) NOT NULL,
    'amount' FLOAT NOT NULL,
    FOREIGN KEY (`buyer`) REFERENCES `buyers`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `tagazon`.`order_tags` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `tag` INT NOT NULL,
    `order` INT NOT NULL,
    `quantity` INT NOT NULL,
    UNIQUE(`tag`, `order`),
    FOREIGN KEY (`tag`) REFERENCES `tags`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`order`) REFERENCES `orders`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `tagazon`.`creditcards` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `owner` VARCHAR(255) NOT NULL,
    `number` VARCHAR(255) NOT NULL,
    `expiration` VARCHAR(255) NOT NULL,
    `cvv` VARCHAR(255) NOT NULL,
    `buyer` INT NOT NULL,
    FOREIGN KEY (`buyer`) REFERENCES `buyers`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `tagazon`.`payments` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `order` INT NOT NULL,
    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `creditcard` INT NOT NULL,
    UNIQUE(`order`),
    FOREIGN KEY (`order`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`creditcard`) REFERENCES `creditcards`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `tagazon`.`notifications` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `order` INT NOT NULL,
    `buyer` INT NOT NULL,
    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `message` VARCHAR(255) NOT NULL,
    `seen` BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (`order`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`buyer`) REFERENCES `buyers`(`id`) ON DELETE CASCADE

);



