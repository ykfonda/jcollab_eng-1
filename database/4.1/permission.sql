-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 12 avr. 2023 à 09:50
-- Version du serveur :  10.1.36-MariaDB
-- Version de PHP :  5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `jcollab_4x`
--

--
-- Déchargement des données de la table `permission`
--

INSERT INTO `permission` (`id`, `role_id`, `module_id`, `site_id`, `c`, `a`, `m1`, `m2`, `m3`, `m4`, `v`, `s`, `h`, `i`, `e`, `sa`, `created`, `deleted`) VALUES
(1417, 2, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:01:35', 0),
(1419, 1, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:07:38', 0),
(1421, 1, 358, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-04-12 07:30:07', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
