-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 12 Lis 2018, 09:34
-- Wersja serwera: 10.1.34-MariaDB
-- Wersja PHP: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `events`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `events_eventCategory`
--

CREATE TABLE `events_eventCategory` (
  `id` int(11) NOT NULL,
  `category` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;



--
-- Struktura tabeli dla tabeli `events_events`
--

CREATE TABLE `events_events` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `description` text COLLATE utf8_polish_ci NOT NULL,
  `category` text COLLATE utf8_polish_ci NOT NULL,
  `startDate` date NOT NULL,
  `startTime` time(5) NOT NULL,
  `endDate` date NOT NULL,
  `endTime` time(5) NOT NULL,
  `picture` text COLLATE utf8_polish_ci NOT NULL,
  `www` text COLLATE utf8_polish_ci NOT NULL,
  `province` text COLLATE utf8_polish_ci NOT NULL,
  `city` text COLLATE utf8_polish_ci NOT NULL,
  `address` text COLLATE utf8_polish_ci NOT NULL,
  `createdBy` text COLLATE utf8_polish_ci NOT NULL,
  `createdOn` datetime NOT NULL,
  `blocked` tinyint(1) DEFAULT NULL,
  `blockedOn` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-
--
-- Struktura tabeli dla tabeli `events_province`
--

CREATE TABLE `events_province` (
  `province` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `events_province`
--

INSERT INTO `events_province` (`province`) VALUES
('dolnośląskie'),
('kujawsko-pomorskie'),
('lubelskie'),
('lubuskie'),
('łódzkie'),
('małopolskie'),
('mazowieckie'),
('opolskie'),
('podkarpackie'),
('podlaskie'),
('pomorskie'),
('śląskie'),
('świętokrzyskie'),
('warmińsko-mazurskie'),
('wielkopolskie'),
('zachodniopomorskie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `events_users`
--

CREATE TABLE `events_users` (
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `password` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `bann` int(1) DEFAULT NULL,
  `registeredOn` datetime(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `events_eventCategory`
--
ALTER TABLE `events_eventCategory`
  ADD PRIMARY KEY (`category`(30)),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indeksy dla tabeli `events_events`
--
ALTER TABLE `events_events`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `events_province`
--
ALTER TABLE `events_province`
  ADD PRIMARY KEY (`province`(40));

--
-- Indeksy dla tabeli `events_users`
--
ALTER TABLE `events_users`
  ADD PRIMARY KEY (`login`(15)),
  ADD UNIQUE KEY `email` (`email`(100));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `events_events`
--
ALTER TABLE `events_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
