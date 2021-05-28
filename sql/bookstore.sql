-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Máj 28. 11:35
-- Kiszolgáló verziója: 10.4.19-MariaDB
-- PHP verzió: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `bookstore`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `author` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `books`
--

INSERT INTO `books` (`id`, `author`, `name`, `price`, `quantity`, `image`) VALUES
(1, 'J.K.Rowling', 'Harry Potter and the goblet of fire', 5000, 10, 'HP4cover.jpg'),
(2, 'Julie Kagawa', 'Iron King', 5000, 5, 'ironking.jpg'),
(4, 'Max Brooks', 'World War Z', 6000, 10, 'wwz.jpg'),
(5, 'George Orwell', '1984', 15000, 5, '1984.jpg'),
(6, 'J.R.R. Tolkien', 'The Lord of the Rings: The Fellowship of the Ring', 10000, 3, 'lotr1.jpg'),
(7, 'Andy Weir', 'The Martian', 5000, 13, 'themartian.jpg'),
(8, 'J. D. Salinger', 'The Catcher in the Rye', 4000, 0, 'catcher.jpg');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `book_categories`
--

CREATE TABLE `book_categories` (
  `book_id` int(11) NOT NULL,
  `categ_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `book_categories`
--

INSERT INTO `book_categories` (`book_id`, `categ_name`) VALUES
(1, 'fantasy'),
(2, 'fantasy'),
(4, 'drama'),
(5, 'drama'),
(5, 'crime'),
(7, 'sci-fi'),
(7, 'drama'),
(6, 'fantasy');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `session_id` varchar(50) NOT NULL,
  `book_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `carts`
--

INSERT INTO `carts` (`id`, `session_id`, `book_id`, `active`) VALUES
(78, '2lrr384j35r6ksqokm8uok67pg', 1, 0),
(79, '2lrr384j35r6ksqokm8uok67pg', 2, 0),
(80, '2lrr384j35r6ksqokm8uok67pg', 4, 0),
(83, 'fte61h8h51j9hhp20t3b7eiuod', 5, 1),
(84, 'fte61h8h51j9hhp20t3b7eiuod', 6, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `categories`
--

CREATE TABLE `categories` (
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `categories`
--

INSERT INTO `categories` (`name`) VALUES
('comedy'),
('crime'),
('drama'),
('fantasy'),
('romantic'),
('sci-fi');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `session_id` varchar(50) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_phone` varchar(50) NOT NULL,
  `book_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `orders`
--

INSERT INTO `orders` (`order_id`, `session_id`, `user_name`, `user_phone`, `book_id`) VALUES
(31, '2lrr384j35r6ksqokm8uok67pg', 'Laci', '+341241252', 1),
(32, '2lrr384j35r6ksqokm8uok67pg', 'Laci', '+341241252', 2),
(33, '2lrr384j35r6ksqokm8uok67pg', 'Laci', '+341241252', 4);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- A tábla indexei `book_categories`
--
ALTER TABLE `book_categories`
  ADD KEY `const_book_id` (`book_id`),
  ADD KEY `const_categ_name` (`categ_name`);

--
-- A tábla indexei `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`);

--
-- A tábla indexei `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`name`);

--
-- A tábla indexei `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `book_id_const` (`book_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT a táblához `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `book_categories`
--
ALTER TABLE `book_categories`
  ADD CONSTRAINT `const_book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `const_categ_name` FOREIGN KEY (`categ_name`) REFERENCES `categories` (`name`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Megkötések a táblához `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Megkötések a táblához `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `book_id_const` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
