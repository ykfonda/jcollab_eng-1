-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  Dim 16 avr. 2023 à 00:45
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

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

CREATE TABLE `permission` (
  `id` int(255) NOT NULL,
  `role_id` int(10) NOT NULL DEFAULT '0',
  `module_id` int(10) NOT NULL DEFAULT '0',
  `site_id` int(10) NOT NULL DEFAULT '0',
  `c` int(1) NOT NULL DEFAULT '0' COMMENT 'Consulter',
  `a` int(1) NOT NULL DEFAULT '0' COMMENT 'Ajouter',
  `m1` int(1) NOT NULL DEFAULT '0' COMMENT 'Modifier 1',
  `m2` int(1) NOT NULL DEFAULT '0' COMMENT 'Modifier 2',
  `m3` int(1) NOT NULL DEFAULT '0' COMMENT 'Modifier 3',
  `m4` int(1) NOT NULL DEFAULT '0' COMMENT 'Modifier 4',
  `v` int(1) NOT NULL DEFAULT '0' COMMENT 'Valider',
  `s` int(1) NOT NULL DEFAULT '0' COMMENT 'Supprimer',
  `h` int(1) NOT NULL DEFAULT '0' COMMENT 'Help',
  `i` int(1) NOT NULL DEFAULT '0' COMMENT 'imprimer',
  `e` int(1) NOT NULL DEFAULT '0' COMMENT 'exporter',
  `sa` int(1) NOT NULL DEFAULT '0' COMMENT 'Super admin',
  `created` datetime NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `permission`
--

INSERT INTO `permission` (`id`, `role_id`, `module_id`, `site_id`, `c`, `a`, `m1`, `m2`, `m3`, `m4`, `v`, `s`, `h`, `i`, `e`, `sa`, `created`, `deleted`) VALUES
(1417, 2, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:01:35', 0),
(1419, 1, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:07:38', 0),
(1440, 4, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:07:38', 0),
(1441, 6, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:07:38', 0),
(1442, 8, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:07:38', 0),
(1443, 9, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:07:38', 0),
(1444, 10, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:07:38', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1445;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
