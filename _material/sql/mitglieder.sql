-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 06. Jul 2022 um 11:01
-- Server-Version: 5.7.38-0ubuntu0.18.04.1
-- PHP-Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `mitgliederbefragung`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mitglieder`
--

CREATE TABLE `mitglieder` (
  `id` int(11) NOT NULL,
  `mitgliedsnummer` int(11) NOT NULL,
  `vorname` varchar(70) NOT NULL,
  `nachname` varchar(70) NOT NULL,
  `titel` varchar(15) DEFAULT NULL,
  `geburtstag` date NOT NULL,
  `email` varchar(80) DEFAULT NULL,
  `anrede` varchar(6) DEFAULT NULL,
  `einmalcode` varchar(12) NOT NULL,
  `hatgewaehlt` datetime DEFAULT NULL,
  `ipadresse` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Indizes für die Tabelle `mitglieder`
--
ALTER TABLE `mitglieder`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `einmalcode` (`einmalcode`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `mitglieder`
--
ALTER TABLE `mitglieder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
