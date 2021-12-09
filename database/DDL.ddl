
# Creazione Database 
CREATE DATABASE IF NOT EXISTS `tagazone`;

# Creazione tabelle

CREATE TABLE IF NOT EXISTS `tagazone`.`users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `surname` VARCHAR(255) NOT NULL,
);

CREATE TABLE IF NOT EXISTS `tagazone`.`sellers` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `rag_soc` VARCHAR(255) NOT NULL,
    `piva` VARCHAR(255) NOT NULL,
);

