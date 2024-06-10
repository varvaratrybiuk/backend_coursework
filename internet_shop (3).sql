-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Чрв 10 2024 р., 16:39
-- Версія сервера: 8.2.0
-- Версія PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `internet_shop`
--

-- --------------------------------------------------------

--
-- Структура таблиці `address_information`
--

DROP TABLE IF EXISTS `address_information`;
CREATE TABLE IF NOT EXISTS `address_information` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(150) NOT NULL,
  `street` varchar(150) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `address_information`
--

INSERT INTO `address_information` (`id`, `user_id`, `country`, `city`, `street`, `zip_code`) VALUES
(1, 1, 'Україна', 'Київ', 'проспект Незалежності, 4', '01001'),
(2, 1, 'Україна', 'Львів', 'вул. Антоновича В., 34', '79007'),
(3, 2, 'Україна', 'Львів', 'вул. Антоновича В., 76', '79007'),
(7, 8, 'Україна', 'Одеса', 'вулиця Лісова, 3', '65037'),
(8, 9, 'Україна', 'Одеса', 'вулиця Лісова, 78', '79007'),
(9, 11, 'Україна', 'Львів', 'вулиця Лісова, 78', '67576'),
(10, 13, 'Україна', 'Одеса', 'вулиця Лісова, 78', '65037'),
(11, 8, 'Україна', 'Одеса', 'вулиця Лісова, 78', '79007'),
(12, 2, 'Україна', 'Київ', 'вул. Професора Балінського, 11', '65037'),
(13, 13, 'Україна', 'Тернопіль', 'вул. Св Петра, 11', '00000'),
(14, 8, 'Україна', 'Одеса', 'вулиця Лісова, 3', '65037'),
(15, 14, 'Україна', 'Одеса', 'вулиця Лісова, 80', '79007');

-- --------------------------------------------------------

--
-- Структура таблиці `artist`
--

