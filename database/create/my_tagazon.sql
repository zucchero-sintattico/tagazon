-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 04, 2022 at 10:33 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_tagazon`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyers`
--

CREATE TABLE `buyers` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buyers`
--

INSERT INTO `buyers` (`id`, `email`, `password`, `name`, `surname`) VALUES
(1, 'buyer0@email.com', '$2y$10$3zVVcN174FQD4xGa5wIZuucItyKJ1Qi0EYeWsiChBkSP4eXyziA0e', 'Buyer0', 'Surname0'),
(2, 'buyer1@email.com', '$2y$10$6OkdxDq/buGCFZeijKacUOW2HFqJqpNhIysbo1d3ufghwkvDAb2lK', 'Buyer1', 'Surname1'),
(3, 'buyer2@email.com', '$2y$10$vEDesgMen3f7udFNNEA9.OMPRQ1sDG/Q5U4ufVFL6SC5QN/8pKrXC', 'Buyer2', 'Surname2'),
(4, 'buyer3@email.com', '$2y$10$SQUULXFKsGQXjIs0mvN7ke53ifoaWKj.8sawXEks0LIm/sLQD9sdC', 'Buyer3', 'Surname3'),
(5, 'buyer4@email.com', '$2y$10$5jLXJLCEFlfJ4DQ9RvjgbORKc6ia86ttclB/NQo8Smj7.UxX.UaCu', 'Buyer4', 'Surname4'),
(6, 'buyer5@email.com', '$2y$10$EnwxyBSF7ApT06HUrLpjDOmlpfqDz0i.2z1dtlfbPAYBdtwjb/Tlu', 'Buyer5', 'Surname5'),
(7, 'buyer6@email.com', '$2y$10$CF1VAq1EuvJc44achsboYel2dJ5tERcsIZlxHSmfLmYSJOE5u/bw2', 'Buyer6', 'Surname6'),
(8, 'buyer7@email.com', '$2y$10$1YPQlcXGS.DKYjpNuRQ4fuEHaDEZhc/hD4U9MYsEvSQ9WO6OwnpJK', 'Buyer7', 'Surname7'),
(9, 'buyer8@email.com', '$2y$10$KyK3mF3b.p3lCKJgLQefleiaQR.33aue/.GqDf2AawrcLxQHek9uq', 'Buyer8', 'Surname8'),
(10, 'buyer9@email.com', '$2y$10$dSeZBeWSmz78zAgz27RYAeFwJPC3.oyW8VDcX4PVC81J/IYCY6BOO', 'Buyer9', 'Surname9');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'flow', 'Flow content is a broad category that encompasses most elements that can go inside the <body> element, including heading elements, sectioning elements, phrasing elements, embedding elements, interactive elements, and form-related elements. It also includes text nodes (but not those that only consist of white space characters)'),
(2, 'phrasing', 'Phrasing content is any textual content that is not a child of a flow content, or a flow content that is not a child of a phrasing content. This includes text nodes, comments, elements with no children, and elements that are children of a flow content, but not phrasing content.'),
(3, 'interactive', 'Interactive content is content that requires user input, such as user interface controls, or a <button> element.'),
(4, 'embedded', 'Embedded content is content that is embedded, or could be embedded, in other content. Examples include applets, frames, iframes, and plug-ins.'),
(5, 'sectioning', 'Sectioning content is content that is a heading, or a group of headings that are related and are repeated in the same document more than once.'),
(6, 'heading', 'Heading content is content that is a heading, or a group of headings that are related but are not repeated in the same document.'),
(7, 'metadata', 'Metadata content is information that is not meant for presentation, such as a <meta> element, a <link> element, a <script> element, or a <style> element.');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `title` text NOT NULL,
  `message` text NOT NULL,
  `received` tinyint(1) NOT NULL DEFAULT 0,
  `seen` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `buyer` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `order_tags`
--

CREATE TABLE `order_tags` (
  `id` int(11) NOT NULL,
  `tag` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `card-owner` varchar(255) NOT NULL,
  `card-number` int(11) NOT NULL,
  `card-expiry-year` varchar(2) NOT NULL,
  `card-expiry-month` varchar(2) NOT NULL,
  `card-cvc` int(11) NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rag_soc` varchar(128) NOT NULL,
  `piva` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `email`, `password`, `rag_soc`, `piva`) VALUES
