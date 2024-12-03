-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 17 avr. 2023 à 11:57
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
-- Structure de la table `configs`
--

CREATE TABLE `configs` (
  `id` int(10) NOT NULL,
  `name_app` varchar(200) NOT NULL,
  `version_app` varchar(50) NOT NULL,
  `app_last_commit` varchar(100) NOT NULL,
  `admin_link` varchar(200) NOT NULL,
  `pos_link` varchar(200) NOT NULL,
  `server_link` varchar(200) NOT NULL,
  `type_app` int(11) NOT NULL COMMENT '1=client_administration / 2=Client_POS / 3=Serveur',
  `email` varchar(200) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `adresse_ip` varchar(100) NOT NULL,
  `caisse_id` int(10) NOT NULL,
  `store_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `configs`
--

INSERT INTO `configs` (`id`, `name_app`, `version_app`, `app_last_commit`, `admin_link`, `pos_link`, `server_link`, `type_app`, `email`, `created`, `updated`, `deleted`, `adresse_ip`, `caisse_id`, `store_id`) VALUES
(1, 'JCOLLAB', '4.1', '9ac171a1fca1977179c2ee02de768e954e72299e', 'http://localhost:8081/projets/JCOLLAB/dev/JCOLLAB-4.X/application/JCOLLAB4X/', 'http://localhost:8081/projets/JCOLLAB/dev/JCOLLAB-4.X/application/JCOLLAB4X/pos/index/', 'https://iafsys.app/jcollab.ae', 1, 'h.sadek@jaweb.ma', '2023-04-10 00:00:00', '2023-04-10 00:00:00', 0, '192.168.11.100', 1, 12);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
