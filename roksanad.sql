-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Czas generowania: 25 Maj 2026, 22:30
-- Wersja serwera: 10.5.29-MariaDB-0+deb11u1
-- Wersja PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `roksanad`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `jednostki`
--

CREATE TABLE `jednostki` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `symbol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `jednostki`
--

INSERT INTO `jednostki` (`id`, `nazwa`, `symbol`) VALUES
(1, 'stopień Celsjusza', '°C'),
(2, 'milimetr słupa rtęci', 'mmHg'),
(3, 'kilogram', 'kg'),
(4, 'uderzenia na minutę', 'bpm'),
(5, 'miligram na decylitr', 'mg/dL'),
(6, 'procent', '%'),
(7, 'nanogram na mililitr', 'ng/mL');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `logowania`
--

CREATE TABLE `logowania` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sukces` tinyint(1) NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `data_proby` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `logowania`
--

INSERT INTO `logowania` (`id`, `email`, `sukces`, `ip`, `data_proby`) VALUES
(1, '', 0, '2001:6d8:10:8210::8c', '2026-05-15 15:39:11'),
(2, '', 0, '2001:6d8:10:8210::8c', '2026-05-15 15:39:48'),
(3, '', 0, '2001:6d8:10:8210::8c', '2026-05-15 15:44:10'),
(4, 'roksana@gmail.pl', 0, '2001:6d8:10:8210::8c', '2026-05-15 16:02:54'),
(5, 'misiek@wp.pl', 0, '2001:6d8:10:8210::8c', '2026-05-15 16:06:17'),
(6, 'jankowalski@gmail.com', 0, '2001:6d8:10:8210::8c', '2026-05-15 16:07:49'),
(7, 'jankow@gmail.com', 1, '2001:6d8:10:8210::8c', '2026-05-15 16:08:20'),
(8, 'jankow@gmail.com', 1, '2001:6d8:10:8210::8c', '2026-05-15 16:14:22'),
(9, 'jankow@gmail.com', 1, '2001:6d8:10:8210::8c', '2026-05-15 16:25:56'),
(10, 'jankow@gmail.com', 1, '2001:6d8:10:8210::8c', '2026-05-15 16:26:46'),
(11, 'jankow@gmail.com', 1, '2001:6d8:10:8210::8c', '2026-05-15 16:45:02'),
(12, 'jankow@gmail.com', 1, '2001:6d8:10:8210::8c', '2026-05-15 17:12:50'),
(13, 'jankow@gmail.com', 1, '2001:6d8:10:8210::8c', '2026-05-15 18:08:30'),
(14, 'jankow@gmail.com', 1, '2001:6d8:10:8210::8c', '2026-05-15 18:52:03'),
(15, 'jankow@gmail.com', 1, '2001:6d8:10:8210::8c', '2026-05-15 19:07:56'),
(16, 'jankow@gmail.com', 1, '2001:6d8:10:8210::8c', '2026-05-15 19:08:16'),
(17, 'jankow@gmail.com', 1, '2001:6d8:10:8210::8c', '2026-05-15 19:21:50'),
(18, 'jankow@gmail.com', 1, '2001:6d8:10:8210::8c', '2026-05-15 19:25:03'),
(19, 'jankow@gmail.com', 1, '2001:6d8:10:8210::19e', '2026-05-25 16:38:20'),
(20, 'jankow@gmail.com', 1, '2001:6d8:10:8210::19e', '2026-05-25 16:40:20'),
(21, 'jankow@gmail.com', 1, '2001:6d8:10:8210::19e', '2026-05-25 18:03:39'),
(22, 'nowak@wp.pl', 1, '2001:6d8:10:8210::19e', '2026-05-25 18:05:34'),
(23, 'nowak@wp.pl', 1, '2001:6d8:10:8210::19e', '2026-05-25 18:21:10'),
(24, 'lupa@gmail.com', 1, '2001:6d8:10:8210::19e', '2026-05-25 19:06:30'),
(25, 'jankow@gmail.com', 1, '2001:6d8:10:8210::19e', '2026-05-25 19:07:37'),
(26, 'jankow@gmail.com', 1, '2001:6d8:10:8210::19e', '2026-05-25 19:08:58'),
(27, 'jankow@gmail.com', 1, '2001:6d8:10:8210::19e', '2026-05-25 19:13:07'),
(28, 'lupa@gmail.com', 1, '2001:6d8:10:8210::19e', '2026-05-25 19:14:55'),
(29, 'jankow@gmail.com', 1, '2001:6d8:10:8210::19e', '2026-05-25 19:24:19'),
(30, 'jankow@gmail.com', 1, '2001:6d8:10:8210::19e', '2026-05-25 20:12:52'),
(31, 'jankow@gmail.com', 1, '2001:6d8:10:8210::19e', '2026-05-25 22:20:36'),
(32, 'nowak@wp.pl', 1, '2001:6d8:10:8210::19e', '2026-05-25 22:23:22');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `parametry`
--