DROP TABLE IF EXISTS `artist`;
CREATE TABLE IF NOT EXISTS `artist` (
  `artist_id` int NOT NULL AUTO_INCREMENT,
  `artist_name` varchar(200) NOT NULL,
  PRIMARY KEY (`artist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `artist`
--

INSERT INTO `artist` (`artist_id`, `artist_name`) VALUES
(1, 'Ariana Grande'),
(2, 'Taylor Swift');

-- --------------------------------------------------------

--
-- Структура таблиці `comments_and_rating`
--

DROP TABLE IF EXISTS `comments_and_rating`;
CREATE TABLE IF NOT EXISTS `comments_and_rating` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `product_id` int NOT NULL,
  `comment` text NOT NULL,
  `stars` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `comments_and_rating`
--

INSERT INTO `comments_and_rating` (`id`, `user_id`, `product_id`, `comment`, `stars`) VALUES
(1, 1, 14, 'Дуже крутий диск, навіть не можу уявити його життя без нього!', 5),
(2, 1, 12, 'Альбом просто 10/10', 5),
(3, 2, 14, 'Альбом хороший, але диск такий собі', 2),
(4, 2, 12, 'Як завжди на висоті, цього разу платівку зацінила', 4),
(5, 2, 11, 'Диск крутий, але хочеться, щоб додали більше версій', 4),
(19, 2, 1, 'Дуже хороша футболка', 5),
(22, 2, 15, 'Ваау, дуже крута футболка', 5),
(24, 2, 2, 'Чому так дорого', 2),
(25, 2, 3, 'Дуже приємний на дотик', 5),
(26, 11, 11, 'Дуже гарний', 4);

-- --------------------------------------------------------

--
-- Структура таблиці `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `address_id` int NOT NULL,
  `order_date` date NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `orders_ibfk_1` (`user_id`),
  KEY `address_id` (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address_id`, `order_date`, `status`) VALUES
(11, 1, 1, '2024-06-08', 4),
(12, 1, 2, '2024-06-08', 3),
(14, 1, 1, '2024-06-08', 5),
(15, 9, 8, '2024-06-08', 1),
(16, 11, 9, '2024-06-09', 5),
(17, 11, 9, '2024-06-09', 5),
(18, 13, 10, '2024-06-09', 4),
(19, 8, 11, '2024-06-09', 1),
(20, 2, 12, '2024-06-10', 2),
(21, 13, 13, '2024-06-10', 1),
(22, 11, 9, '2024-06-10', 5),
(23, 8, 14, '2024-06-10', 2),
(24, 14, 15, '2024-06-10', 1);

-- --------------------------------------------------------

--
-- Структура таблиці `photo_storage`
--

DROP TABLE IF EXISTS `photo_storage`;
CREATE TABLE IF NOT EXISTS `photo_storage` (
  `product_id` int NOT NULL,
  `photo_filepath` text NOT NULL,
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `photo_storage`
--

INSERT INTO `photo_storage` (`product_id`, `photo_filepath`) VALUES
(1, '../../public/images/Ariana Grande merch/we can\'t be friends t-shirt front.png'),
(1, '../../public/images/Ariana Grande merch/we can\'t be friends t-shirt zoomed.png'),
(1, '../../public/images/Ariana Grande merch/we can\'t be friends t-shirt  back.png'),
(2, '../../public/images/Ariana Grande merch/TEDDY-TANK-BACK.png'),
(2, '../../public/images/Ariana Grande merch/TEDDY-TANK-FRONT.png'),
(4, '../../public/images/Ariana Grande merch/AG7-LP3.png'),
(4, '../../public/images/Ariana Grande merch/AG7-LP3-ALT.png'),
(5, '../../public/images/Ariana Grande merch/AG_D2CLP_2.png'),
(5, '../../public/images/Ariana Grande merch/AG_D2CLP_2_4aab3459-a963-456c-a60c-2dbee5b83479.png'),
(6, '../../public/images/Ariana Grande merch/marbles-cd.png'),
(7, '../../public/images/Ariana Grande merch/AG-CD4_01d57b23-1a1d-440f-8215-497ebc1d278f.png'),
(8, '../../public/images/Taylor Swift merch/The Tortured Poets Department The Manuscript Edition Hoodie front.png'),
(8, '../../public/images/Taylor Swift merch/The Tortured Poets Department The Manuscript Edition Hoodie back.png'),
(8, '../../public/images/Taylor Swift merch/The Tortured Poets Department The Manuscript Edition Hoodie detail.png'),
(9, '../../public/images/Taylor Swift merch/Taylor Swift  The Eras Tour Photo Oversized T-Shirt front.png'),
(9, '../../public/images/Taylor Swift merch/Taylor Swift  The Eras Tour Photo Oversized T-Shirt back.png'),
(10, '../../public/images/Taylor Swift merch/From The Vault 1989 (Taylor\'s Version) White T-Shirt.png'),
(11, '../../public/images/Taylor Swift merch/TTPD CD.png'),
(13, '../../public/images/Taylor Swift merch/folklore Album Cardigan Scarf front.png'),
(13, '../../public/images/Taylor Swift merch/folklore Album Cardigan Scarf label.png'),
(13, '../../public/images/Taylor Swift merch/folklore Album Cardigan Scarf stars.png'),
(15, '../../public/images/Taylor Swift merch/The Tortured Poets Department Black Photo T-Shirt detail.png'),
(15, '../../public/images/Taylor Swift merch/The Tortured Poets Department Black Photo T-Shirt front.png'),
(2, '../../public/images/Ariana Grande merch/tank-back-detail.png'),
(3, '../../public/images/Ariana Grande merch/teddy-bear-front.png'),
(3, '../../public/images/Ariana Grande merch/teddy-bear-back.png'),
(12, '../../public/images/Taylor Swift merch/The Tortured Poets Department Vinyl front.png'),
(12, '../../public/images/Taylor Swift merch/The Tortured Poets Department Vinyl back.png'),
(12, '../../public/images/Taylor Swift merch/The Tortured Poets Department Vinyl detail.png'),
(14, '../../public/images/Taylor Swift merch/folklore cd.png'),
(16, '../../public/images/save_images/eternal sunshine tote666559fca2e71.png'),
(17, '../../public/images/save_images/positions cd 1666565a887fc3.png'),
(19, '../../public/images/save_images/Now I\'m Down Bad T-Shirt666569c71d7f4.png'),
(19, '../../public/images/save_images/Now I\'m Down Bad T-Shirt666569c71d998.png'),
(20, '../../public/images/save_images/I Chose This Cyclone With You T-Shirt6665b3ef5d7d2.png'),
(20, '../../public/images/save_images/I Chose This Cyclone With You T-Shirt6665b3ef5da92.png'),
(21, '../../public/images/save_images/The Tortured Poets Department Black Hat66668ab36c466.png'),
(21, '../../public/images/save_images/The Tortured Poets Department Black Hat66668ab36c890.png'),
(23, '../../public/images/save_images/It\'s a Cruel Summer with You Crewneck6667270169045.png');

-- --------------------------------------------------------

--
-- Структура таблиці `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `artist_id` int NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `artist_id` (`artist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `products`
--

INSERT INTO `products` (`id`, `artist_id`, `product_name`, `description`) VALUES
(1, 1, 'we can\'t be friends t-shirt', 'screenprinted front + back graphics. 100% cotton.'),
(2, 1, 'teddy ribbed tank top', 'screenprinted front + back graphics. 95% cotton 5% elastane.'),
(3, 1, 'we can\'t be friends teddy bear', 'stuffed teddy bear.12\" l x 8\" w (hand to hand)'),
(4, 1, 'eternal sunshine (exclusive cover no. 3) lp', 'translucent ruby vinyl, gatefold jacket, eight page 12”x12” full size booklet featuring lyrics and photos.'),
(5, 1, 'eternal sunshine (exclusive cover no. 2) lp', 'translucent ruby vinyl, gatefold jacket, eight page 12”x12” full size booklet featuring lyrics and photos.'),
(6, 1, 'eternal sunshine (exclusive cover no. 1) cd', ''),
(7, 1, 'eternal sunshine (exclusive cover no. 4) cd', ''),
(8, 2, 'The Tortured Poets Department: The Manuscript Edition Hoodie', 'Cream hoodie with front pocket featuring \"TTPD\" album logo printed on front with ink, quill, sky, and \"TTPD\" album logo journal illustration printed on back.Standard fit.70% cotton, 30% polyester'),
(9, 2, 'Taylor Swift | The Eras Tour Photo Oversized T-Shirt', 'Beige oversized t-shirt featuring photo of Taylor Swift, star design, and \"Taylor Swift | The Eras Tour\" printed on front with \"Taylor Swift | The Eras Tour\", tour locations, and heart design printed on back. Oversized fit 100% cotton'),
(10, 2, 'From The Vault 1989 (Taylor\'s Version) White T-Shirt', 'White t-shirt featuring from the vault photo of Taylor Swift, \"1989 Taylor\'s Version\" and seagull design printed on front.Standard fit 100% cotton'),
(11, 2, 'The Tortured Poets Department CD + Bonus Track \"The Manuscript\"', 'The Tortured Poets Department CD + Bonus Track “The Manuscript” 16 Tracks + Bonus Track “The Manuscript” Collectible CD album in single jewel case with unique front and back cover art 1 Disc album with collectible disc artwork A collectible 20-page booklet that includes all song lyrics and never-before-seen photos 10”x10” Double-Sided Poster Side 1 includes full size photograph of Taylor Swift Side 2 includes a replica of Taylor Swift\'s handwritten lyrics unique to this CD'),
(12, 2, 'The Tortured Poets Department Vinyl + Bonus Track \"The Manuscript\"', 'The Tortured Poets Department Vinyl + Bonus Track “The Manuscript” 16 Tracks + Bonus Track “The Manuscript”\r\nCollectible 24-page book-bound jacket with three replicas of Taylor Swift\'s handwritten lyrics unique to this vinyl and never before-seen photos 2 Ghosted White vinyl discs Collectible album sleeves including never-before-seen photos'),
(13, 2, 'folklore Album Cardigan Scarf', 'White folklore cardigan scarf featuring 3 silver star patches embroidered on one end of scarf and \"Taylor Swift\" patch embroidered on other end of scarf. 70\" x 10\" 100% acrylic'),
(14, 2, '1. the “in the trees\" edition deluxe cd', 'Each deluxe cd album includes: 16 songs + bonus song \"the lakes\" 1 of 8 unique, collectible covers 1 of 8 unique, collectible back covers 1 of 8 unique disc photos 1 of 8 collectible album lyric booklets (each version contains 5 unique photos and artwork)'),
(15, 2, 'The Tortured Poets Department Black Photo T-Shirt', 'Black t-shirt featuring photo of Taylor Swift and \"TTPD\" album logo printed on front with double line design.'),
(16, 1, 'eternal sunshine tote', 'screenprinted front graphics. 100% cotton canvas. 16.5\" x 16.5\"'),
(17, 1, 'positions cd 1', 'limited edition cd '),
(19, 2, 'Now I\'m Down Bad T-Shirt', 'Black t-shirt featuring \"TTPD\" album logo and \"The Tortured Poets Department\" printed on front with space ship design, \"Now I\'m Down Bad\", song lyrics, \"Taylor Swift\", and \"For A Moment I Knew Cosmic Love\" and other \"Down Bad\" song lyrics printed on back.'),
(20, 2, 'I Chose This Cyclone With You T-Shirt', 'Cream hoodie with front pocket featuring \"TTPD\" album logo printed on front with ink, quill, sky, and \"TTPD\" album logo journal illustration printed on back.\r\n\r\nStandard fit.\r\n70% cotton, 30% polyester'),
(21, 2, 'The Tortured Poets Department Black Hat', 'Black hat featuring \"TTPD\" album logo embroidered on hat.\r\n\r\nAdjustable back closure\r\n100% cotton'),
(23, 2, 'It\'s a Cruel Summer with You Crewneck', 'Black crewneck featuring the words \"No Rules in Breakable Heaven\" printed on front and photo of Taylor Swift with the words \"It\'s a Cruel Summer with You\" and Cruel Summer song lyrics printed on back.\r\n\r\n80% cotton, 10% polyester, 10% recycled polyester');

-- --------------------------------------------------------

--
-- Структура таблиці `product_variants`
--

DROP TABLE IF EXISTS `product_variants`;
CREATE TABLE IF NOT EXISTS `product_variants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `size_id` int DEFAULT NULL,
  `product_quantity` int NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `size_id` (`size_id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `size_id`, `product_quantity`, `price`) VALUES
(1, 1, 7, 0, 1000),
(2, 1, 5, 30, 1000),
(3, 1, 9, 31, 1199),
(4, 1, 6, 30, 1199),
(5, 1, 8, 2, 1200),
(6, 2, 10, 3, 1610),
(7, 3, 10, 6, 1650),
(8, 4, 11, 17, 1200),
(9, 5, 11, 41, 2205),
(10, 6, 11, 33, 1500),
(11, 7, 11, 41, 1610),
(12, 8, 7, 19, -1600),
(13, 8, 5, 20, 1600),
(15, 8, 8, 17, -1600),
(17, 8, 9, 20, 1600),
(19, 8, 6, 20, 1600),
(21, 9, 5, 17, 1400),
(25, 9, 6, 20, 1400),
(27, 9, 9, 20, 1400),
(28, 9, 8, 20, 1400),
(29, 9, 7, 20, 1400),
(30, 10, 5, 20, 1400),
(31, 10, 6, 20, 1400),
(32, 10, 9, 20, 1400),
(33, 10, 8, 20, 1400),
(34, 10, 7, 20, 1400),
(40, 11, 11, 38, 1500),
(42, 12, 11, 37, 2300),
(44, 13, 10, 36, 1340),
(47, 14, 11, 40, 1200),
(48, 15, 5, 17, 1420),
(49, 15, 6, 20, 1420),
(50, 15, 9, 20, 1420),
(51, 15, 8, 20, 1420),
(52, 15, 7, 20, 1420),
(58, 16, 10, 46, 1000),
(60, 17, 11, 20, 1750),
(63, 19, 5, 50, 2000),
(64, 19, 7, 10, 2000),
(65, 19, 6, 10, 2000),
(66, 20, 5, 27, 1785),
(67, 21, 10, 2, 1300),
(72, 23, 5, 10, 1200);

-- --------------------------------------------------------

--
-- Структура таблиці `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'guest');

-- --------------------------------------------------------

--
-- Структура таблиці `sizes`
--

DROP TABLE IF EXISTS `sizes`;
CREATE TABLE IF NOT EXISTS `sizes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `size` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_size` (`size`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `sizes`
--

INSERT INTO `sizes` (`id`, `size`) VALUES
(3, '100 ml'),
(4, '150 ml'),
(1, '30 ml'),
(2, '50 ml'),
(9, 'L'),
(5, 'M'),
(11, 'No size'),
(10, 'One Size'),
(7, 'S'),
(6, 'XL'),
(8, 'XS');

-- --------------------------------------------------------

--
-- Структура таблиці `status`
--

DROP TABLE IF EXISTS `status`;
CREATE TABLE IF NOT EXISTS `status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status_description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `status`
--

INSERT INTO `status` (`id`, `status_description`) VALUES
(1, 'Нове замовлення'),
(2, 'В обробці'),
(3, 'Відправлено'),
(4, 'Доставлено'),
(5, 'Скасовано');

-- --------------------------------------------------------

--
-- Структура таблиці `storages`
--

DROP TABLE IF EXISTS `storages`;
CREATE TABLE IF NOT EXISTS `storages` (
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `size` text NOT NULL,
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `storages`
--

INSERT INTO `storages` (`order_id`, `product_id`, `quantity`, `size`) VALUES
(11, 1, 1, 'S'),
(12, 9, 1, 'M'),
(12, 6, 2, 'No size'),
(12, 12, 1, 'No size'),
(14, 9, 1, 'M'),
(14, 6, 2, 'No size'),
(14, 12, 1, 'No size'),
(15, 6, 1, 'No size'),
(16, 2, 2, 'One Size'),
(17, 2, 2, 'One Size'),
(18, 1, 1, 'S'),
(18, 16, 4, 'One Size'),
(19, 4, 1, 'No size'),
(20, 8, 2, 'XS'),
(20, 13, 1, 'One Size'),
(20, 3, 1, 'One Size'),
(21, 4, 2, 'No size'),
(21, 13, 3, 'One Size'),
(22, 8, 1, 'S'),
(22, 8, 1, 'XS'),
(23, 5, 4, 'No size'),
(24, 15, 3, 'M'),
(24, 2, 2, 'One Size'),
(24, 11, 2, 'No size');

-- --------------------------------------------------------

--
-- Структура таблиці `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role_id` int DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `name` varchar(150) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `birthday` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_email` (`email`),
  KEY `users_ibfk_1` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`id`, `role_id`, `email`, `password`, `name`, `lastname`, `birthday`) VALUES
(1, 2, 'sandra.bloger3@gmail.com', '$2y$10$532qiEJfT1B//cuLzp7FIuwqMnwn5rmgxNxsmnumGQIz1yvA72m0i', 'Каміла', 'Блогер', '2008-02-14'),
(2, 2, 'cat.lover@gmail.com', '$2y$10$rcyqoyhgksUwKqCMNvRWYemFNLdEOZ5nNQM2VW0L5eL3ISSpSiQay', 'Кет', 'Лу Сі', '2008-02-07'),
(8, 3, 'mia.mia55@gmail.com', '', 'Мія', 'Мія', '0000-00-00'),
(9, 2, 'sandra.bloger2@gmail.com', '$2y$10$1GEdJOAZw/VWROPVtEiNPOBh6O35NRnYuJif7M2r0THEcONBTjxAG', 'Сандра', 'Блогер', '2009-11-12'),
(11, 1, 'admin.cat@gmail.com', '$2y$10$tZ7EE7bdf6B05FZx05KkBOgkdNgzZSAqgp4vkZ5YIGPebh5qfibX6', 'Кішка', 'Адмін', '2013-12-31'),
(13, 3, 'miranda1998@gmail.com', '', 'Міранда', 'Сміт', '0000-00-00'),
(14, 3, 'katelovecats122@gmail.com', '', 'Катерина', 'Медичі', '0000-00-00');

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `address_information`
--
ALTER TABLE `address_information`
  ADD CONSTRAINT `address_information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `comments_and_rating`
--
ALTER TABLE `comments_and_rating`
  ADD CONSTRAINT `comments_and_rating_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_and_rating_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`status`) REFERENCES `status` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`address_id`) REFERENCES `address_information` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Обмеження зовнішнього ключа таблиці `photo_storage`
--
ALTER TABLE `photo_storage`
  ADD CONSTRAINT `photo_storage_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artist` (`artist_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_variants_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `storages`
--
ALTER TABLE `storages`
  ADD CONSTRAINT `storages_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `storages_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Обмеження зовнішнього ключа таблиці `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
