-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 22 août 2023 à 04:49
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `j4x`
--

-- --------------------------------------------------------

--
-- Structure de la table `inventairedetails`
--

CREATE TABLE `inventairedetails` (
  `id` int(11) NOT NULL,
  `inventaire_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `code_barre` varchar(255) NOT NULL COMMENT 'code article',
  `quantite_reel` decimal(10,3) NOT NULL DEFAULT '0.000',
  `quantite_theorique` decimal(10,3) NOT NULL DEFAULT '0.000',
  `ecart` decimal(10,3) NOT NULL DEFAULT '0.000',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `valstkini` decimal(10,3) NOT NULL COMMENT 'valeur precedente de valeur quantite_reel',
  `valentree` decimal(10,3) NOT NULL,
  `valsortie` decimal(10,3) NOT NULL,
  `qtentree` float(10,3) NOT NULL,
  `qtsortie` decimal(10,3) NOT NULL,
  `qtvente` decimal(10,3) NOT NULL,
  `valvente` decimal(10,3) NOT NULL,
  `qteecart` decimal(10,3) NOT NULL,
  `type_data` int(11) NOT NULL COMMENT '0 import or 1 calc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `inventairedetails`
--
ALTER TABLE `inventairedetails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `inventairedetails`
--
ALTER TABLE `inventairedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
