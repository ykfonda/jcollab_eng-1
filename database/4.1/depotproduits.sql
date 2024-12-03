-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 01 juin 2023 à 14:43
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
-- Structure de la table `depotproduits`
--

CREATE TABLE `depotproduits` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `quantite` decimal(10,3) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `depotproduits`
--
ALTER TABLE `depotproduits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `depotproduits`
--
ALTER TABLE `depotproduits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
