CREATE DATABASE shop;
CREATE TABLE `shop`.`category` (
                                   `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                                   `name` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
                                   `description` TEXT NULL DEFAULT NULL,
                                   `parent_id` INT(10) UNSIGNED NOT NULL,
                                   PRIMARY KEY (`id`)
);
ALTER TABLE `shop`.`category` ADD FOREIGN KEY (`parent_id`) REFERENCES `shop`.`category`(`id`);
CREATE TABLE `shop`.`user` (
                               `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                               `first_name` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
                               `last_name` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
                               `email` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
                               `password` VARCHAR(32) NOT NULL,
                               `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
                               `is_seller` TINYINT(1) NOT NULL DEFAULT 0,
                               `register_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                               PRIMARY KEY (`id`)
);
CREATE TABLE `shop`.`product` (
                                  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                                  `title` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
                                  `sku` VARCHAR(255) NOT NULL UNIQUE,
                                  `category_id` INT(10) UNSIGNED NOT NULL,
                                  `user_id` INT(10) UNSIGNED NOT NULL,
                                  `price` FLOAT NOT NULL DEFAULT 0,
                                  `quantity` SMALLINT(6) NOT NULL DEFAULT 0,
                                  `description` TEXT NULL DEFAULT NULL,
                                  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                                  `updated_at` TIMESTAMP NULL DEFAULT NULL,
                                  PRIMARY KEY (`id`),
                                  FOREIGN KEY (`category_id`) REFERENCES category(`id`),
                                  FOREIGN KEY (`category_id`) REFERENCES user(`id`)
);

CREATE TABLE `shop`.`product_category` (
                                           `productId` INT(10) NOT NULL,
                                           `categoryId` INT(10) NOT NULL,
                                           PRIMARY KEY (`productId`, `categoryId`),
                                           FOREIGN KEY (`productId`) REFERENCES `shop`.`product` (`id`),
                                           FOREIGN KEY (`categoryId`) REFERENCES `shop`.`category` (`id`)
);

CREATE TABLE `shop`.`order` (
                                `id` BIGINT NOT NULL AUTO_INCREMENT,
                                `userId` BIGINT NULL DEFAULT NULL,
                                `sessionId` VARCHAR(100) NOT NULL,
                                `token` VARCHAR(100) NOT NULL,
                                `status` SMALLINT(6) NOT NULL DEFAULT 0,
                                `subTotal` FLOAT NOT NULL DEFAULT 0,
                                `itemDiscount` FLOAT NOT NULL DEFAULT 0,
                                `tax` FLOAT NOT NULL DEFAULT 0,
                                `shipping` FLOAT NOT NULL DEFAULT 0,
                                `total` FLOAT NOT NULL DEFAULT 0,
                                `promo` VARCHAR(50) NULL DEFAULT NULL,
                                `discount` FLOAT NOT NULL DEFAULT 0,
                                `grandTotal` FLOAT NOT NULL DEFAULT 0,
                                `firstName` VARCHAR(50) NULL DEFAULT NULL,
                                `middleName` VARCHAR(50) NULL DEFAULT NULL,
                                `lastName` VARCHAR(50) NULL DEFAULT NULL,
                                `mobile` VARCHAR(15) NULL,
                                `email` VARCHAR(50) NULL,
                                `line1` VARCHAR(50) NULL DEFAULT NULL,
                                `line2` VARCHAR(50) NULL DEFAULT NULL,
                                `city` VARCHAR(50) NULL DEFAULT NULL,
                                `province` VARCHAR(50) NULL DEFAULT NULL,
                                `country` VARCHAR(50) NULL DEFAULT NULL,
                                `createdAt` DATETIME NOT NULL,
                                `updatedAt` DATETIME NULL DEFAULT NULL,
                                `content` TEXT NULL DEFAULT NULL,
                                PRIMARY KEY (`id`),
                                INDEX `idx_order_user` (`userId` ASC),
                                CONSTRAINT `fk_order_user`
                                    FOREIGN KEY (`userId`)
                                        REFERENCES `shop`.`user` (`id`)
                                        ON DELETE NO ACTION
                                        ON UPDATE NO ACTION);
