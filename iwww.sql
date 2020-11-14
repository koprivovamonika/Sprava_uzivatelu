-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Sob 14. lis 2020, 17:18
-- Verze serveru: 5.7.14
-- Verze PHP: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `iwww`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatele`
--

CREATE TABLE `uzivatele` (
  `id` int(11) NOT NULL,
  `jmeno` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `prijmeni` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `heslo` varchar(500) COLLATE utf8mb4_czech_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `opravneni` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `uzivatele`
--

INSERT INTO `uzivatele` (`id`, `jmeno`, `prijmeni`, `heslo`, `email`, `opravneni`) VALUES
(1, 'monika', 'koprivova', '$2y$10$eMGJ9htSEnMKk..6vB/09eQpdz.rfUI3yHbNYxG/3h6/RGM4lelWq', 'admin@admin.cz', 1),
(2, 'Lukáš', 'Novotný', '$2y$10$ItmOsS5abktasECelhbgFeKABsJlD8uPdBSrk4dpcsYpK9wm1bgv2', 'lukas@seznam.cz', 0),
(4, 'Adéla', 'Stará', '$2y$10$yKpsxOwsfUHGUKXPo5nWMO0LyFCwxupXP8RLBugr7EB5Dz93MC1Nm', 'adela@seznam.cz', 0);

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
