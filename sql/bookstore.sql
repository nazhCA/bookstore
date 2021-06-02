-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2021. Jún 02. 16:45
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
  `name` varchar(200) NOT NULL,
  `author` varchar(200) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `books`
--

INSERT INTO `books` (`id`, `name`, `author`, `price`, `quantity`, `image`) VALUES
(1, 'Harry Potter and the Goblet of Fire', 'J.K.Rowling', 5000, 10, 'HP4cover.jpg'),
(2, 'Iron King', 'Julie Kagawa', 5000, 5, 'ironking.jpg'),
(4, 'World War Z', 'Max Brooks', 6000, 10, 'wwz.jpg'),
(5, '1984', 'George Orwell', 15000, 5, '1984.jpg'),
(6, 'The Lord of the Rings: The Fellowship of the Ring', 'J.R.R. Tolkien', 10000, 3, 'lotr1.jpg'),
(7, 'The Martian', 'Andy Weir', 5000, 13, 'themartian.jpg'),
(8, 'The Catcher in the Rye', 'J. D. Salinger', 4000, 0, 'catcher.jpg'),
(17, 'To Kill a Mockingbird', 'Harper Lee', 13000, 12, 'mocking.jpg'),
(18, 'The Great Gatsby', 'F. Scott Fitzgerald', 9000, 30, 'gatsby.jpg'),
(20, 'It', 'Stephen King', 5000, 5, 'it.jpg'),
(22, 'Sam', 'Iain Rob Wright', 4000, 3, 'sam.jpg');

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
(4, 'comedy'),
(4, 'drama'),
(5, 'crime'),
(5, 'drama'),
(6, 'fantasy'),
(7, 'drama'),
(18, 'crime'),
(18, 'drama'),
(20, 'crime'),
(22, 'drama'),
(22, 'horror');

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
(174, 'mph7ahbmk0bod01pdj043ij5ql', 4, 0),
(178, '3h1an60sm42bqqjvbbno64skgk', 2, 0),
(179, '3h1an60sm42bqqjvbbno64skgk', 5, 0),
(180, '3h1an60sm42bqqjvbbno64skgk', 22, 0),
(181, '3h1an60sm42bqqjvbbno64skgk', 20, 0),
(182, 'q779veu3j3t6odmgnim4p55p3t', 7, 1),
(183, 'q779veu3j3t6odmgnim4p55p3t', 6, 1),
(184, 'q779veu3j3t6odmgnim4p55p3t', 4, 1);

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
('horror'),
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
  `book_id` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `orders`
--

INSERT INTO `orders` (`order_id`, `session_id`, `user_name`, `user_phone`, `book_id`, `date`) VALUES
(49, 'mph7ahbmk0bod01pdj043ij5ql', 'Laci', '+341241252', 1, '2021-06-02'),
(50, 'mph7ahbmk0bod01pdj043ij5ql', 'Laci', '+341241252', 2, '2021-06-02'),
(51, 'mph7ahbmk0bod01pdj043ij5ql', 'Laci', '+341241252', 4, '2021-06-02'),
(52, '3h1an60sm42bqqjvbbno64skgk', 'Nóra', '+36201231234', 2, '2021-06-02'),
(53, '3h1an60sm42bqqjvbbno64skgk', 'Nóra', '+36201231234', 5, '2021-06-02'),
(54, '3h1an60sm42bqqjvbbno64skgk', 'Nóra', '+36201231234', 20, '2021-06-02'),
(55, '3h1an60sm42bqqjvbbno64skgk', 'Nóra', '+36201231234', 22, '2021-06-02');

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
  ADD PRIMARY KEY (`book_id`,`categ_name`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `categ_name` (`categ_name`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT a táblához `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT a táblához `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `book_categories`
--
ALTER TABLE `book_categories`
  ADD CONSTRAINT `const_book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `const_categ_name` FOREIGN KEY (`categ_name`) REFERENCES `categories` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `book_id` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Megkötések a táblához `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `book_id_const` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
