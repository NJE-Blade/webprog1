-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2026. Már 06. 14:14
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `biglanne_vaszilij`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `menuk`
--

CREATE TABLE `menuk` (
  `id` int(10) UNSIGNED NOT NULL,
  `megjelenitesi_nev` varchar(255) NOT NULL,
  `ekezettelen_nev` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `letrehozas_ideje` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `menuk`
--

INSERT INTO `menuk` (`id`, `megjelenitesi_nev`, `ekezettelen_nev`, `admin`, `letrehozas_ideje`) VALUES
(1, 'Blog', 'blog', 0, '2026-03-05 21:12:59'),
(2, 'Írások', 'irasok', 0, '2026-03-05 21:13:10'),
(3, 'Galéria', 'galeria', 0, '2026-03-05 21:13:22'),
(4, 'Támogatás', 'tamogatas', 0, '2026-03-05 21:13:41'),
(5, 'Üzenetküldés', 'uzenetkuldes', 0, '2026-03-05 21:14:15');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `menuk`
--
ALTER TABLE `menuk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ekezettelen_nev` (`ekezettelen_nev`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `menuk`
--
ALTER TABLE `menuk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
