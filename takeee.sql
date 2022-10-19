-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 19 okt 2022 kl 14:32
-- Serverversion: 10.4.24-MariaDB
-- PHP-version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `takeee`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `blog`
--

CREATE TABLE `blog` (
  `ID` int(11) NOT NULL,
  `uID` int(11) NOT NULL COMMENT 'creators user ID',
  `title` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `description` text COLLATE utf8_swedish_ci NOT NULL,
  `date` datetime NOT NULL COMMENT 'creation date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `blog_entry`
--

CREATE TABLE `blog_entry` (
  `ID` int(11) NOT NULL,
  `bID` int(11) NOT NULL COMMENT 'blog ID',
  `uID` int(11) NOT NULL COMMENT 'blog entry users ID',
  `title` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `contents` text COLLATE utf8_swedish_ci NOT NULL,
  `date` datetime NOT NULL COMMENT 'creation Date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `blog_entry`
--

INSERT INTO `blog_entry` (`ID`, `bID`, `uID`, `title`, `contents`, `date`) VALUES
(1, 1, 1, 'Tjena bloggen!', 'Nu kor vi!', '2022-10-19 00:00:00');

-- --------------------------------------------------------

--
-- Tabellstruktur `event`
--

CREATE TABLE `event` (
  `ID` int(11) NOT NULL,
  `uID` int(11) NOT NULL COMMENT 'Creators ID',
  `title` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `description` text COLLATE utf8_swedish_ci NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `event`
--

INSERT INTO `event` (`ID`, `uID`, `title`, `description`, `startDate`, `endDate`) VALUES
(1, 1, 'My event', 'Test', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 1, 'My event', 'Test', '2022-10-19 10:41:00', '2022-10-19 11:41:00'),
(3, 1, 'din morsa', 'Test', '2022-10-19 10:42:00', '2022-10-19 11:42:00'),
(4, 1, 'din morsa', 'Test', '2030-12-09 13:37:00', '2030-12-09 14:37:00'),
(6, 1, 'din morsa', 'Test', '2022-10-19 10:44:00', '2022-10-19 11:44:00'),
(7, 1, 'din morsa', 'Test', '2022-10-19 10:44:00', '2022-10-19 11:44:00'),
(8, 1, 'din morsa', 'Test', '2030-12-09 13:37:00', '2120-12-09 13:37:00'),
(10, 1, 'din mårsa', 'Test', '2030-12-09 13:37:00', '2120-12-09 13:37:00'),
(11, 1, 'din mårsa', 'Test', '2030-12-09 13:37:00', '2120-12-09 13:37:00'),
(12, 1, 'Hej', 'Test', '2022-10-19 13:58:00', '2022-10-19 14:58:00');

-- --------------------------------------------------------

--
-- Tabellstruktur `event_invitation`
--

CREATE TABLE `event_invitation` (
  `ID` int(11) NOT NULL,
  `uID` int(11) NOT NULL COMMENT 'the invited persons ID',
  `eID` int(11) NOT NULL COMMENT 'the event ID',
  `accepted` tinyint(4) DEFAULT NULL COMMENT '1 = stay yes\r\n0 = REMOVE\r\nNULL = pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE `user` (
  `ID` int(255) NOT NULL,
  `name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `admin` varchar(3) COLLATE utf8_swedish_ci NOT NULL,
  `endUser` varchar(3) COLLATE utf8_swedish_ci NOT NULL,
  `description` text COLLATE utf8_swedish_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`ID`, `name`, `password`, `email`, `admin`, `endUser`, `description`, `avatar`) VALUES
(1, 'root', '$2y$10$3QYV6xl41UM7JNJLjXvwseoYAbIr1lZi.RnyM4EZVyr.hueSbjEFi', 'root@root.se', '111', '000', 'root', '');

-- --------------------------------------------------------

--
-- Tabellstruktur `wiki`
--

CREATE TABLE `wiki` (
  `ID` int(11) NOT NULL,
  `uID` int(11) NOT NULL COMMENT 'user''s ID',
  `title` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `wikiIndex` int(11) NOT NULL COMMENT 'wikiEntry ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `wiki`
--

INSERT INTO `wiki` (`ID`, `uID`, `title`, `wikiIndex`) VALUES
(1, 1, 'SCP', 3);

-- --------------------------------------------------------

--
-- Tabellstruktur `wiki_entry`
--

CREATE TABLE `wiki_entry` (
  `ID` int(11) NOT NULL,
  `wID` int(11) NOT NULL COMMENT 'wiki ID',
  `uID` int(11) NOT NULL COMMENT 'user ID',
  `title` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `contents` text COLLATE utf8_swedish_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `wiki_entry`
--

INSERT INTO `wiki_entry` (`ID`, `wID`, `uID`, `title`, `contents`, `date`) VALUES
(3, 1, 1, 'SCP-Foundation Main Page', 'Welcome to the unofficial SCP Wiki', '2022-10-14 00:00:00'),
(5, 1, 1, 'SCP-Foundation Main Page', 'Welcome to the unofficial SCP Wiki', '2022-10-14 00:00:00'),
(6, 1, 1, 'SCP-Foundation Main Page', 'Welcome to the unofficial SCP Wiki', '2022-10-14 00:00:00'),
(7, 1, 1, 'SCP-Foundation Main Page', 'Welcome to the unofficial SCP Wiki', '2022-10-14 00:00:00'),
(8, 1, 1, 'SCP-Foundation Main Page', 'Welcome to the unofficial SCP Wiki', '2022-10-14 00:00:00'),
(9, 1, 1, 'rr', 'rr', '2022-10-14 00:00:00'),
(10, 1, 1, 'tt', 'tt', '2022-10-14 00:00:00'),
(12, 1, 1, 'r', 'r', '2022-10-19 00:00:00'),
(14, 1, 1, 'HejHej', 'hej hej hej', '2022-10-19 00:00:00');

-- --------------------------------------------------------

--
-- Tabellstruktur `wiki_entry_history`
--

CREATE TABLE `wiki_entry_history` (
  `ID` int(11) NOT NULL,
  `oID` int(11) NOT NULL COMMENT 'original entry ID',
  `wID` int(11) NOT NULL COMMENT 'wiki ID',
  `uID` int(11) NOT NULL COMMENT 'editors user ID',
  `title` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `contents` text COLLATE utf8_swedish_ci NOT NULL,
  `date` datetime NOT NULL COMMENT 'creation date',
  `editDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `wiki_entry_history`
--

INSERT INTO `wiki_entry_history` (`ID`, `oID`, `wID`, `uID`, `title`, `contents`, `date`, `editDate`) VALUES
(1, 7, 1, 2, 'title', 'contents', '2022-03-20 00:00:00', '2022-04-20 00:00:00'),
(2, 8, 1, 1, 'r', 'r', '0000-00-00 00:00:00', '2022-10-18 00:00:00'),
(3, 13, 1, 1, 'Byebye', 'Sten drog :(', '0000-00-00 00:00:00', '2022-10-19 00:00:00'),
(4, 14, 1, 1, 'Hej da', 'dada', '0000-00-00 00:00:00', '2022-10-19 00:00:00');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `blog_entry`
--
ALTER TABLE `blog_entry`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `event_invitation`
--
ALTER TABLE `event_invitation`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `wiki`
--
ALTER TABLE `wiki`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `wiki_entry`
--
ALTER TABLE `wiki_entry`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `wiki_entry_history`
--
ALTER TABLE `wiki_entry_history`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `blog`
--
ALTER TABLE `blog`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT för tabell `blog_entry`
--
ALTER TABLE `blog_entry`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT för tabell `event`
--
ALTER TABLE `event`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT för tabell `event_invitation`
--
ALTER TABLE `event_invitation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT för tabell `wiki`
--
ALTER TABLE `wiki`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT för tabell `wiki_entry`
--
ALTER TABLE `wiki_entry`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT för tabell `wiki_entry_history`
--
ALTER TABLE `wiki_entry_history`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
