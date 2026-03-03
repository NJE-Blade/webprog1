-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2026. Már 03. 17:08
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
-- Tábla szerkezet ehhez a táblához `blog`
--

CREATE TABLE `blog` (
  `id` int(10) UNSIGNED NOT NULL,
  `cim` varchar(255) NOT NULL,
  `tartalom` longtext NOT NULL,
  `iras_ideje` datetime DEFAULT current_timestamp(),
  `user_id` int(10) UNSIGNED NOT NULL,
  `picture_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cikkek`
--

CREATE TABLE `cikkek` (
  `id` int(10) UNSIGNED NOT NULL,
  `cim` varchar(255) NOT NULL,
  `tartalom` longtext NOT NULL,
  `iras_ideje` datetime DEFAULT current_timestamp(),
  `user_id` int(10) UNSIGNED NOT NULL,
  `picture_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE `felhasznalok` (
  `id` int(10) UNSIGNED NOT NULL,
  `nev` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `jelszo` varchar(255) NOT NULL,
  `aktiv_statusz` tinyint(1) DEFAULT 0,
  `utolso_bejel_datum` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `kepek`
--

CREATE TABLE `kepek` (
  `id` int(10) UNSIGNED NOT NULL,
  `elnevezes` varchar(255) NOT NULL,
  `fajlnev` varchar(255) NOT NULL,
  `feltoltes_ideje` datetime DEFAULT current_timestamp(),
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `menuk`
--

CREATE TABLE `menuk` (
  `id` int(10) UNSIGNED NOT NULL,
  `megjelenitesi_nev` varchar(255) NOT NULL,
  `ekezettelen_nev` varchar(255) NOT NULL,
  `letrehozas_ideje` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `uzenetek`
--

CREATE TABLE `uzenetek` (
  `id` int(10) UNSIGNED NOT NULL,
  `nev` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `uzenet_szovege` text NOT NULL,
  `bekuldes_ideje` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_blog_user` (`user_id`),
  ADD KEY `fk_blog_picture` (`picture_id`);

--
-- A tábla indexei `cikkek`
--
ALTER TABLE `cikkek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cikkek_user` (`user_id`),
  ADD KEY `fk_cikkek_picture` (`picture_id`);

--
-- A tábla indexei `felhasznalok`
--
ALTER TABLE `felhasznalok`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- A tábla indexei `kepek`
--
ALTER TABLE `kepek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kepek_user` (`user_id`);

--
-- A tábla indexei `menuk`
--
ALTER TABLE `menuk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ekezettelen_nev` (`ekezettelen_nev`);

--
-- A tábla indexei `uzenetek`
--
ALTER TABLE `uzenetek`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `cikkek`
--
ALTER TABLE `cikkek`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `felhasznalok`
--
ALTER TABLE `felhasznalok`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `kepek`
--
ALTER TABLE `kepek`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `menuk`
--
ALTER TABLE `menuk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `uzenetek`
--
ALTER TABLE `uzenetek`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `fk_blog_picture` FOREIGN KEY (`picture_id`) REFERENCES `kepek` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_blog_user` FOREIGN KEY (`user_id`) REFERENCES `felhasznalok` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `cikkek`
--
ALTER TABLE `cikkek`
  ADD CONSTRAINT `fk_cikkek_picture` FOREIGN KEY (`picture_id`) REFERENCES `kepek` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_cikkek_user` FOREIGN KEY (`user_id`) REFERENCES `felhasznalok` (`id`) ON DELETE CASCADE;

--
-- Megkötések a táblához `kepek`
--
ALTER TABLE `kepek`
  ADD CONSTRAINT `fk_kepek_user` FOREIGN KEY (`user_id`) REFERENCES `felhasznalok` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
