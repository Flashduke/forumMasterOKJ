-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2022. Már 29. 13:00
-- Kiszolgáló verziója: 10.4.21-MariaDB
-- PHP verzió: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `forum`
--
CREATE DATABASE IF NOT EXISTS `forum` DEFAULT CHARACTER SET utf8 COLLATE utf8_hungarian_ci;
USE `forum`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `comments`
--

CREATE TABLE `comments` (
  `id` int(255) NOT NULL,
  `createdAt` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `content` text COLLATE utf8_hungarian_ci NOT NULL,
  `postID` int(255) NOT NULL,
  `userID` int(255) NOT NULL,
  `thumbsDowns` int(255) NOT NULL,
  `thumbsUps` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `comments`
--

INSERT INTO `comments` (`id`, `createdAt`, `content`, `postID`, `userID`, `thumbsDowns`, `thumbsUps`) VALUES
(1, '2021-12-24 22:18:39', 'this comment was posted and edited to test out my REST API built in vanilla PHP', 1, 1, 0, 0),
(4, '2022-03-26 15:04:13', 'asd', 8, 3, 0, 0);

-- --------------------------------------------------------

--
-- A nézet helyettes szerkezete `comments_view`
-- (Lásd alább az aktuális nézetet)
--
CREATE TABLE `comments_view` (
`id` int(255)
,`postID` int(255)
,`author` varchar(255)
,`postTitle` varchar(255)
,`communityName` varchar(255)
,`content` text
,`createdAt` TIMESTAMP
,`thumbsUps` decimal(32,0)
,`thumbsDowns` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `communities`
--

CREATE TABLE `communities` (
  `id` int(255) NOT NULL,
  `createdAt` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `description` text COLLATE utf8_hungarian_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `banner` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `communities`
--

INSERT INTO `communities` (`id`, `createdAt`, `description`, `name`, `banner`, `icon`) VALUES
(1, '2021-12-24 18:51:32', 'This is a test community, created to test out my vanilla PHP REST API.', 'Test community', NULL, NULL),
(4, '2021-12-24 21:13:38', 'This Community was created and updated using Insomnia to test out my PHP vanilla REST API.', 'REST Test Updated', NULL, NULL),
(6, '2022-02-24 19:33:51', '``', '``', NULL, NULL),
(7, '2022-02-24 19:34:30', '``', '', NULL, NULL),
(8, '2022-02-24 19:35:05', '``', '````', NULL, NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `followers`
--

CREATE TABLE `followers` (
  `id` int(11) NOT NULL,
  `profileID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `followers`
--

INSERT INTO `followers` (`id`, `profileID`, `userID`) VALUES
(2, 1, 3);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `communityID` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `members`
--

INSERT INTO `members` (`id`, `communityID`, `userID`) VALUES
(7, 1, 3);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `posts`
--

CREATE TABLE `posts` (
  `id` int(255) NOT NULL,
  `communityID` int(255) NOT NULL,
  `content` text COLLATE utf8_hungarian_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `createdAt` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `userID` int(255) NOT NULL,
  `thumbsDowns` int(255) NOT NULL,
  `thumbsUps` int(255) NOT NULL,
  `title` varchar(255) COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `posts`
--

INSERT INTO `posts` (`id`, `communityID`, `content`, `picture`, `createdAt`, `userID`, `thumbsDowns`, `thumbsUps`, `title`) VALUES
(1, 1, 'This post was created and updated using Insomnia, an API design platform.', '', '2021-12-24 19:12:03', 1, 0, 0, 'Updated Post'),
(2, 1, 'Post was made with Insomnia', '', '2022-01-03 18:30:32', 1, 0, 0, 'Testing authorized posting'),
(3, 1, 'Testing authorization...', 'no-picture', '2022-02-06 10:16:35', 1, 0, 0, 'JWT Auth'),
(4, 1, 'sent using axios', '', '2022-02-22 19:05:09', 3, 0, 0, 'axios private test'),
(5, 1, 'sent using axios', '', '2022-02-22 19:06:32', 3, 0, 0, 'axios private test'),
(7, 1, '# GFM\r\n\r\n## Autolink literals\r\n\r\nwww.example.com, https://example.com, and contact@example.com.\r\n![asdKép](http://localhost/forumMasterOKJ/php_rest_forum/img/unnamed.png)\r\n\r\n## Footnote\r\n\r\nA note[^1]\r\n\r\n[^1]: Big note.\r\n\r\n## Strikethrough\r\n\r\n~one~ or ~~two~~ tildes.\r\n\r\n## Table\r\n\r\n| a | b  |  c |  d  |\r\n| - | :- | -: | :-: |\r\n\r\n## Tasklist\r\n\r\n* [ ] to do\r\n* [x] done', 'no-pic', '2022-02-26 12:15:35', 1, 0, 0, 'asd'),
(8, 1, 'sent using axios', NULL, '2022-03-03 11:18:17', 1, 0, 0, 'axios private test'),
(14, 1, 'asd', NULL, '2022-03-27 10:09:17', 3, 0, 0, 'asd');

-- --------------------------------------------------------

--
-- A nézet helyettes szerkezete `posts_view`
-- (Lásd alább az aktuális nézetet)
--
CREATE TABLE `posts_view` (
`id` int(255)
,`author` varchar(255)
,`communityName` varchar(255)
,`title` varchar(255)
,`content` text
,`createdAt` TIMESTAMP
,`thumbsUps` decimal(32,0)
,`thumbsDowns` decimal(32,0)
,`commentCount` bigint(21)
);

-- --------------------------------------------------------

--
-- A nézet helyettes szerkezete `profiles`
-- (Lásd alább az aktuális nézetet)
--
CREATE TABLE `profiles` (
`id` int(255)
,`createdAt` date
,`name` varchar(255)
,`description` text
,`icon` varchar(255)
,`banner` varchar(255)
,`followerCount` bigint(21)
);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ratedcomments`
--

CREATE TABLE `ratedcomments` (
  `id` int(255) NOT NULL,
  `commentID` int(255) NOT NULL,
  `userID` int(255) NOT NULL,
  `thumbsUp` int(11) DEFAULT NULL,
  `thumbsDown` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `ratedcomments`
--

INSERT INTO `ratedcomments` (`id`, `commentID`, `userID`, `thumbsUp`, `thumbsDown`) VALUES
(1, 1, 1, 0, 1),
(10, 1, 3, 1, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ratedposts`
--

CREATE TABLE `ratedposts` (
  `id` int(255) NOT NULL,
  `postID` int(255) NOT NULL,
  `userID` int(255) NOT NULL,
  `thumbsUp` int(11) DEFAULT NULL,
  `thumbsDown` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `ratedposts`
--

INSERT INTO `ratedposts` (`id`, `postID`, `userID`, `thumbsUp`, `thumbsDown`) VALUES
(1, 1, 1, 0, 1),
(18, 8, 3, 1, 0),
(19, 7, 3, 1, 0),
(21, 1, 3, 0, 1),
(35, 2, 3, 0, 1),
(49, 5, 3, 0, 1),
(50, 4, 3, 1, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `email` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL,
  `createdAt` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `role` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `refreshToken` text COLLATE utf8_hungarian_ci DEFAULT NULL,
  `description` text COLLATE utf8_hungarian_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8_hungarian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `picture`, `createdAt`, `role`, `name`, `refreshToken`, `description`, `banner`) VALUES
(1, 'flash@duke.hu', '334c4a4c42fdb79d7ebc3e73b517e6f8', 'no-picture', '2021-12-24', 'owner', 'Flashduke', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJQSFBfUkVTVCIsImF1ZCI6IlJFQUNUX0ZPUlVNIiwiaWF0IjoxNjQ2NTg1ODg4LCJuYmYiOjE2NDY1ODU4OTgsImV4cCI6MTY0NjY3MjI4OCwiZGF0YSI6eyJpZCI6IjEiLCJlbWFpbCI6ImZsYXNoQGR1a2UuaHUiLCJyb2xlIjoib3duZXIiLCJuYW1lIjoiRmxhc2hkdWtlIn19.BQDeE8OCBgmSfDfISIQwDuhw5xeu7CUB_8BBrbE0BuI', NULL, NULL),
(3, 'asd@asd.com', '7815696ecbf1c96e6894b779456d330e', 'no-picture', '2022-01-08', 'user', 'asd', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJQSFBfUkVTVCIsImF1ZCI6IlJFQUNUX0ZPUlVNIiwiaWF0IjoxNjQ4NTM3MjExLCJuYmYiOjE2NDg1MzcyMjEsImV4cCI6MTY0ODYyMzYxMSwiZGF0YSI6eyJpZCI6IjMiLCJlbWFpbCI6ImFzZEBhc2QuY29tIiwicm9sZSI6InVzZXIiLCJuYW1lIjoiYXNkIn19.iCJdAw-e7nX3RIvodkSBfULtINTgeGQzymNZ2a-xjsI', NULL, NULL),
(7, 'asd@asd.asd', 'a3dcb4d229de6fde0db5686dee47145d', '', '2022-02-17', '', 'asdasdasd', NULL, NULL, NULL),
(8, 'asd@asd.asd', 'd1869a99af56613eb59546eaf7ce8608', '', '2022-02-17', '', 'asdasd', NULL, NULL, NULL),
(9, 'asdasddasasd@test.test', 'fcff23bc82122e9453714a731e020b5e', '', '2022-02-17', '', 'asdasd', NULL, NULL, NULL),
(10, 'asd@asd.asd', '6371833e6708f4dc93105513140e4bc9', '', '2022-02-17', '', 'asdasd', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Nézet szerkezete `comments_view`
--
DROP TABLE IF EXISTS `comments_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `comments_view`  AS SELECT `comments`.`id` AS `id`, `comments`.`postID` AS `postID`, `users`.`name` AS `author`, `posts`.`title` AS `postTitle`, `communities`.`name` AS `communityName`, `comments`.`content` AS `content`, `comments`.`createdAt` AS `createdAt`, sum(`ratedcomments`.`thumbsUp`) AS `thumbsUps`, sum(`ratedcomments`.`thumbsDown`) AS `thumbsDowns` FROM ((((`comments` left join `users` on(`users`.`id` = `comments`.`userID`)) left join `posts` on(`posts`.`id` = `comments`.`postID`)) left join `communities` on(`posts`.`communityID` = `communities`.`id`)) left join `ratedcomments` on(`comments`.`id` = `ratedcomments`.`commentID`)) GROUP BY `comments`.`id` ORDER BY `comments`.`createdAt` DESC ;

-- --------------------------------------------------------

--
-- Nézet szerkezete `posts_view`
--
DROP TABLE IF EXISTS `posts_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `posts_view`  AS SELECT `posts`.`id` AS `id`, `users`.`name` AS `author`, `communities`.`name` AS `communityName`, `posts`.`title` AS `title`, `posts`.`content` AS `content`, `posts`.`createdAt` AS `createdAt`, sum(`ratedposts`.`thumbsUp`) AS `thumbsUps`, sum(`ratedposts`.`thumbsDown`) AS `thumbsDowns`, count(`comments`.`id`) AS `commentCount` FROM ((((`posts` left join `users` on(`posts`.`userID` = `users`.`id`)) left join `ratedposts` on(`ratedposts`.`postID` = `posts`.`id`)) left join `communities` on(`posts`.`communityID` = `communities`.`id`)) left join `comments` on(`posts`.`id` = `comments`.`postID`)) GROUP BY `posts`.`id` ORDER BY `posts`.`id` DESC ;

-- --------------------------------------------------------

--
-- Nézet szerkezete `profiles`
--
DROP TABLE IF EXISTS `profiles`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `profiles`  AS SELECT `users`.`id` AS `id`, `users`.`createdAt` AS `createdAt`, `users`.`name` AS `name`, `users`.`description` AS `description`, `users`.`picture` AS `icon`, `users`.`banner` AS `banner`, count(`followers`.`userID`) AS `followerCount` FROM (`users` left join `followers` on(`followers`.`profileID` = `users`.`id`)) GROUP BY `users`.`id` ORDER BY `users`.`name` ASC ;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postID` (`postID`),
  ADD KEY `profileID` (`userID`);

--
-- A tábla indexei `communities`
--
ALTER TABLE `communities`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profileID` (`profileID`),
  ADD KEY `userID` (`userID`);

--
-- A tábla indexei `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `communityID` (`communityID`),
  ADD KEY `userID` (`userID`);

--
-- A tábla indexei `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `communityID` (`communityID`),
  ADD KEY `profileID` (`userID`);

--
-- A tábla indexei `ratedcomments`
--
ALTER TABLE `ratedcomments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`),
  ADD KEY `commentID` (`commentID`) USING BTREE;

--
-- A tábla indexei `ratedposts`
--
ALTER TABLE `ratedposts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`),
  ADD KEY `postID` (`postID`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT a táblához `communities`
--
ALTER TABLE `communities`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT a táblához `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT a táblához `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT a táblához `ratedcomments`
--
ALTER TABLE `ratedcomments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `ratedposts`
--
ALTER TABLE `ratedposts`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`postID`) REFERENCES `posts` (`ID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`);

--
-- Megkötések a táblához `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`profileID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`communityID`) REFERENCES `communities` (`ID`),
  ADD CONSTRAINT `members_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`communityID`) REFERENCES `communities` (`ID`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`);

--
-- Megkötések a táblához `ratedcomments`
--
ALTER TABLE `ratedcomments`
  ADD CONSTRAINT `ratedcomments_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ratedcomments_ibfk_2` FOREIGN KEY (`commentID`) REFERENCES `posts` (`ID`),
  ADD CONSTRAINT `ratedcomments_ibfk_3` FOREIGN KEY (`commentID`) REFERENCES `comments` (`ID`);

--
-- Megkötések a táblához `ratedposts`
--
ALTER TABLE `ratedposts`
  ADD CONSTRAINT `ratedposts_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ratedposts_ibfk_2` FOREIGN KEY (`postID`) REFERENCES `posts` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
