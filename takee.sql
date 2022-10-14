-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 14 okt 2022 kl 11:42
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
-- Databas: `takee`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `blog`
--

CREATE TABLE `blog` (
  `ID` int(11) NOT NULL,
  `uID` int(11) NOT NULL COMMENT 'creators user ID',
  `title` int(11) NOT NULL,
  `description` text COLLATE utf8_swedish_ci NOT NULL,
  `date` date NOT NULL COMMENT 'creation date'
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
  `date` date NOT NULL COMMENT 'creation Date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `event`
--

CREATE TABLE `event` (
  `ID` int(11) NOT NULL,
  `uID` int(11) NOT NULL COMMENT 'Creators ID',
  `title` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `description` text COLLATE utf8_swedish_ci NOT NULL,
  `startDate` int(11) NOT NULL,
  `endDate` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

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
  `email` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `admin` varchar(3) COLLATE utf8_swedish_ci NOT NULL,
  `endUser` varchar(3) COLLATE utf8_swedish_ci NOT NULL,
  `description` text COLLATE utf8_swedish_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

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
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `wiki_entry_history`
--

CREATE TABLE `wiki_entry_history` (
  `ID` int(11) NOT NULL,
  `wID` int(11) NOT NULL COMMENT 'wiki ID',
  `uID` int(11) NOT NULL COMMENT 'editors user ID',
  `title` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `contents` text COLLATE utf8_swedish_ci NOT NULL,
  `date` date NOT NULL COMMENT 'creation date',
  `editDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `blog_entry`
--
ALTER TABLE `blog_entry`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `event`
--
ALTER TABLE `event`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `event_invitation`
--
ALTER TABLE `event_invitation`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `wiki`
--
ALTER TABLE `wiki`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `wiki_entry`
--
ALTER TABLE `wiki_entry`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT för tabell `wiki_entry_history`
--
ALTER TABLE `wiki_entry_history`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