CREATE TABLE `parametry` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(100) NOT NULL,
  `jednostka_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `norma_min` decimal(10,2) DEFAULT NULL,
  `norma_max` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `parametry`
--

INSERT INTO `parametry` (`id`, `nazwa`, `jednostka_id`, `user_id`, `norma_min`, `norma_max`) VALUES
(1, 'temperatura ciała', 1, NULL, '36.00', '37.20'),
(2, 'ciśnienie skurczowe', 2, NULL, '90.00', '120.00'),
(3, 'ciśnienie rozkurczowe', 2, NULL, '60.00', '80.00'),
(4, 'masa ciała', 3, NULL, '50.00', '90.00'),
(6, 'poziom glukozy', 5, NULL, '70.00', '99.00'),
(7, 'poziom tlenu we krwi', 6, 1, '90.00', '100.00'),
(8, 'poziom kreatyniny', 5, 2, '0.60', '1.30'),
(9, 'nawodnienie organizmu', 6, 2, '50.00', '65.00'),
(10, 'cholesterol całkowity', 5, 2, '125.00', '200.00'),
(11, 'poziom kwasu moczowego', 5, 2, '3.50', '7.20'),
(12, 'poziom witaminy D', 7, 2, '30.00', '50.00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pomiary`
--

CREATE TABLE `pomiary` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parametr_id` int(11) NOT NULL,
  `wartosc` decimal(10,2) NOT NULL,
  `data_pomiaru` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `pomiary`
--

INSERT INTO `pomiary` (`id`, `user_id`, `parametr_id`, `wartosc`, `data_pomiaru`) VALUES
(1, 1, 1, '37.50', '2026-05-15 16:15:00'),
(2, 1, 4, '67.00', '2026-05-15 16:21:00'),
(3, 1, 1, '38.00', '2026-05-15 16:30:00'),
(5, 1, 6, '92.00', '2026-05-15 20:46:00'),
(6, 2, 1, '36.60', '2026-05-25 18:40:00'),
(7, 2, 4, '45.00', '2026-05-04 18:40:00'),
(8, 2, 4, '47.00', '2026-05-25 18:40:00'),
(9, 2, 9, '30.00', '2026-05-25 18:41:00'),
(10, 1, 4, '68.00', '2026-05-25 19:27:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_fullname` varchar(128) NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `user_passwordhash` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`user_id`, `user_fullname`, `user_email`, `user_passwordhash`) VALUES
(1, 'Jan Kowalski', 'jankow@gmail.com', '$2y$10$ky5LQ.5rYd0xv0rPP/iyEOzv1pYKFT3KwRBVIOEj.e5/MnNqBGSk2'),
(2, 'Anna Nowak', 'nowak@wp.pl', '$2y$10$U8.rBxgwlZQ7ves9LYlGcekImE8G0gvjMo46CXY90Bd5dzuQZQ6LK'),
(3, 'Marta Lupa', 'lupa@gmail.com', '$2y$10$0IaEU98PjwaCPoa2dsI9/u/CbydO7Z/Ik3gcdD6e9Xnqm8dQk23s2');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `jednostki`
--
ALTER TABLE `jednostki`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `logowania`
--
ALTER TABLE `logowania`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `parametry`
--
ALTER TABLE `parametry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jednostka_id` (`jednostka_id`),
  ADD KEY `fk_parametry_user` (`user_id`);

--
-- Indeksy dla tabeli `pomiary`
--
ALTER TABLE `pomiary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parametr_id` (`parametr_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `jednostki`
--
ALTER TABLE `jednostki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `logowania`
--
ALTER TABLE `logowania`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT dla tabeli `parametry`
--
ALTER TABLE `parametry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `pomiary`
--
ALTER TABLE `pomiary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `parametry`
--
ALTER TABLE `parametry`
  ADD CONSTRAINT `fk_parametry_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `parametry_ibfk_1` FOREIGN KEY (`jednostka_id`) REFERENCES `jednostki` (`id`);

--
-- Ograniczenia dla tabeli `pomiary`
--
ALTER TABLE `pomiary`
  ADD CONSTRAINT `pomiary_ibfk_1` FOREIGN KEY (`parametr_id`) REFERENCES `parametry` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