(1, 'w3c@email.com', '$2y$10$fC4TL.O8p49w8V0xvi.ucuJbcNlv/B2FC8pT11BRxL7srVx/ABJPW', 'World Wide Web Consortium', '12345678901'),
(2, 'seller0@email.com', '$2y$10$M5hR3hnqkNA1tE1UnManLewo8A1qwq9rSVttgnLAunLTTbnq3sdEG', 'Seller0', '1234567890'),
(3, 'seller1@email.com', '$2y$10$lz3XXO6MA9mMK2G4.Bgkbuvj2729vdiOY2l74PIFteX5Mt7LHXCRu', 'Seller1', '1234567891'),
(4, 'seller2@email.com', '$2y$10$1S76qAIlCbwOKMw0KlpglO31.D9Z1cwzGK7s7jgpIK4sn8egHe6Se', 'Seller2', '1234567892'),
(5, 'seller3@email.com', '$2y$10$ybnc3jzKy0OR7ZMVDwopa.B.wBDyV8QPWzo66T/qiVXKXwum6iC3.', 'Seller3', '1234567893'),
(6, 'seller4@email.com', '$2y$10$wsk.vfoC9ZFgf9KjN3xlXOMck8Ss.6OlX8fztRCzd7nVePRQAY/hi', 'Seller4', '1234567894'),
(7, 'seller5@email.com', '$2y$10$/Lp5YTDS4mmaph/BRf3PNOmb1W92vS1vqGXaVeoekWKManopWXmXm', 'Seller5', '1234567895'),
(8, 'seller6@email.com', '$2y$10$HwBhbtdGsM8fbYuxa.Eg1ezEOjMsHx8vHBJ9hJKBrOK/rkX3jws8.', 'Seller6', '1234567896'),
(9, 'seller7@email.com', '$2y$10$8s6cWI7D9ycX5tsnFmA4vOK6nn7jqCXkGJ.QK3l2B5UR3RTCsZ3yS', 'Seller7', '1234567897'),
(10, 'seller8@email.com', '$2y$10$PbNRVRT3WsZ0/g.ixXbf1uNjWp/LAT3mbDdD4h3/oZliYdgHTlwXS', 'Seller8', '1234567898'),
(11, 'seller9@email.com', '$2y$10$qh2kI/Ew2RH3MQnmER.lcumAaFAYssmUpmBMGuChDsgAW0RcwS73m', 'Seller9', '1234567899');

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart_tags`
--

CREATE TABLE `shoppingcart_tags` (
  `id` int(11) NOT NULL,
  `tag` int(11) NOT NULL,
  `buyer` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `example` text NOT NULL,
  `example_desc` text NOT NULL,
  `seller` int(11) NOT NULL,
  `price` float NOT NULL,
  `sale_price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tag_categories`
--

CREATE TABLE `tag_categories` (
  `id` int(11) NOT NULL,
  `tag` int(11) NOT NULL,
  `category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `buyer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_tags`
--

CREATE TABLE `wishlist_tags` (
  `id` int(11) NOT NULL,
  `tag` int(11) NOT NULL,
  `wishlist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyers`
--
ALTER TABLE `buyers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order` (`order`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `buyer` (`buyer`);

--
-- Indexes for table `order_tags`
--
ALTER TABLE `order_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag` (`tag`,`order`),
  ADD KEY `order` (`order`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order` (`order`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `rag_soc` (`rag_soc`);

--
-- Indexes for table `shoppingcart_tags`
--
ALTER TABLE `shoppingcart_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag` (`tag`,`buyer`),
  ADD KEY `buyer` (`buyer`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `seller` (`seller`);

--
-- Indexes for table `tag_categories`
--
ALTER TABLE `tag_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag` (`tag`,`category`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `buyer` (`buyer`,`name`);

--
-- Indexes for table `wishlist_tags`
--
ALTER TABLE `wishlist_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag` (`tag`,`wishlist`),
  ADD KEY `wishlist` (`wishlist`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyers`
--
ALTER TABLE `buyers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_tags`
--
ALTER TABLE `order_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `shoppingcart_tags`
--
ALTER TABLE `shoppingcart_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tag_categories`
--
ALTER TABLE `tag_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist_tags`
--
ALTER TABLE `wishlist_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`order`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`buyer`) REFERENCES `buyers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_tags`
--
ALTER TABLE `order_tags`
  ADD CONSTRAINT `order_tags_ibfk_1` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_tags_ibfk_2` FOREIGN KEY (`order`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shoppingcart_tags`
--
ALTER TABLE `shoppingcart_tags`
  ADD CONSTRAINT `shoppingcart_tags_ibfk_1` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shoppingcart_tags_ibfk_2` FOREIGN KEY (`buyer`) REFERENCES `buyers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_ibfk_1` FOREIGN KEY (`seller`) REFERENCES `sellers` (`id`);

--
-- Constraints for table `tag_categories`
--
ALTER TABLE `tag_categories`
  ADD CONSTRAINT `tag_categories_ibfk_1` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tag_categories_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`buyer`) REFERENCES `buyers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist_tags`
--
ALTER TABLE `wishlist_tags`
  ADD CONSTRAINT `wishlist_tags_ibfk_1` FOREIGN KEY (`tag`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_tags_ibfk_2` FOREIGN KEY (`wishlist`) REFERENCES `wishlists` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
