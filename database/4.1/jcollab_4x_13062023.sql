-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 13 juin 2023 à 15:29
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
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `role_id`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 1, 0, 1, '2020-07-02 16:51:45', NULL, NULL),
(2, 2, 0, 1, '2020-07-02 16:51:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `agences`
--

CREATE TABLE `agences` (
  `id` int(11) NOT NULL,
  `libelle` varchar(250) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `agences`
--

INSERT INTO `agences` (`id`, `libelle`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'BMCE', 0, 1, '2020-02-02 13:44:48', NULL, NULL),
(2, 'BMCI', 0, 1, '2020-02-02 13:44:54', NULL, NULL),
(3, 'SociÃ©tÃ© gÃ©nÃ©rale', 0, 1, '2020-02-02 13:45:02', NULL, NULL),
(4, 'CFG banque', 0, 1, '2020-02-02 13:45:11', NULL, NULL),
(5, 'CIH', 0, 1, '2020-02-02 13:45:16', NULL, NULL),
(6, 'Banque chaabi', 0, 1, '2020-02-02 13:45:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `libelle` varchar(250) NOT NULL,
  `link` varchar(250) NOT NULL,
  `icon` varchar(250) DEFAULT NULL,
  `content` text NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `alerts_users`
--

CREATE TABLE `alerts_users` (
  `id` int(11) NOT NULL,
  `alert_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `read` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `attentedetails`
--

CREATE TABLE `attentedetails` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `attente_id` int(11) DEFAULT NULL,
  `categorieproduit_id` int(11) DEFAULT NULL,
  `qte_cmd` decimal(10,3) DEFAULT NULL,
  `qte` decimal(10,3) DEFAULT NULL,
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `marge` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT NULL,
  `stat` int(11) NOT NULL DEFAULT '-1',
  `onhold` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `attentes`
--

CREATE TABLE `attentes` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `commande_id` int(11) DEFAULT NULL,
  `etat` int(11) DEFAULT '-1',
  `paye` int(11) NOT NULL DEFAULT '-1',
  `onhold` int(11) NOT NULL DEFAULT '-1',
  `total_a_payer_ht` decimal(10,2) DEFAULT '0.00',
  `total_a_payer_ttc` decimal(10,2) DEFAULT '0.00',
  `total_paye` decimal(10,2) DEFAULT '0.00',
  `reste_a_payer` decimal(10,2) DEFAULT '0.00',
  `total_apres_reduction` decimal(10,2) DEFAULT '0.00',
  `total_cmd` decimal(10,3) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT '0.00',
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_tva` decimal(10,2) DEFAULT NULL,
  `rendu` decimal(10,2) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `avances`
--

CREATE TABLE `avances` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `numero_piece` varchar(255) DEFAULT NULL,
  `emeteur` varchar(255) DEFAULT NULL,
  `vente_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `versement_id` int(11) DEFAULT NULL,
  `bonlivraison_id` int(11) DEFAULT NULL,
  `bonreception_id` int(11) DEFAULT NULL,
  `boncommande_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `salepoint_id` int(11) DEFAULT NULL,
  `mode` varchar(20) DEFAULT NULL,
  `etat` int(11) NOT NULL DEFAULT '-1',
  `verse` int(11) NOT NULL DEFAULT '-1',
  `montant` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `date_echeance` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `avoirdetails`
--

CREATE TABLE `avoirdetails` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `avoir_id` int(11) DEFAULT NULL,
  `categorieproduit_id` int(11) DEFAULT NULL,
  `declaration` int(11) DEFAULT '1',
  `description` varchar(255) DEFAULT NULL,
  `qte` decimal(10,3) DEFAULT NULL,
  `prixachat` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `avoirs`
--

CREATE TABLE `avoirs` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `retour_id` int(11) DEFAULT NULL,
  `etat` int(11) DEFAULT '-1',
  `total_qte` int(11) DEFAULT NULL,
  `total_a_payer` decimal(10,2) DEFAULT '0.00',
  `total_paye` decimal(10,2) DEFAULT '0.00',
  `reste_a_payer` decimal(10,2) DEFAULT '0.00',
  `total_apres_reduction` decimal(10,2) DEFAULT '0.00',
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `date_validation` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `backups`
--

CREATE TABLE `backups` (
  `id` int(11) NOT NULL,
  `libelle` varchar(250) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `backups`
--

INSERT INTO `backups` (`id`, `libelle`, `date`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'jcollab-backup-2022-02-03_22-28-04.sql', '2022-02-03', 0, 1, '2022-02-03 22:28:04', NULL, NULL),
(2, 'jcollab-backup-2022-02-03_22-30-33.sql', '2022-02-03', 0, 1, '2022-02-03 22:30:33', NULL, NULL),
(3, 'jcollab-backup-2022-02-05_12-28-47.sql', '2022-02-05', 0, 1, '2022-02-05 12:28:47', NULL, NULL),
(4, 'jcollab-backup-2022-02-27_20-33-41.sql', '2022-02-27', 0, 1, '2022-02-27 20:33:41', NULL, NULL),
(5, 'jcollab-backup-2022-06-08_12-05-16.sql', '2022-06-08', 0, 1, '2022-06-08 12:05:16', NULL, NULL),
(6, 'jcollab-backup-2022-06-28_17-17-43.sql', '2022-06-28', 0, 1, '2022-06-28 17:17:43', NULL, NULL),
(7, 'jcollab-backup-2022-08-10_21-16-50.sql', '2022-08-10', 0, 1, '2022-08-10 21:16:50', NULL, NULL),
(8, 'jcollab-backup-2022-09-23_15-52-52.sql', '2022-09-23', 0, 1, '2022-09-23 15:52:52', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `bonachats`
--

CREATE TABLE `bonachats` (
  `id` int(11) NOT NULL,
  `reference` text,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `validite` int(11) DEFAULT NULL,
  `montant` float DEFAULT NULL,
  `date_encaissement` datetime DEFAULT NULL,
  `active` int(11) DEFAULT '0',
  `numero` int(11) DEFAULT NULL,
  `ref_ticket` text,
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `deleted` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `bonavoirdetails`
--

CREATE TABLE `bonavoirdetails` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `bonavoir_id` int(11) DEFAULT NULL,
  `categorieproduit_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `qte` decimal(10,3) DEFAULT NULL,
  `paquet` decimal(10,2) DEFAULT NULL,
  `total_unitaire` decimal(10,2) DEFAULT NULL,
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bonavoirs`
--

CREATE TABLE `bonavoirs` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `bonlivraison_id` int(11) DEFAULT NULL,
  `bonretour_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT '1',
  `etat` int(11) DEFAULT '-1',
  `total_qte` decimal(10,2) DEFAULT NULL,
  `total_paquet` decimal(10,2) DEFAULT NULL,
  `total_a_payer_ht` decimal(10,2) DEFAULT '0.00',
  `total_a_payer_ttc` decimal(10,2) DEFAULT '0.00',
  `total_paye` decimal(10,2) DEFAULT '0.00',
  `reste_a_payer` decimal(10,2) DEFAULT '0.00',
  `total_apres_reduction` decimal(10,2) DEFAULT '0.00',
  `reduction` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_tva` decimal(10,2) DEFAULT NULL,
  `active_remise` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `boncommandedetails`
--

CREATE TABLE `boncommandedetails` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `boncommande_id` int(11) DEFAULT NULL,
  `categorieproduit_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `qte` decimal(10,3) DEFAULT NULL,
  `paquet` decimal(10,2) DEFAULT NULL,
  `total_unitaire` decimal(10,2) DEFAULT NULL,
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT NULL,
  `recu` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `boncommandes`
--

CREATE TABLE `boncommandes` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `fournisseur_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT '1',
  `bonreception_id` int(11) DEFAULT NULL,
  `etat` int(11) DEFAULT '-1',
  `paye` int(11) NOT NULL DEFAULT '-1',
  `recu` int(11) NOT NULL DEFAULT '-1',
  `total_qte` decimal(10,2) DEFAULT NULL,
  `total_paquet` decimal(10,2) DEFAULT NULL,
  `total_a_payer_ht` decimal(10,2) DEFAULT '0.00',
  `total_a_payer_ttc` decimal(10,2) DEFAULT '0.00',
  `total_paye` decimal(10,2) DEFAULT '0.00',
  `reste_a_payer` decimal(10,2) DEFAULT '0.00',
  `total_apres_reduction` decimal(10,2) DEFAULT '0.00',
  `reduction` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_tva` decimal(10,2) DEFAULT NULL,
  `active_remise` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bonentreedetails`
--

CREATE TABLE `bonentreedetails` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `num_lot` varchar(50) DEFAULT NULL,
  `prix_achat` decimal(10,2) DEFAULT NULL COMMENT 'V4.X prix de VENTE',
  `date` date DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  `date_peremption` date DEFAULT NULL,
  `date_fabrication` date DEFAULT NULL,
  `bonentree_id` int(11) DEFAULT NULL,
  `stock_source` decimal(10,3) DEFAULT NULL,
  `stock_destination` decimal(10,3) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quantite` decimal(10,3) DEFAULT NULL,
  `depot_source_id` int(11) DEFAULT NULL,
  `depot_destination_id` int(11) DEFAULT NULL,
  `operation` int(11) NOT NULL DEFAULT '-1',
  `valide` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bonentrees`
--

CREATE TABLE `bonentrees` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `num_lot` varchar(50) DEFAULT NULL,
  `description` text,
  `date` date DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  `date_peremption` date DEFAULT NULL,
  `date_fabrication` date DEFAULT NULL,
  `stock_source` int(11) DEFAULT NULL,
  `stock_destination` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `quantite_avant` int(11) DEFAULT NULL,
  `quantite_apres` int(11) DEFAULT NULL,
  `depot_source_id` int(11) DEFAULT NULL,
  `depot_destination_id` int(11) DEFAULT NULL,
  `vente_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `retour_id` int(11) DEFAULT NULL,
  `operation` int(11) NOT NULL DEFAULT '-1',
  `valide` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bonlivraisondetails`
--

CREATE TABLE `bonlivraisondetails` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `bonlivraison_id` int(11) DEFAULT NULL,
  `categorieproduit_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `date_echeance` date DEFAULT NULL,
  `qte` decimal(10,3) DEFAULT NULL,
  `paquet` int(11) DEFAULT NULL,
  `total_unitaire` int(11) DEFAULT NULL,
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `marge` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bonlivraisondetails`
--

INSERT INTO `bonlivraisondetails` (`id`, `produit_id`, `depot_id`, `bonlivraison_id`, `categorieproduit_id`, `description`, `date`, `date_echeance`, `qte`, `paquet`, `total_unitaire`, `prix_vente`, `total`, `ttc`, `marge`, `remise`, `montant_remise`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 7, 10, 1, NULL, NULL, NULL, NULL, '0.501', NULL, NULL, '249.00', NULL, '124.75', NULL, NULL, NULL, 0, 1, '2023-06-10 17:21:00', NULL, NULL),
(2, 6, 10, 1, NULL, NULL, NULL, NULL, '0.501', NULL, NULL, '172.00', NULL, '86.17', NULL, NULL, NULL, 0, 1, '2023-06-10 17:21:00', NULL, NULL),
(3, 6, 10, 2, NULL, NULL, NULL, NULL, '1.801', NULL, NULL, '172.00', NULL, '309.77', NULL, NULL, NULL, 0, 1, '2023-06-10 18:00:00', NULL, NULL),
(4, 115, 10, 3, NULL, NULL, NULL, NULL, '1.000', NULL, NULL, '144.00', NULL, '144.00', NULL, NULL, NULL, 0, 1, '2023-06-10 18:06:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `bonlivraisons`
--

CREATE TABLE `bonlivraisons` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT '1',
  `commande_id` int(11) DEFAULT '1',
  `etat` int(11) DEFAULT '-1',
  `paye` int(11) NOT NULL DEFAULT '-1',
  `total_qte` decimal(10,2) DEFAULT NULL,
  `total_paquet` decimal(10,2) DEFAULT NULL,
  `total_a_payer_ht` decimal(10,2) DEFAULT '0.00',
  `total_a_payer_ttc` decimal(10,2) DEFAULT '0.00',
  `total_paye` decimal(10,2) DEFAULT '0.00',
  `reste_a_payer` decimal(10,2) DEFAULT '0.00',
  `total_apres_reduction` decimal(10,2) DEFAULT '0.00',
  `montant_remise` decimal(10,2) DEFAULT '0.00',
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_tva` decimal(10,2) DEFAULT NULL,
  `marge` decimal(10,2) DEFAULT NULL,
  `active_remise` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `depot_source_id` int(11) DEFAULT NULL,
  `fournisseur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bonlivraisons`
--

INSERT INTO `bonlivraisons` (`id`, `reference`, `client_id`, `facture_id`, `depot_id`, `commande_id`, `etat`, `paye`, `total_qte`, `total_paquet`, `total_a_payer_ht`, `total_a_payer_ttc`, `total_paye`, `reste_a_payer`, `total_apres_reduction`, `montant_remise`, `remise`, `montant_tva`, `marge`, `active_remise`, `user_id`, `date`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`, `type`, `depot_source_id`, `fournisseur_id`) VALUES
(1, 'BLL-00003', 84, NULL, 11, 1, 2, -1, '1.00', '0.00', '210.92', '210.92', '0.00', '210.92', '210.92', '0.00', NULL, '0.00', NULL, NULL, NULL, '2023-06-10', 0, 1, '2023-06-10 17:21:00', 1, '2023-06-10 17:21:02', 'Expedition', NULL, 5),
(2, 'BLL-00004', 84, NULL, 3, 1, 2, -1, '1.80', '0.00', '309.77', '309.77', '0.00', '309.77', '309.77', '0.00', NULL, '0.00', NULL, NULL, NULL, '2023-06-10', 0, 1, '2023-06-10 18:00:00', 1, '2023-06-10 18:00:44', 'Expedition', NULL, 5),
(3, 'BLL-00005', 84, NULL, 3, 1, 2, -1, '1.00', '0.00', '120.00', '144.00', '0.00', '144.00', '144.00', '0.00', NULL, '24.00', NULL, NULL, NULL, '2023-06-10', 0, 1, '2023-06-10 18:06:00', 1, '2023-06-10 18:06:21', 'Expedition', NULL, 5);

-- --------------------------------------------------------

--
-- Structure de la table `bonreceptiondetails`
--

CREATE TABLE `bonreceptiondetails` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `bonreception_id` int(11) DEFAULT NULL,
  `categorieproduit_id` int(11) DEFAULT NULL,
  `boncommandedetail_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `num_lot` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `qte_cmd` decimal(10,3) DEFAULT NULL,
  `qte` decimal(10,3) DEFAULT NULL,
  `paquet` decimal(10,2) DEFAULT NULL,
  `total_unitaire` decimal(10,2) DEFAULT NULL,
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bonreceptiondetails`
--

INSERT INTO `bonreceptiondetails` (`id`, `produit_id`, `depot_id`, `bonreception_id`, `categorieproduit_id`, `boncommandedetail_id`, `description`, `num_lot`, `date`, `qte_cmd`, `qte`, `paquet`, `total_unitaire`, `prix_vente`, `total`, `ttc`, `remise`, `montant_remise`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 7, 10, 1, NULL, NULL, NULL, '', NULL, '0.501', '0.201', NULL, NULL, '249.00', '41.71', '50.05', NULL, NULL, 0, 1, '2023-06-10 17:21:00', 1, '2023-06-10 17:43:50'),
(2, 6, 10, 1, NULL, NULL, NULL, '', NULL, '0.501', '0.501', NULL, NULL, '172.00', '86.17', '86.17', NULL, NULL, 0, 1, '2023-06-10 17:21:00', NULL, NULL),
(3, 6, 10, 2, NULL, NULL, NULL, '', NULL, '1.801', '3.801', NULL, NULL, '172.00', '544.81', '653.77', NULL, NULL, 0, 1, '2023-06-10 18:00:00', 1, '2023-06-10 18:01:52'),
(4, 115, NULL, 3, NULL, NULL, NULL, '', NULL, '1.000', '1.000', NULL, NULL, '144.00', '144.00', '144.00', NULL, NULL, 0, 1, '2023-06-10 18:06:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `bonreceptions`
--

CREATE TABLE `bonreceptions` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `fournisseur_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT '1',
  `depot_source_id` int(11) DEFAULT NULL,
  `boncommande_id` int(11) DEFAULT NULL,
  `etat` int(11) NOT NULL DEFAULT '-1',
  `paye` int(11) NOT NULL DEFAULT '-1',
  `total_qte` decimal(10,2) DEFAULT NULL,
  `total_paquet` decimal(10,2) DEFAULT NULL,
  `total_a_payer_ht` decimal(10,2) DEFAULT '0.00',
  `total_a_payer_ttc` decimal(10,2) DEFAULT '0.00',
  `total_paye` decimal(10,2) DEFAULT '0.00',
  `reste_a_payer` decimal(10,2) DEFAULT '0.00',
  `total_apres_reduction` decimal(10,2) DEFAULT '0.00',
  `reduction` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_tva` decimal(10,2) DEFAULT NULL,
  `active_remise` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `no_Bl_fournisseur` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `mouvementprincipal_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `bonreceptions`
--

INSERT INTO `bonreceptions` (`id`, `reference`, `fournisseur_id`, `facture_id`, `depot_id`, `depot_source_id`, `boncommande_id`, `etat`, `paye`, `total_qte`, `total_paquet`, `total_a_payer_ht`, `total_a_payer_ttc`, `total_paye`, `reste_a_payer`, `total_apres_reduction`, `reduction`, `remise`, `montant_tva`, `active_remise`, `user_id`, `no_Bl_fournisseur`, `date`, `type`, `mouvementprincipal_id`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'BR-000001', 5, NULL, 10, NULL, NULL, 2, -1, '0.70', '0.00', '136.22', '136.22', '0.00', '136.22', '136.22', '0.00', NULL, '0.00', NULL, NULL, NULL, '2023-06-10', 'Expedition', 1, 0, 1, '2023-06-10 17:21:00', 1, '2023-06-10 17:43:51'),
(2, 'BR-000002', 5, NULL, 10, NULL, NULL, 2, -1, '3.80', '0.00', '653.77', '653.77', '0.00', '653.77', '653.77', '0.00', NULL, '0.00', NULL, NULL, NULL, '2023-06-10', 'Expedition', 2, 0, 1, '2023-06-10 18:00:00', 1, '2023-06-10 18:01:52'),
(3, 'BR-000003', 5, NULL, 10, NULL, NULL, -1, -1, '1.00', '0.00', '120.00', '144.00', '0.00', '144.00', '144.00', '0.00', NULL, '24.00', NULL, NULL, NULL, '2023-06-10', 'Expedition', 3, 0, 1, '2023-06-10 18:06:00', 1, '2023-06-10 18:06:21');

-- --------------------------------------------------------

--
-- Structure de la table `bonretourachatdetails`
--

CREATE TABLE `bonretourachatdetails` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `bonretourachat_id` int(11) DEFAULT NULL,
  `categorieproduit_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `qte` decimal(10,3) DEFAULT NULL,
  `paquet` decimal(10,2) DEFAULT NULL,
  `total_unitaire` decimal(10,2) DEFAULT NULL,
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bonretourachats`
--

CREATE TABLE `bonretourachats` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `fournisseur_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT '1',
  `boncommande_id` int(11) DEFAULT NULL,
  `etat` int(11) DEFAULT '-1',
  `total_qte` decimal(10,2) DEFAULT NULL,
  `total_paquet` decimal(10,2) DEFAULT NULL,
  `total_a_payer_ht` decimal(10,2) DEFAULT '0.00',
  `total_a_payer_ttc` decimal(10,2) DEFAULT '0.00',
  `total_paye` decimal(10,2) DEFAULT '0.00',
  `reste_a_payer` decimal(10,2) DEFAULT '0.00',
  `total_apres_reduction` decimal(10,2) DEFAULT '0.00',
  `reduction` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_tva` decimal(10,2) DEFAULT NULL,
  `active_remise` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `no_Bl_fournisseur` int(11) DEFAULT NULL,
  `Bonreception_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `societe_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bonretourdetails`
--

CREATE TABLE `bonretourdetails` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `bonretour_id` int(11) DEFAULT NULL,
  `categorieproduit_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `qte` decimal(10,3) DEFAULT NULL,
  `paquet` decimal(10,2) DEFAULT NULL,
  `total_unitaire` decimal(10,2) DEFAULT NULL,
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bonretours`
--

CREATE TABLE `bonretours` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `bonavoir_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT '1',
  `etat` int(11) DEFAULT '-1',
  `total_qte` decimal(10,2) DEFAULT NULL,
  `total_paquet` decimal(10,2) DEFAULT NULL,
  `total_a_payer_ht` decimal(10,2) DEFAULT '0.00',
  `total_a_payer_ttc` decimal(10,2) DEFAULT '0.00',
  `total_paye` decimal(10,2) DEFAULT '0.00',
  `reste_a_payer` decimal(10,2) DEFAULT '0.00',
  `total_apres_reduction` decimal(10,2) DEFAULT '0.00',
  `reduction` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_tva` decimal(10,2) DEFAULT NULL,
  `active_remise` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bontransfertdetails`
--

CREATE TABLE `bontransfertdetails` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `num_lot` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  `date_peremption` date DEFAULT NULL,
  `date_fabrication` date DEFAULT NULL,
  `bontransfert_id` int(11) DEFAULT NULL,
  `stock_source` decimal(10,3) DEFAULT NULL,
  `stock_destination` decimal(10,3) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `quantite` decimal(10,3) DEFAULT NULL,
  `depot_source_id` int(11) DEFAULT NULL,
  `depot_destination_id` int(11) DEFAULT NULL,
  `operation` int(11) NOT NULL DEFAULT '-1',
  `valide` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `bontransferts`
--

CREATE TABLE `bontransferts` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `num_lot` varchar(50) DEFAULT NULL,
  `description` text,
  `date` date DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  `date_peremption` date DEFAULT NULL,
  `date_fabrication` date DEFAULT NULL,
  `stock_source` int(11) DEFAULT NULL,
  `stock_destination` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `total` float NOT NULL,
  `quantite_avant` int(11) DEFAULT NULL,
  `quantite_apres` int(11) DEFAULT NULL,
  `depot_source_id` int(11) DEFAULT NULL,
  `depot_destination_id` int(11) DEFAULT NULL,
  `vente_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `retour_id` int(11) DEFAULT NULL,
  `operation` int(11) NOT NULL DEFAULT '-1',
  `valide` int(11) NOT NULL DEFAULT '-1',
  `type` varchar(30) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `caisses`
--

CREATE TABLE `caisses` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `ip_adresse` varchar(255) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `societe_id` int(11) DEFAULT NULL,
  `prefix` varchar(50) NOT NULL,
  `compteur_actif` int(11) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `montant` decimal(65,2) NOT NULL,
  `pourcentage` decimal(4,2) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `caisses`
--

INSERT INTO `caisses` (`id`, `reference`, `libelle`, `ip_adresse`, `store_id`, `societe_id`, `prefix`, `compteur_actif`, `numero`, `montant`, `pourcentage`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'CS-000002', 'CA1', '192.168.11.100', 10, 1, 'A1', 0, '000218', '0.00', '0.00', 0, 2, '2021-11-23 14:45:35', 2, '2022-09-28 16:34:30'),
(3, 'CS-000003', 'CA2', '192.168.3.102', 10, 1, 'A2', 0, '000001', '0.00', '0.00', 0, 2, '2021-11-23 14:46:46', NULL, NULL),
(4, 'CS-000004', 'CI1', '192.168.1.103', 1, 5, 'I1', 0, '000131', '0.00', '0.00', 0, 2, '2021-11-23 14:49:12', 1, '2023-03-30 22:59:59'),
(5, 'CS-000005', 'CI1', '192.168.1.102', 1, 5, 'I2', 0, '000001', '0.00', '0.00', 0, 2, '2021-11-23 14:50:26', NULL, NULL),
(6, 'CS-000005', 'CG1', '192.168.11.100', 11, 1, 'G1', 0, '000222', '0.00', '0.00', 0, 2, '2021-11-23 14:51:24', 2, '2023-01-11 11:48:52'),
(7, 'CS-000006', 'CG2', '192.168.2.102', 11, 1, 'G2', 0, '000001', '0.00', '0.00', 0, 2, '2021-11-23 14:51:56', 2, '2021-11-23 14:52:22'),
(8, 'CS-000007', 'CM1', '192.168.11.100', 18, 2, 'M1', 0, '000049', '0.00', '0.00', 0, 2, '2021-11-23 14:53:22', NULL, NULL),
(9, 'CS-000008', 'CR1', '192.168.11.100', 15, 2, 'R1', 0, '000122', '0.00', '0.00', 0, 2, '2021-11-23 14:54:15', NULL, NULL),
(10, 'CS-000009', 'CB1', '192.168.11.100', 17, 4, 'B1', 0, '000047', '0.00', '0.00', 0, 2, '2021-11-23 14:55:09', 2, '2023-01-13 08:34:48'),
(11, 'CS-000010', 'CC1', '192.168.1.103', 16, 4, 'C1', 0, '001585', '0.00', '0.00', 0, 2, '2021-11-23 14:55:55', 1, '2023-04-13 02:03:48'),
(12, 'CS-000011', 'CC2', '10.111.10.5', 16, 4, 'C2', 0, '000014', '0.00', '0.00', 0, 2, '2021-11-23 14:56:42', 2, '2023-01-01 19:40:20'),
(13, 'CS-000012', 'CF1', '192.168.11.100', 14, 3, 'F1', 0, '000008', '0.00', '0.00', 0, 2, '2021-11-23 14:57:24', NULL, NULL),
(14, 'CS-000013', 'CT1', '192.168.11.100', 12, 3, 'T1', 0, '000059', '0.00', '0.00', 0, 2, '2021-11-23 14:58:25', NULL, NULL),
(15, 'CS-000014', 'CT2', '192.168.12.101', 12, 3, 'T2', 0, '000001', '0.00', '0.00', 0, 2, '2021-11-23 14:58:51', NULL, NULL),
(16, 'CS-000015', 'CS1', '192.11.11.102', 20, 3, 'S1', 0, '000001', '0.00', '0.00', 0, 2, '2022-05-30 17:35:40', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categorieclients`
--

CREATE TABLE `categorieclients` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorieclients`
--

INSERT INTO `categorieclients` (`id`, `libelle`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'Grossiste', 0, 1, '2019-04-12 01:08:20', 1, '2019-04-12 01:09:53'),
(2, 'Affilie', 0, 1, '2019-04-12 01:08:32', NULL, NULL),
(3, 'Client final', 0, 1, '2019-04-12 01:08:48', NULL, NULL),
(4, 'Revendeur', 0, 1, '2019-04-12 01:08:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categoriedepences`
--

CREATE TABLE `categoriedepences` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categoriedepences`
--

INSERT INTO `categoriedepences` (`id`, `libelle`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'Paiment fournisseur', 0, 7, '2020-10-11 01:50:44', NULL, NULL),
(2, 'Autre dÃ©pence', 0, 7, '2020-10-11 01:51:00', NULL, NULL),
(3, 'PrÃ©station', 0, 7, '2020-10-24 16:59:11', NULL, NULL),
(4, 'ThÃ©', 0, 7, '2020-10-24 16:59:44', NULL, NULL),
(5, 'CafÃ©', 0, 7, '2020-10-24 16:59:50', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categorieproduits`
--

CREATE TABLE `categorieproduits` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default.jpg',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorieproduits`
--

INSERT INTO `categorieproduits` (`id`, `libelle`, `image`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'Charcuterie', 'default.jpg', 0, 2, '2021-11-23 13:18:58', NULL, NULL),
(2, 'PÃ¢tisserie CharcutiÃ¨re', 'default.jpg', 0, 2, '2021-11-23 13:19:32', NULL, NULL),
(3, 'Plats CuisinÃ©s', 'default.jpg', 0, 2, '2021-11-23 13:19:45', NULL, NULL),
(4, 'Plats Festifs & RÃ©ception', 'default.jpg', 0, 2, '2021-11-23 13:20:01', NULL, NULL),
(5, 'Produits ElaborÃ©s', 'default.jpg', 0, 2, '2021-11-23 13:20:31', NULL, NULL),
(6, 'Saucisserie', 'default.jpg', 0, 2, '2021-11-23 13:20:47', NULL, NULL),
(7, 'Viandes Blanches', 'default.jpg', 0, 2, '2021-11-23 13:21:01', NULL, NULL),
(8, 'Viandes Rouges', 'default.jpg', 0, 2, '2021-11-23 13:21:30', NULL, NULL),
(9, 'Autres', 'default.jpg', 0, 2, '2022-02-04 21:53:48', 2, '2022-02-04 21:53:58');

-- --------------------------------------------------------

--
-- Structure de la table `chatmessages`
--

CREATE TABLE `chatmessages` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `isread` tinyint(4) NOT NULL DEFAULT '0',
  `message` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `chequecadeaus`
--

CREATE TABLE `chequecadeaus` (
  `id` int(11) NOT NULL,
  `reference` text,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `validite` int(11) DEFAULT NULL,
  `montant` float DEFAULT NULL,
  `date_encaissement` datetime DEFAULT NULL,
  `active` int(11) DEFAULT '0',
  `numero` int(11) DEFAULT NULL,
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `deleted` int(11) DEFAULT '0',
  `client_id` int(11) DEFAULT NULL,
  `ref_ticket` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `categorieclient_id` int(11) DEFAULT NULL,
  `clienttype_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ville_id` int(11) DEFAULT NULL,
  `classification` int(11) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT '0.00',
  `organisme` int(11) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `capital` decimal(10,2) DEFAULT NULL,
  `total_vente` decimal(10,2) DEFAULT NULL,
  `total_avoir` decimal(10,2) DEFAULT NULL,
  `ice` varchar(50) DEFAULT NULL,
  `registrecommerce` varchar(50) DEFAULT NULL,
  `adresse` text,
  `telmobile` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `activite` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT '1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1',
  `type` int(11) NOT NULL DEFAULT '1',
  `id_ecommerce` int(11) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `sexe` int(11) DEFAULT NULL,
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `compte_comptable` varchar(200) DEFAULT NULL,
  `points_fidelite` float DEFAULT '0',
  `code_client` varchar(30) DEFAULT NULL,
  `hash` text,
  `tax_id` text,
  `is_glovo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `categorieclient_id`, `clienttype_id`, `user_id`, `ville_id`, `classification`, `remise`, `organisme`, `designation`, `reference`, `latitude`, `longitude`, `date`, `capital`, `total_vente`, `total_avoir`, `ice`, `registrecommerce`, `adresse`, `telmobile`, `fax`, `email`, `website`, `avatar`, `activite`, `note`, `rating`, `deleted`, `active`, `type`, `id_ecommerce`, `date_naissance`, `sexe`, `user_c`, `date_c`, `user_u`, `date_u`, `compte_comptable`, `points_fidelite`, `code_client`, `hash`, `tax_id`, `is_glovo`) VALUES
(0, 1, NULL, 1, NULL, NULL, '0.00', 1, 'Client X', 'CLT-000001', NULL, NULL, NULL, NULL, NULL, NULL, '123', NULL, '', '000000000', '', '', NULL, NULL, NULL, '', 1, 0, 1, 1, 0, NULL, 0, 1, '2023-06-04 18:00:12', NULL, NULL, '', NULL, '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `clienttypes`
--

CREATE TABLE `clienttypes` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `clienttypes`
--

INSERT INTO `clienttypes` (`id`, `libelle`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'Type 1', 0, 1, '2019-04-12 01:08:20', 1, '2019-04-12 01:09:53'),
(2, 'Type 2', 0, 1, '2019-04-12 01:08:32', NULL, NULL),
(3, 'Type 3', 0, 1, '2019-04-12 01:08:48', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `commandedetails`
--

CREATE TABLE `commandedetails` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `commande_id` int(11) DEFAULT NULL,
  `categorieproduit_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `qte_cmd` decimal(10,3) DEFAULT '0.000',
  `qte` decimal(10,3) DEFAULT '0.000',
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT NULL,
  `tva` decimal(10,2) DEFAULT NULL,
  `montant_tva` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT '1',
  `bonlivraison_id` int(11) DEFAULT NULL,
  `etat` int(11) DEFAULT '-1',
  `total_qte` decimal(10,2) DEFAULT NULL,
  `total_paquet` decimal(10,2) DEFAULT NULL,
  `total_a_payer_ht` decimal(10,2) DEFAULT '0.00',
  `total_a_payer_ttc` decimal(10,2) DEFAULT '0.00',
  `total_paye` decimal(10,2) DEFAULT '0.00',
  `reste_a_payer` decimal(10,2) DEFAULT '0.00',
  `montant_remise` decimal(10,2) DEFAULT '0.00',
  `total_apres_reduction` decimal(10,2) DEFAULT '0.00',
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_tva` decimal(10,2) DEFAULT NULL,
  `active_remise` int(11) DEFAULT '-1',
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `statut` varchar(30) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commandes_glovo`
--

CREATE TABLE `commandes_glovo` (
  `id` int(11) NOT NULL,
  `order_id` text,
  `store_id` text,
  `order_time` datetime DEFAULT NULL,
  `estimated_pickup_time` datetime DEFAULT NULL,
  `utc_offset_minutes` text,
  `payment_method` text,
  `currency` text,
  `order_code` text NOT NULL,
  `allergy_info` text,
  `special_requirements` text,
  `estimated_total_price` float DEFAULT NULL,
  `delivery_fee` float DEFAULT NULL,
  `minimum_basket_surcharge` float DEFAULT NULL,
  `customer_cash_payment_amount` float DEFAULT NULL,
  `courier_name` text,
  `courier_phone_number` text,
  `delivery_address_label` text,
  `delivery_address_latitude` float DEFAULT NULL,
  `delivery_address_longitude` float DEFAULT NULL,
  `pick_up_code` text,
  `is_picked_up_by_customer` tinyint(1) DEFAULT NULL,
  `cutlery_requested` tinyint(1) DEFAULT NULL,
  `partner_discounts_products` float DEFAULT NULL,
  `partner_discounted_products_total` float DEFAULT NULL,
  `total_customer_to_pay` float DEFAULT NULL,
  `loyalty_card` text,
  `etat` int(11) DEFAULT '-1',
  `total_a_payer_ht` float DEFAULT NULL,
  `total_a_payer_ttc` float DEFAULT NULL,
  `total_paye` float DEFAULT NULL,
  `reste_a_payer` float DEFAULT NULL,
  `montant_remise` float DEFAULT NULL,
  `total_apres_reduction` float DEFAULT NULL,
  `remise` float DEFAULT NULL,
  `montant_tva` float DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `statut` text,
  `deleted` int(11) DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `status_glovo` varchar(50) DEFAULT NULL,
  `READY_FOR_PICKUP` varchar(50) DEFAULT NULL,
  `api_OUT_FOR_DELIVERY` varchar(50) DEFAULT NULL,
  `api_PICKED_UP_BY_CUSTOMER` varchar(50) DEFAULT NULL,
  `api_ACCEPTED` varchar(50) DEFAULT NULL,
  `cancel_reason` varchar(50) DEFAULT NULL,
  `payment_strategy` varchar(50) DEFAULT NULL,
  `modified` int(11) DEFAULT '0',
  `reqjeson` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `commande_glovo_details`
--

CREATE TABLE `commande_glovo_details` (
  `id` int(11) NOT NULL,
  `glovo_id` varchar(50) DEFAULT NULL,
  `product_barcode` varchar(50) DEFAULT NULL,
  `name` text,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` decimal(10,3) DEFAULT NULL,
  `deleted` int(11) DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `commandes_glovo_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `qte` decimal(10,3) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `compteurs`
--

CREATE TABLE `compteurs` (
  `id` int(11) NOT NULL,
  `module` varchar(50) NOT NULL,
  `store_id` int(11) NOT NULL,
  `prefix` varchar(50) DEFAULT NULL,
  `numero` varchar(50) DEFAULT NULL,
  `user_c` int(11) NOT NULL,
  `date_c` datetime NOT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `compteurs`
--

INSERT INTO `compteurs` (`id`, `module`, `store_id`, `prefix`, `numero`, `user_c`, `date_c`, `user_u`, `date_u`, `deleted`) VALUES
(7, 'Bon commande', 10, 'CMDD2', '0028', 2, '2021-10-26 17:59:03', 2, '2021-10-27 12:20:08', 0),
(9, 'Bon retour', 17, 'BRR', '00003', 2, '2021-10-27 14:48:47', NULL, NULL, 0),
(10, 'Bon commande', 17, 'CMD2', '00001', 2, '2021-10-27 15:00:32', 2, '2021-10-27 15:00:48', 0),
(11, 'Facture', 11, 'FC', '00001', 2, '2021-10-27 16:16:39', NULL, NULL, 0),
(12, 'Devis', 10, 'DVV', '00048', 2, '2021-10-27 16:17:02', 2, '2021-10-28 15:41:06', 0),
(13, 'Bon livraison', 10, 'BL2', '000058', 2, '2021-10-28 15:34:18', 2, '2021-11-04 16:22:45', 0),
(15, 'Bon livraison', 17, 'BLB', '00001', 2, '2021-12-16 13:20:41', NULL, NULL, 1),
(52, 'Bon commande', 19, 'CMDD2', '0028', 2, '2021-10-26 17:59:03', 2, '2021-10-27 12:20:08', 0),
(53, 'Bon livraison', 19, 'BLL', '00003', 2, '2021-10-27 14:46:06', NULL, NULL, 0),
(54, 'Bon retour', 19, 'BRR', '00003', 2, '2021-10-27 14:48:47', NULL, NULL, 0),
(56, 'Devis', 19, 'DVV', '00048', 2, '2021-10-27 16:17:02', 2, '2021-10-28 15:41:06', 0),
(60, 'Facture', 19, 'FC', '00001', 2, '2021-10-27 16:16:39', NULL, NULL, 0),
(62, 'Facture', 10, 'FC', '00001', 2, '2021-10-27 16:16:39', NULL, NULL, 0),
(63, 'Bon retour', 10, 'BRR', '00003', 2, '2021-10-27 14:48:47', NULL, NULL, 0),
(64, 'Bon commande', 11, 'CMDD2', '0028', 2, '2021-10-26 17:59:03', 2, '2021-10-27 12:20:08', 0),
(65, 'Bon livraison', 11, 'BLL', '00003', 2, '2021-10-27 14:46:06', NULL, NULL, 0),
(66, 'Bon retour', 11, 'BRR', '00003', 2, '2021-10-27 14:48:47', NULL, NULL, 0),
(67, 'Devis', 11, 'DVV', '00001', 2, '2021-10-27 16:17:02', 2, '2022-12-09 09:21:02', 0),
(68, 'Bon commande', 18, 'CMDD2', '0028', 2, '2021-10-26 17:59:03', 2, '2021-10-27 12:20:08', 0),
(69, 'Bon livraison', 18, 'BLL', '00003', 2, '2021-10-27 14:46:06', NULL, NULL, 0),
(70, 'Bon retour', 18, 'BRR', '00003', 2, '2021-10-27 14:48:47', NULL, NULL, 0),
(71, 'Facture', 18, 'FC', '00001', 2, '2021-10-27 16:16:39', NULL, NULL, 0),
(72, 'Devis', 18, 'DVV', '00048', 2, '2021-10-27 16:17:02', 2, '2021-10-28 15:41:06', 0),
(73, 'Bon commande', 15, 'CMDD2', '0028', 2, '2021-10-26 17:59:03', 2, '2021-10-27 12:20:08', 0),
(74, 'Bon livraison', 17, 'BLL', '00003', 2, '2021-10-27 14:46:06', NULL, NULL, 0),
(75, 'Bon retour', 15, 'BRR', '00003', 2, '2021-10-27 14:48:47', NULL, NULL, 0),
(76, 'Facture', 15, 'FC', '00001', 2, '2021-10-27 16:16:39', NULL, NULL, 0),
(77, 'Devis', 15, 'DVV', '00048', 2, '2021-10-27 16:17:02', 2, '2021-10-28 15:41:06', 0),
(78, 'Bon livraison', 15, 'BLL', '00003', 2, '2021-10-27 14:46:06', NULL, NULL, 0),
(79, 'Bon commande', 14, 'CMDD2', '0028', 2, '2021-10-26 17:59:03', 2, '2021-10-27 12:20:08', 0),
(80, 'Bon livraison', 14, 'BLL', '00003', 2, '2021-10-27 14:46:06', NULL, NULL, 0),
(81, 'Bon retour', 14, 'BRR', '00003', 2, '2021-10-27 14:48:47', NULL, NULL, 0),
(82, 'Facture', 14, 'FC', '00001', 2, '2021-10-27 16:16:39', NULL, NULL, 0),
(83, 'Devis', 14, 'DVV', '00048', 2, '2021-10-27 16:17:02', 2, '2021-10-28 15:41:06', 0),
(84, 'Bon commande', 12, 'CMDD2', '0028', 2, '2021-10-26 17:59:03', 2, '2021-10-27 12:20:08', 0),
(85, 'Bon livraison', 12, 'BLL', '00003', 2, '2021-10-27 14:46:06', NULL, NULL, 0),
(86, 'Bon retour', 12, 'BRR', '00003', 2, '2021-10-27 14:48:47', NULL, NULL, 0),
(87, 'Facture', 12, 'FC', '00001', 2, '2021-10-27 16:16:39', NULL, NULL, 0),
(88, 'Devis', 12, 'DVV', '00048', 2, '2021-10-27 16:17:02', 2, '2021-10-28 15:41:06', 0),
(89, 'Facture', 17, 'FC', '00001', 2, '2021-10-27 16:16:39', NULL, NULL, 0),
(90, 'Devis', 17, 'DVV', '00048', 2, '2021-10-27 16:17:02', 2, '2021-10-28 15:41:06', 0),
(91, 'Bon commande', 16, 'BC', '00001', 2, '2021-10-26 17:59:03', 2, '2022-12-20 10:49:52', 0),
(92, 'Bon retour', 16, 'BRR', '00003', 2, '2021-10-27 14:48:47', NULL, NULL, 0),
(93, 'Facture', 16, 'FC', '00001', 2, '2021-10-27 16:16:39', NULL, NULL, 0),
(94, 'Devis', 16, 'DVV', '00001', 2, '2021-10-27 16:17:02', 2, '2022-12-09 14:43:48', 0),
(95, 'Bon livraison', 16, 'BL2', '000001', 2, '2021-10-28 15:34:18', 2, '2022-12-09 14:43:39', 0),
(96, 'Bon commande', 1, 'CMDD2', '0028', 2, '2021-10-26 17:59:03', 2, '2021-10-27 12:20:08', 0),
(97, 'Bon retour', 1, 'BRR', '00003', 2, '2021-10-27 14:48:47', NULL, NULL, 0),
(98, 'Facture', 1, 'FC', '00001', 2, '2021-10-27 16:16:39', NULL, NULL, 0),
(99, 'Devis', 1, 'DVV', '00048', 2, '2021-10-27 16:17:02', 2, '2021-10-28 15:41:06', 0),
(100, 'Bon livraison', 1, 'BL2', '000058', 2, '2021-10-28 15:34:18', 2, '2021-11-04 16:22:45', 0),
(101, 'Bon commande', 20, NULL, NULL, 2, '2022-05-30 17:34:06', NULL, NULL, 0),
(102, 'Bon livraison', 20, NULL, NULL, 2, '2022-05-30 17:34:06', NULL, NULL, 0),
(103, 'Bon retour', 20, NULL, NULL, 2, '2022-05-30 17:34:06', NULL, NULL, 0),
(104, 'Facture', 20, NULL, NULL, 2, '2022-05-30 17:34:06', NULL, NULL, 0),
(105, 'Devis', 20, NULL, NULL, 2, '2022-05-30 17:34:06', NULL, NULL, 0);

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
(1, 'JCOLLAB', '4.1', '17fa2f2', 'https://iafsys.app/jcollab4x/', 'https://iafsys.app/jcollab4x/pos/index/', 'https://iafsys.app/jcollab4x/', 3, 'h.sadek@jaweb.ma', '2023-04-10 00:00:00', '2023-06-12 11:44:38', 0, '2', 5, 17);

-- --------------------------------------------------------

--
-- Structure de la table `depences`
--

CREATE TABLE `depences` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `numero_piece` varchar(255) DEFAULT NULL,
  `emeteur` varchar(255) DEFAULT NULL,
  `vente_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `versement_id` int(11) DEFAULT NULL,
  `bonlivraison_id` int(11) DEFAULT NULL,
  `bonreception_id` int(11) DEFAULT NULL,
  `boncommande_id` int(11) DEFAULT NULL,
  `categoriedepence_id` int(11) NOT NULL DEFAULT '1',
  `mode` int(11) DEFAULT NULL,
  `etat` int(11) NOT NULL DEFAULT '-1',
  `verse` int(11) NOT NULL DEFAULT '-1',
  `montant` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `date_echeance` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
-- Déchargement des données de la table `depotproduits`
--

INSERT INTO `depotproduits` (`id`, `date`, `produit_id`, `depot_id`, `quantite`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, '2023-06-10', 7, 11, '-0.501', 0, 1, '2023-06-10 17:21:01', NULL, NULL),
(2, '2023-06-10', 6, 11, '-0.501', 0, 1, '2023-06-10 17:21:01', NULL, NULL),
(3, '2023-06-10', 7, 10, '0.201', 0, 1, '2023-06-10 17:52:23', NULL, NULL),
(4, '2023-06-10', 6, 10, '4.302', 0, 1, '2023-06-10 17:52:23', 1, '2023-06-10 18:02:22'),
(5, '2023-06-10', 6, 3, '-1.801', 0, 1, '2023-06-10 18:00:43', NULL, NULL),
(6, '2023-06-10', 115, 3, '-1.000', 0, 1, '2023-06-10 18:06:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `depots`
--

CREATE TABLE `depots` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `societe_id` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `vente` int(11) NOT NULL DEFAULT '-1',
  `principal` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `depots`
--

INSERT INTO `depots` (`id`, `reference`, `libelle`, `adresse`, `societe_id`, `store_id`, `vente`, `principal`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'DP-000001', 'ANFA', '', 1, 10, 1, 1, 0, 2, '2021-11-23 15:03:55', 2, '2021-12-07 14:42:42'),
(2, 'DP-000002', 'GAUTHIER', '', 1, 11, 1, 1, 0, 2, '2021-11-25 07:55:39', 5, '2021-12-01 15:06:00'),
(3, 'DP-000003', 'Comptoire', '', 4, 17, 1, 1, 0, 2, '2021-11-25 07:55:56', 1, '2023-06-10 16:54:18'),
(4, 'DP-000004', 'CALIFORNIE', '', 4, 16, 1, 1, 0, 2, '2021-11-25 07:56:12', 5, '2021-12-01 15:05:35'),
(5, 'DP-000005', 'FES', '', 3, 14, 1, 1, 0, 2, '2021-11-25 07:56:25', 5, '2021-12-01 15:05:46'),
(6, 'DP-000006', 'GUELIZ', '', 2, 18, 1, 1, 0, 2, '2021-11-25 07:56:39', 5, '2021-12-01 15:06:16'),
(7, 'DP-000007', ' RABAT', '', 2, 15, 1, 1, 0, 2, '2021-11-25 07:57:27', 5, '2021-12-01 15:06:53'),
(8, 'DP-000008', 'TANGER', '', 3, 12, 1, 1, 0, 2, '2021-11-25 07:57:44', 5, '2021-12-01 15:07:06'),
(9, 'DP-000009', 'MLY DRISS', '', 5, 1, 1, 1, 0, 2, '2021-11-25 07:58:33', 5, '2021-12-01 15:06:38'),
(10, 'DP-000010', 'USINE', '', 1, 19, 1, 1, 0, 2, '2021-11-26 09:06:44', 2, '2021-12-28 13:05:21'),
(11, 'DP-000003', 'Chambre froide', '', 4, 17, -1, 1, 0, 2, '2021-11-25 07:55:56', 1, '2023-06-10 16:54:48');

-- --------------------------------------------------------

--
-- Structure de la table `devidetails`
--

CREATE TABLE `devidetails` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `devi_id` int(11) DEFAULT NULL,
  `categorieproduit_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `qte` decimal(10,3) DEFAULT NULL,
  `paquet` int(11) DEFAULT NULL,
  `total_unitaire` int(11) DEFAULT NULL,
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE `devis` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT '1',
  `bonlivraison_id` int(11) DEFAULT NULL,
  `etat` int(11) DEFAULT '-1',
  `total_qte` decimal(10,2) DEFAULT NULL,
  `total_paquet` decimal(10,2) DEFAULT NULL,
  `total_a_payer_ht` decimal(10,2) DEFAULT '0.00',
  `total_a_payer_ttc` decimal(10,2) DEFAULT '0.00',
  `total_paye` decimal(10,2) DEFAULT '0.00',
  `reste_a_payer` decimal(10,2) DEFAULT '0.00',
  `montant_remise` decimal(10,2) DEFAULT '0.00',
  `total_apres_reduction` decimal(10,2) DEFAULT '0.00',
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_tva` decimal(10,2) DEFAULT NULL,
  `active_remise` int(11) DEFAULT '-1',
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `reduction` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `divers`
--

CREATE TABLE `divers` (
  `id` int(11) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `divers`
--

INSERT INTO `divers` (`id`, `libelle`, `description`, `module_id`, `link`, `deleted`) VALUES
(1, 'Pays', 'Liste des pays', 26, '{\"controller\":\"pays\",\"action\":\"index\"}', 0),
(2, 'Ville', 'Liste des villes', 26, '{\"controller\":\"villes\",\"action\":\"index\"}', 0),
(8, 'Categorie client', 'Liste des categories clients', 26, '{\"controller\":\"clienttypes\",\"action\":\"index\"}', 0),
(9, 'Categorie produit', 'Liste des categories produit', 26, '{\"controller\":\"categorieproduits\",\"action\":\"index\"}', 0),
(10, 'Motif planification', 'Liste des motifs planification', 26, '{\"controller\":\"motifplanifications\",\"action\":\"index\"}', 0),
(11, 'Type client', 'Liste des types clients', 26, '{\"controller\":\"categorieclients\",\"action\":\"index\"}', 0),
(12, 'Sous categorie produit', 'Liste des sous categories produit', 26, '{\"controller\":\"souscategorieproduits\",\"action\":\"index\"}', 0),
(13, 'Categorie depence', 'Liste des categories depences', 26, '{\"controller\":\"categoriedepences\",\"action\":\"index\"}', 0),
(14, 'Unites', 'Liste des unites', 26, '{\"controller\":\"unites\",\"action\":\"index\"}', 0),
(15, 'Type commande', 'Liste des types commande', 26, '{\"controller\":\"typecommandes\",\"action\":\"index\"}', 0),
(16, 'TVA', 'Liste des tva', 26, '{\"controller\":\"tvas\",\"action\":\"index\"}', 0),
(17, 'Options', 'Listes Des Options Produits/Rocettes', 26, '{\"controller\":\"options\",\"action\":\"index\"}', 0),
(18, 'Type de Conditionnement', 'Listes Des Types de Conditionnement', 26, '{\"controller\":\"typeconditionnement\",\"action\":\"index\"}', 0),
(19, 'Frais de Livraison', 'Listes Des Frais de Livraison', 26, '{\"controller\":\"fraislivraison\",\"action\":\"index\"}', 0),
(20, 'Motifs abandon', 'Motifs abandon commande', 26, '{\"controller\":\"motifsabandon\",\"action\":\"index\"}', 0);

-- --------------------------------------------------------

--
-- Structure de la table `ecommercedetails`
--

CREATE TABLE `ecommercedetails` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `ecommerce_id` int(11) DEFAULT NULL,
  `online_id` int(11) DEFAULT NULL,
  `variation_id` varchar(20) DEFAULT NULL,
  `qte_cmd` decimal(10,3) DEFAULT '0.000',
  `qte_ordered` decimal(10,3) DEFAULT NULL,
  `qte` decimal(10,3) DEFAULT '0.000',
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT NULL,
  `tva` decimal(10,2) DEFAULT NULL,
  `montant_tva` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `preparation` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ecommerces`
--

CREATE TABLE `ecommerces` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `barcode` varchar(50) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `shipment` varchar(50) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `adresse` text NOT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `bonlivraison_id` int(11) DEFAULT NULL,
  `online_id` int(11) DEFAULT NULL,
  `etat` int(11) DEFAULT '-1',
  `total_qte` decimal(10,2) DEFAULT NULL,
  `fee` int(11) NOT NULL,
  `total_a_payer_ht` decimal(10,2) DEFAULT '0.00',
  `total_a_payer_ttc` decimal(10,2) DEFAULT '0.00',
  `total_paye` decimal(10,2) DEFAULT '0.00',
  `reste_a_payer` decimal(10,2) DEFAULT '0.00',
  `montant_remise` decimal(10,2) DEFAULT '0.00',
  `total_apres_reduction` decimal(10,2) DEFAULT '0.00',
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_tva` decimal(10,2) DEFAULT NULL,
  `active_remise` int(11) DEFAULT '-1',
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `statut` varchar(30) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `sync` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `emails`
--

CREATE TABLE `emails` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `objet` varchar(255) DEFAULT NULL,
  `content` text,
  `devi_id` int(11) DEFAULT NULL,
  `bonlivraison_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `bonretour_id` int(11) DEFAULT NULL,
  `bonavoir_id` int(11) DEFAULT NULL,
  `boncommande_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `entrees`
--

CREATE TABLE `entrees` (
  `id` int(11) NOT NULL,
  `quantite` decimal(10,3) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) NOT NULL,
  `date_c` datetime NOT NULL,
  `type` varchar(10) NOT NULL,
  `sync` int(11) NOT NULL DEFAULT '0' COMMENT 'Etat de synchronisation'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `entrees`
--

INSERT INTO `entrees` (`id`, `quantite`, `depot_id`, `produit_id`, `deleted`, `user_c`, `date_c`, `type`, `sync`) VALUES
(1, '0.501', 11, 7, 0, 1, '2023-05-10 17:21:01', 'Sortie', 0),
(2, '0.501', 11, 6, 0, 1, '2023-04-10 17:21:01', 'Sortie', 0),
(3, '0.201', 10, 7, 0, 1, '2023-06-10 17:52:22', 'Entree', 0),
(4, '0.501', 10, 6, 0, 1, '2023-06-10 17:52:23', 'Entree', 0),
(5, '1.801', 3, 6, 0, 1, '2023-06-10 18:00:43', 'Sortie', 0),
(6, '3.801', 10, 6, 0, 1, '2023-06-10 18:02:22', 'Entree', 0),
(7, '1.000', 3, 115, 0, 1, '2023-06-10 18:06:21', 'Sortie', 0);

-- --------------------------------------------------------

--
-- Structure de la table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `libelle` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `versement_id` int(11) DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `facturedetails`
--

CREATE TABLE `facturedetails` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `categorieproduit_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `qte` decimal(10,3) DEFAULT NULL,
  `paquet` int(11) DEFAULT NULL,
  `total_unitaire` int(11) DEFAULT NULL,
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `facturedetails`
--

INSERT INTO `facturedetails` (`id`, `produit_id`, `depot_id`, `facture_id`, `categorieproduit_id`, `description`, `date`, `qte`, `paquet`, `total_unitaire`, `prix_vente`, `total`, `ttc`, `remise`, `montant_remise`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 7, 1, 1, NULL, NULL, NULL, '0.501', NULL, NULL, '249.00', NULL, '124.75', NULL, NULL, 0, 1, '2023-06-10 11:08:00', NULL, NULL),
(2, 6, 1, 1, NULL, NULL, NULL, '0.501', NULL, NULL, '172.00', NULL, '86.17', NULL, NULL, 0, 1, '2023-06-10 11:08:00', NULL, NULL),
(3, 115, 1, 1, NULL, NULL, NULL, '1.000', NULL, NULL, '144.00', NULL, '144.00', NULL, NULL, 0, 1, '2023-06-10 11:08:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE `factures` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `bonlivraison_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT '1',
  `etat` int(11) DEFAULT '-1',
  `paye` int(11) DEFAULT '-1',
  `total_qte` int(11) DEFAULT NULL,
  `total_paquet` int(11) DEFAULT NULL,
  `total_a_payer_ht` decimal(10,2) DEFAULT '0.00',
  `total_a_payer_ttc` decimal(10,2) DEFAULT '0.00',
  `total_paye` decimal(10,2) DEFAULT '0.00',
  `reste_a_payer` decimal(10,2) DEFAULT '0.00',
  `total_apres_reduction` decimal(10,2) DEFAULT '0.00',
  `reduction` decimal(10,2) DEFAULT '0.00',
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_tva` decimal(10,2) DEFAULT NULL,
  `active_remise` int(11) DEFAULT NULL,
  `montant_remise` float NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `factures`
--

INSERT INTO `factures` (`id`, `reference`, `client_id`, `bonlivraison_id`, `depot_id`, `etat`, `paye`, `total_qte`, `total_paquet`, `total_a_payer_ht`, `total_a_payer_ttc`, `total_paye`, `reste_a_payer`, `total_apres_reduction`, `reduction`, `remise`, `montant_tva`, `active_remise`, `montant_remise`, `user_id`, `date`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'FC-00001', 84, 4, 3, 2, 2, 2, 0, '295.77', '354.92', '354.92', '0.00', '354.92', '0.00', NULL, '59.15', NULL, 0, NULL, '2023-06-10', 0, 1, '2023-06-10 11:08:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `fidelites`
--

CREATE TABLE `fidelites` (
  `id` int(11) NOT NULL,
  `montant` float DEFAULT NULL,
  `points` float DEFAULT NULL,
  `montant_cheque_cad` float DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_c` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `deleted` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id` int(11) NOT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `capital` decimal(10,2) DEFAULT NULL,
  `idfiscale` varchar(50) DEFAULT NULL,
  `ice` varchar(50) DEFAULT NULL,
  `registrecommerce` varchar(50) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telmobile` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `activite` varchar(255) DEFAULT NULL,
  `compte_comptable` int(11) DEFAULT NULL,
  `fournisseurs` int(11) DEFAULT NULL,
  `ville_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `designation`, `reference`, `date`, `capital`, `idfiscale`, `ice`, `registrecommerce`, `adresse`, `telmobile`, `fax`, `email`, `website`, `avatar`, `activite`, `compte_comptable`, `fournisseurs`, `ville_id`, `deleted`, `active`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(4, 'I.A.F SARL', 'FRS-000004', NULL, NULL, NULL, '', '', '', '00', '', '', NULL, NULL, NULL, NULL, NULL, 12, 0, 1, 2, '2021-12-27 09:12:15', NULL, NULL),
(5, 'ADV', 'FRS-000005', NULL, NULL, NULL, '', '', '', '00', '', '', NULL, NULL, NULL, NULL, NULL, 12, 0, 1, 2, '2021-12-28 12:42:22', NULL, NULL),
(6, 'NDV', 'FRS-000006', NULL, NULL, NULL, '', '', '', '00', '', '', NULL, NULL, NULL, NULL, NULL, 12, 0, 1, 2, '2021-12-28 12:42:35', NULL, NULL),
(7, 'TM', 'FRS-000007', NULL, NULL, NULL, '', '', '', '00', '', '', NULL, NULL, NULL, NULL, NULL, 12, 0, 1, 2, '2021-12-28 12:42:50', NULL, NULL),
(8, 'DVIAM', 'FRS-000008', NULL, NULL, NULL, '', '', '', '00', '', '', NULL, NULL, NULL, NULL, NULL, 12, 0, 1, 2, '2021-12-28 12:43:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `fraislivraisons`
--

CREATE TABLE `fraislivraisons` (
  `id` int(255) NOT NULL,
  `valeur` varchar(255) DEFAULT NULL,
  `deleted` int(255) DEFAULT '0',
  `user_c` int(255) DEFAULT NULL,
  `date_c` datetime(6) DEFAULT NULL,
  `user_u` int(255) DEFAULT NULL,
  `date_u` datetime(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `groupes`
--

CREATE TABLE `groupes` (
  `id` int(11) NOT NULL,
  `libelle` varchar(250) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `groupes`
--

INSERT INTO `groupes` (`id`, `libelle`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'Groupe alertes', 0, 7, '2021-01-19 19:30:52', 2, '2021-02-18 00:55:01');

-- --------------------------------------------------------

--
-- Structure de la table `groupes_users`
--

CREATE TABLE `groupes_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `groupe_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `groupes_users`
--

INSERT INTO `groupes_users` (`id`, `user_id`, `groupe_id`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(3, 1, 1, 0, NULL, NULL, NULL, NULL),
(4, 2, 1, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `inventairedetails`
--

CREATE TABLE `inventairedetails` (
  `id` int(11) NOT NULL,
  `inventaire_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `code_barre` varchar(255) NOT NULL COMMENT 'code article',
  `valstkini` decimal(10,3) NOT NULL COMMENT 'valeur précedente de valeur theorique',
  `quantite_reel` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'SCAN',
  `quantite_theorique` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT '$quantite_theorique = ($valstkini + $qtentree - $qtsortie - $qtvente);',
  `qtentree` decimal(10,3) NOT NULL,
  `valentree` decimal(10,3) NOT NULL,
  `valsortie` decimal(10,3) NOT NULL,
  `qtsortie` decimal(10,3) NOT NULL,
  `qtvente` decimal(10,3) NOT NULL,
  `valvente` decimal(10,3) NOT NULL,
  `ecart` decimal(10,3) NOT NULL DEFAULT '0.000' COMMENT 'scan - theorique',
  `qteecart` decimal(10,3) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `inventaires`
--

CREATE TABLE `inventaires` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `statut` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `kitchensystems`
--

CREATE TABLE `kitchensystems` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `ip_adresse` varchar(255) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `societe_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `kitchensystems`
--

INSERT INTO `kitchensystems` (`id`, `reference`, `libelle`, `ip_adresse`, `store_id`, `societe_id`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'KDS-000001', 'Kds de test', '123.123.123.123', 1, 1, 0, 1, '2021-06-20 21:27:01', 1, '2021-06-20 21:42:34'),
(2, 'KDS-000002', 'Kds de test 2', '123.123.0.1', 2, 2, 0, 1, '2021-06-20 21:29:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `kitchensystems_produits`
--

CREATE TABLE `kitchensystems_produits` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `kitchensystem_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `lastsessions`
--

CREATE TABLE `lastsessions` (
  `id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `login` varchar(50) DEFAULT NULL,
  `logout` int(11) NOT NULL DEFAULT '-1',
  `force_to_deco` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lastsessions`
--

INSERT INTO `lastsessions` (`id`, `date`, `login`, `logout`, `force_to_deco`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, '2023-06-13 14:28:00', 'admin', 1, 0, 0, NULL, NULL, 1, '2023-06-13 14:28:11'),
(2, '2023-04-27 11:02:00', 'administrateur', -1, 0, 0, NULL, NULL, 2, '2023-04-27 11:02:21'),
(12, '2023-04-17 14:51:00', 'OBIHI', -1, 0, 0, NULL, NULL, 12, '2023-04-17 14:51:54'),
(57, '2023-02-06 11:05:00', 'MAHMOUDI', -1, 0, 0, NULL, NULL, 57, '2023-02-06 11:05:35'),
(58, '2023-02-06 18:50:00', 'ELBAKRI', -1, 0, 0, NULL, NULL, 58, '2023-02-06 18:50:45'),
(59, '2023-01-21 17:16:00', 'AHMIDI', -1, 0, 0, NULL, NULL, 59, '2023-01-21 17:16:44'),
(60, '2023-02-06 18:47:00', 'RAIFAK', 1, 0, 0, NULL, NULL, 60, '2023-02-06 18:47:07'),
(61, '2023-02-06 17:43:00', 'BYAD', 1, 0, 0, NULL, NULL, 61, '2023-02-06 17:43:56'),
(63, '2023-02-06 18:35:00', 'ABID', 1, 0, 0, NULL, NULL, 63, '2023-02-06 18:35:08'),
(64, '2023-01-31 08:24:00', 'MOHARRAR', -1, 0, 0, NULL, NULL, 64, '2023-01-31 08:24:35'),
(65, '2023-02-06 20:12:00', 'AITELMOKHTAR', 1, 0, 0, NULL, NULL, 65, '2023-02-06 20:12:29'),
(66, '2023-03-25 11:36:00', 'AITAOUMAN', -1, 0, 0, NULL, NULL, 66, '2023-03-25 11:36:44'),
(67, '2023-02-06 19:08:00', 'MANAR', 1, 0, 0, NULL, NULL, 67, '2023-02-06 19:08:51'),
(68, '2023-01-26 09:50:00', 'BOUCEKKOM', -1, 0, 0, NULL, NULL, 68, '2023-01-26 09:50:43'),
(70, '2023-02-04 18:31:00', 'ELMALIKI', 1, 0, 0, NULL, NULL, 70, '2023-02-04 18:31:14'),
(72, '2023-02-04 16:56:00', 'DAOUDI', 1, 0, 0, NULL, NULL, 72, '2023-02-04 16:56:18'),
(73, '2023-01-18 09:51:00', 'LAHLOU', 1, 0, 0, NULL, NULL, 73, '2023-01-18 09:51:01'),
(74, '2023-02-06 19:19:00', 'ELFAJI', -1, 0, 0, NULL, NULL, 74, '2023-02-06 19:19:05'),
(77, '2023-02-06 18:39:00', 'BOUKJIJ', -1, 0, 0, NULL, NULL, 77, '2023-02-06 18:39:40'),
(78, '2022-02-21 13:45:00', 'Bartouli', -1, 0, 0, NULL, NULL, 78, '2022-02-21 13:45:20'),
(80, '2023-03-06 14:04:00', 'Jawad Akroud', 1, 0, 0, NULL, NULL, 80, '2023-03-06 14:04:28'),
(82, '2023-02-06 10:08:00', 's.alami', -1, 0, 0, NULL, NULL, 82, '2023-02-06 10:08:23'),
(83, '2023-03-30 22:56:00', 'Test', -1, 0, 0, NULL, NULL, 83, '2023-03-30 22:56:59'),
(84, '2023-05-22 11:47:00', 'l.elfahsi', -1, 0, 0, NULL, NULL, 84, '2023-05-22 11:47:17'),
(86, '2023-02-06 10:53:00', 'h.bouazziz', -1, 0, 0, NULL, NULL, 86, '2023-02-06 10:53:54'),
(88, '2023-04-18 00:17:00', 'nor', -1, 0, 0, NULL, NULL, 88, '2023-04-18 00:17:59');

-- --------------------------------------------------------

--
-- Structure de la table `localisations`
--

CREATE TABLE `localisations` (
  `id` int(11) NOT NULL,
  `latitude` varchar(250) CHARACTER SET utf8 DEFAULT NULL,
  `longitude` varchar(250) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `logings`
--

CREATE TABLE `logings` (
  `id` int(11) NOT NULL,
  `module` varchar(255) DEFAULT NULL,
  `transaction` varchar(255) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `logings`
--

INSERT INTO `logings` (`id`, `module`, `transaction`, `user_c`, `date_c`, `deleted`) VALUES
(1, 'Module', 'Modification', 1, '2021-06-20 20:34:26', 0),
(2, 'Liste des roles', 'Modification', 2, '2021-12-27 13:13:55', 0),
(3, 'Liste des roles', 'Modification', 2, '2021-12-27 13:14:01', 0),
(4, 'Role', 'Suppression', 2, '2021-12-27 13:14:07', 0),
(5, 'Liste des roles', 'Modification', 2, '2021-12-27 16:48:11', 0),
(6, 'Liste des roles', 'Modification', 2, '2022-01-31 15:51:59', 0),
(7, 'Liste des roles', 'Modification', 2, '2022-01-31 15:52:04', 0),
(8, 'Liste des roles', 'Modification', 2, '2022-02-01 22:20:20', 0),
(9, 'Liste des roles', 'Modification', 2, '2022-02-01 22:20:33', 0),
(10, 'Role', 'Suppression', 2, '2022-02-01 22:20:46', 0),
(11, 'Liste des roles', 'Modification', 2, '2022-02-01 22:20:57', 0),
(12, 'Role', 'Suppression', 2, '2022-02-01 22:21:02', 0),
(13, 'Liste des roles', 'Modification', 2, '2022-02-01 22:21:13', 0),
(14, 'Liste des roles', 'Modification', 2, '2022-02-01 22:22:08', 0),
(15, 'Liste des roles', 'Modification', 2, '2022-02-01 22:22:19', 0),
(16, 'Liste des roles', 'Modification', 2, '2022-02-01 22:22:27', 0),
(17, 'Liste des roles', 'Modification', 2, '2022-02-01 22:22:51', 0),
(18, 'Module', 'Modification', 1, '2022-02-06 17:37:51', 0),
(19, 'Module', 'Modification', 1, '2022-02-08 09:06:43', 0),
(20, 'Module', 'Modification', 1, '2022-02-09 13:08:09', 0),
(21, 'Module', 'Modification', 1, '2022-02-09 20:59:03', 0),
(22, 'Module', 'Modification', 1, '2022-02-09 20:59:13', 0),
(23, 'Module', 'Modification', 1, '2022-02-09 20:59:23', 0),
(24, 'Module', 'Modification', 1, '2022-11-23 14:22:28', 0),
(25, 'Module', 'Suppression', 1, '2022-11-23 14:22:38', 0),
(26, 'Liste des roles', 'Modification', 2, '2023-01-25 15:14:32', 0),
(27, 'Module', 'Modification', 1, '2023-04-10 20:00:14', 0),
(28, 'Module', 'Modification', 1, '2023-04-10 20:00:31', 0),
(29, 'Module', 'Modification', 1, '2023-04-10 20:05:35', 0),
(30, 'Module', 'Modification', 1, '2023-04-12 07:17:54', 0),
(31, 'Module', 'Modification', 1, '2023-04-12 07:28:14', 0),
(32, 'Liste des roles', 'Modification', 2, '2023-04-13 14:44:55', 0),
(33, 'Liste des roles', 'Modification', 2, '2023-04-13 14:45:50', 0),
(34, 'Liste des roles', 'Modification', 2, '2023-04-13 14:46:01', 0),
(35, 'Liste des roles', 'Modification', 2, '2023-04-13 14:46:12', 0),
(36, 'Liste des roles', 'Modification', 2, '2023-04-13 14:46:36', 0),
(37, 'Liste des roles', 'Modification', 2, '2023-04-13 14:50:02', 0),
(38, 'Liste des roles', 'Modification', 2, '2023-04-13 14:55:43', 0),
(39, 'Liste des roles', 'Modification', 2, '2023-04-13 14:57:20', 0),
(40, 'Liste des roles', 'Modification', 2, '2023-04-13 14:57:20', 0),
(41, 'Liste des roles', 'Modification', 2, '2023-04-13 14:58:28', 0),
(42, 'Liste des roles', 'Modification', 2, '2023-04-13 14:58:29', 0),
(43, 'Liste des roles', 'Modification', 2, '2023-04-13 14:59:37', 0),
(44, 'Liste des roles', 'Modification', 2, '2023-04-13 14:59:37', 0),
(45, 'Liste des roles', 'Modification', 2, '2023-04-13 15:00:07', 0),
(46, 'Liste des roles', 'Modification', 2, '2023-04-13 15:00:07', 0),
(47, 'Liste des roles', 'Modification', 2, '2023-04-13 15:00:29', 0),
(48, 'Liste des roles', 'Modification', 2, '2023-04-13 15:00:30', 0),
(49, 'Liste des roles', 'Modification', 2, '2023-04-13 15:52:27', 0),
(50, 'Liste des roles', 'Modification', 2, '2023-04-13 15:52:27', 0),
(51, 'Liste des roles', 'Modification', 2, '2023-04-13 15:57:37', 0),
(52, 'Liste des roles', 'Modification', 2, '2023-04-13 15:57:37', 0),
(53, 'Liste des roles', 'Modification', 2, '2023-04-13 15:57:46', 0),
(54, 'Liste des roles', 'Modification', 2, '2023-04-13 15:57:46', 0),
(55, 'Liste des roles', 'Modification', 2, '2023-04-13 15:58:16', 0),
(56, 'Liste des roles', 'Modification', 2, '2023-04-13 15:58:16', 0),
(57, 'Liste des roles', 'Modification', 2, '2023-04-13 15:58:45', 0),
(58, 'Liste des roles', 'Modification', 2, '2023-04-13 15:58:45', 0),
(59, 'Liste des roles', 'Modification', 2, '2023-04-13 15:59:13', 0),
(60, 'Liste des roles', 'Modification', 2, '2023-04-13 15:59:14', 0),
(61, 'Liste des roles', 'Modification', 2, '2023-04-13 16:00:10', 0),
(62, 'Liste des roles', 'Modification', 2, '2023-04-13 16:00:10', 0),
(63, 'Liste des roles', 'Modification', 2, '2023-04-13 16:00:56', 0),
(64, 'Liste des roles', 'Modification', 2, '2023-04-13 16:00:56', 0),
(65, 'Liste des roles', 'Modification', 2, '2023-04-13 16:01:47', 0),
(66, 'Liste des roles', 'Modification', 2, '2023-04-13 16:01:47', 0),
(67, 'Liste des roles', 'Modification', 2, '2023-04-13 16:02:26', 0),
(68, 'Liste des roles', 'Modification', 2, '2023-04-13 16:02:26', 0),
(69, 'Liste des roles', 'Modification', 2, '2023-04-13 16:04:09', 0),
(70, 'Liste des roles', 'Modification', 2, '2023-04-13 16:04:10', 0),
(71, 'Liste des roles', 'Modification', 2, '2023-04-13 16:05:01', 0),
(72, 'Liste des roles', 'Modification', 2, '2023-04-13 16:07:18', 0),
(73, 'Liste des roles', 'Modification', 2, '2023-04-13 16:08:59', 0),
(74, 'Liste des roles', 'Modification', 2, '2023-04-13 16:10:14', 0),
(75, 'Liste des roles', 'Modification', 2, '2023-04-13 16:11:27', 0),
(76, 'Liste des roles', 'Modification', 2, '2023-04-13 16:12:10', 0),
(77, 'Liste des roles', 'Modification', 2, '2023-04-13 16:12:58', 0),
(78, 'Liste des roles', 'Modification', 2, '2023-04-13 16:13:28', 0),
(79, 'Liste des roles', 'Modification', 2, '2023-04-13 16:15:38', 0),
(80, 'Liste des roles', 'Modification', 2, '2023-04-13 16:18:32', 0),
(81, 'Liste des roles', 'Modification', 2, '2023-04-13 16:19:03', 0),
(82, 'Liste des roles', 'Modification', 2, '2023-04-13 16:19:15', 0),
(83, 'Liste des roles', 'Modification', 2, '2023-04-13 16:21:21', 0),
(84, 'Liste des roles', 'Modification', 2, '2023-04-13 16:22:00', 0),
(85, 'Liste des roles', 'Modification', 2, '2023-04-13 16:22:19', 0),
(86, 'Liste des roles', 'Modification', 1, '2023-04-14 09:34:50', 0),
(87, 'Liste des roles', 'Modification', 1, '2023-04-14 09:43:54', 0),
(88, 'Liste des roles', 'Modification', 1, '2023-04-14 10:14:36', 0),
(89, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:17', 0),
(90, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:18', 0),
(91, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:20', 0),
(92, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(93, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(94, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(95, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(96, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(97, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(98, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(99, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(100, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(101, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(102, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(103, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(104, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(105, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(106, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(107, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(108, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(109, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(110, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:21', 0),
(111, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(112, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(113, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(114, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(115, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(116, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(117, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(118, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(119, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(120, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(121, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(122, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(123, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(124, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(125, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(126, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(127, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(128, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(129, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:22', 0),
(130, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:23', 0),
(131, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:23', 0),
(132, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:23', 0),
(133, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:23', 0),
(134, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:24', 0),
(135, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:24', 0),
(136, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:25', 0),
(137, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:26', 0),
(138, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:27', 0),
(139, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:28', 0),
(140, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:29', 0),
(141, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:30', 0),
(142, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:31', 0),
(143, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:32', 0),
(144, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:32', 0),
(145, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:33', 0),
(146, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:34', 0),
(147, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:34', 0),
(148, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:35', 0),
(149, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:35', 0),
(150, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:36', 0),
(151, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:36', 0),
(152, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:37', 0),
(153, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:37', 0),
(154, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:38', 0),
(155, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:38', 0),
(156, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:38', 0),
(157, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:39', 0),
(158, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:40', 0),
(159, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:40', 0),
(160, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:41', 0),
(161, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:41', 0),
(162, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:42', 0),
(163, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:42', 0),
(164, 'Liste des roles', 'Modification', 1, '2023-04-25 20:14:43', 0),
(165, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:00', 0),
(166, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:02', 0),
(167, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:03', 0),
(168, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:03', 0),
(169, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:03', 0),
(170, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:03', 0),
(171, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:03', 0),
(172, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:03', 0),
(173, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:03', 0),
(174, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:03', 0),
(175, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:03', 0),
(176, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:03', 0),
(177, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:03', 0),
(178, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:03', 0),
(179, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(180, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(181, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(182, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(183, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(184, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(185, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(186, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(187, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(188, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(189, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(190, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(191, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(192, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(193, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(194, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(195, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(196, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(197, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(198, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(199, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:04', 0),
(200, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:05', 0),
(201, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:05', 0),
(202, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:05', 0),
(203, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:05', 0),
(204, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:05', 0),
(205, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:05', 0),
(206, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:05', 0),
(207, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:05', 0),
(208, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:05', 0),
(209, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:06', 0),
(210, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:06', 0),
(211, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:07', 0),
(212, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:08', 0),
(213, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:08', 0),
(214, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:09', 0),
(215, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:10', 0),
(216, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:11', 0),
(217, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:11', 0),
(218, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:12', 0),
(219, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:12', 0),
(220, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:13', 0),
(221, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:13', 0),
(222, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:14', 0),
(223, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:14', 0),
(224, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:15', 0),
(225, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:15', 0),
(226, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:16', 0),
(227, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:16', 0),
(228, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:17', 0),
(229, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:17', 0),
(230, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:18', 0),
(231, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:18', 0),
(232, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:18', 0),
(233, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:19', 0),
(234, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:19', 0),
(235, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:19', 0),
(236, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:20', 0),
(237, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:20', 0),
(238, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:21', 0),
(239, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:21', 0),
(240, 'Module', 'Modification', 1, '2023-05-22 12:41:56', 0),
(241, 'Module', 'Modification', 1, '2023-05-22 12:42:20', 0),
(242, 'Module', 'Modification', 1, '2023-05-22 12:43:19', 0),
(243, 'Module', 'Modification', 1, '2023-05-22 12:43:54', 0),
(244, 'Module', 'Modification', 1, '2023-05-22 12:45:07', 0),
(245, 'Module', 'Modification', 1, '2023-05-22 12:46:10', 0),
(246, 'Module', 'Modification', 1, '2023-05-22 12:47:03', 0),
(247, 'Module', 'Modification', 1, '2023-05-22 12:48:31', 0),
(248, 'Module', 'Modification', 1, '2023-05-22 12:49:06', 0),
(249, 'Module', 'Modification', 1, '2023-05-22 12:49:33', 0),
(250, 'Module', 'Modification', 1, '2023-05-22 12:50:26', 0),
(251, 'Module', 'Modification', 1, '2023-05-22 12:51:26', 0),
(252, 'Module', 'Modification', 1, '2023-05-22 12:52:01', 0),
(253, 'Module', 'Modification', 1, '2023-05-22 12:53:54', 0),
(254, 'Module', 'Modification', 1, '2023-05-22 12:54:22', 0),
(255, 'Module', 'Modification', 1, '2023-05-22 13:06:24', 0),
(256, 'Module', 'Modification', 1, '2023-05-22 13:08:27', 0),
(257, 'Module', 'Modification', 1, '2023-05-22 13:08:50', 0),
(258, 'Module', 'Modification', 1, '2023-05-22 13:09:25', 0),
(259, 'Module', 'Modification', 1, '2023-05-22 13:09:53', 0),
(260, 'Module', 'Modification', 1, '2023-05-22 13:10:31', 0),
(261, 'Module', 'Modification', 1, '2023-05-22 13:11:05', 0),
(262, 'Module', 'Modification', 1, '2023-05-22 13:11:36', 0);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `isread` int(11) NOT NULL DEFAULT '0',
  `isdraft` int(11) NOT NULL DEFAULT '0',
  `istrash` int(11) NOT NULL DEFAULT '0',
  `from_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `to_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `messages_users`
--

CREATE TABLE `messages_users` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `isread` int(11) NOT NULL DEFAULT '0',
  `istrash` int(11) NOT NULL DEFAULT '0',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE `modules` (
  `id` int(10) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `niveau` int(11) DEFAULT NULL,
  `link` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT 'icon-puzzle',
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `modules`
--

INSERT INTO `modules` (`id`, `libelle`, `parent_id`, `lft`, `rght`, `niveau`, `link`, `icon`, `created`, `updated`, `deleted`) VALUES
(1, 'Configuration', NULL, 1, 28, 1, '', 'fa-cog', '2017-12-28 16:28:08', '2023-05-22 12:43:54', 0),
(2, 'Menu principale', 1, 4, 5, 1, '/modules', 'fa-list-ul', '2017-12-28 16:28:31', '2023-05-22 12:46:10', 0),
(3, 'Profiles', 1, 6, 7, 1, '/roles', 'fa-group', '2017-12-28 16:28:48', '2023-05-22 12:47:03', 0),
(11, 'Groupes', 26, 145, 146, 1, '/groupes', 'fa-check-square-o', '2018-02-12 23:11:35', '2018-02-14 21:00:24', 1),
(26, 'Table de Référence', 1, 2, 3, 1, '/divers', 'fa-folder-open', '2018-02-14 20:59:55', '2023-05-22 12:45:07', 0),
(27, 'Paramétrage', 1, 8, 9, 1, '/parametrestes', 'fa-check-square-o', '2018-02-14 23:48:11', '2023-05-22 12:43:19', 0),
(37, 'Sociétés', 118, 30, 31, 1, '/entreprises', 'fa-building', '2018-03-08 16:40:47', '2023-05-22 12:52:01', 0),
(38, 'Stocks', NULL, 37, 56, 1, '', 'fa-cube', '2018-03-08 21:10:41', '2020-08-28 15:07:48', 0),
(39, 'Gestion des articles', 38, 96, 97, 1, '/earticlesfb', 'fa-check-square-o', '2018-03-08 21:11:21', '2018-03-08 21:11:21', 1),
(40, 'EntrÃ©es/sorties', 38, 46, 59, 1, '/emvtstocksfb', 'fa-check-square-o', '2018-03-10 11:50:14', '2018-03-10 11:53:12', 1),
(42, 'Thème', 1, 22, 23, 1, '/personalisations', 'fa-asterisk', '2018-03-20 10:46:50', '2023-05-22 13:06:24', 0),
(55, 'ParamÃ©trage alerte', 1, 14, 33, 1, '/parametrealerts', 'fa-bell-o', '2019-03-11 23:01:13', '2019-03-11 23:01:13', 1),
(56, 'Utilisateurs', 1, 20, 21, 1, '/administrateurs', 'fa-users', '2019-04-10 00:10:28', '2021-02-24 18:30:33', 0),
(57, 'Clients', 84, 58, 59, 1, '/clients', 'fa-users', '2019-04-10 00:11:15', '2020-06-30 23:53:08', 0),
(58, 'Fournisseurs', 88, 90, 91, 1, '/fournisseurs', 'fa-users', '2019-04-10 18:30:16', '2020-06-30 23:53:40', 0),
(60, 'Ventes', NULL, 159, 164, 1, '', 'fa-usd', '2019-04-10 22:49:01', '2019-04-10 22:49:01', 1),
(61, 'Devis', 60, 160, 161, 1, '/devis', 'fa-check-square-o', '2019-04-10 22:49:23', '2019-04-10 22:49:23', 1),
(65, 'Retour', NULL, 35, 116, 1, '/retours', 'fa-history', '2019-05-03 00:47:19', '2020-02-02 17:41:26', 1),
(66, 'Ventes', NULL, 39, 108, 1, '/ventes', 'fa-usd', '2019-05-04 00:58:23', '2020-06-26 00:01:20', 1),
(67, 'Recettes', 38, 42, 43, 1, '/recettes', 'fa-cutlery', '2019-05-10 22:14:55', '2021-02-28 22:19:55', 0),
(69, 'EntrÃ©es', 38, 58, 59, 1, '/mouvements', 'fa-check-square-o', '2019-05-22 00:05:27', '2019-05-22 00:05:27', 1),
(70, 'Transfert du stock', 38, 46, 59, 1, '/transferts', 'fa-check-square-o', '2019-05-22 00:07:20', '2019-05-22 00:07:20', 1),
(71, 'Banque', NULL, 99, 100, 1, '/avances', 'fa-credit-card', '2019-05-24 22:35:06', '2019-05-24 22:35:06', 0),
(72, 'Sauvegarder la BD', 1, 14, 15, 1, '/backup', 'fa-database', '2019-06-20 02:09:38', '2023-05-22 13:11:05', 0),
(78, 'Prospects', NULL, 65, 74, 1, '/prospects', 'fa-users', '2020-04-08 22:40:30', '2020-04-08 22:40:30', 1),
(84, 'Ventes', NULL, 57, 88, 1, NULL, 'fa-pencil-square-o', '2020-06-26 00:02:07', '2020-06-26 00:12:50', 0),
(85, 'Bon de livraison', 84, 64, 65, 1, '/bonlivraisons', 'fa-pencil-square-o', '2020-06-26 00:02:34', '2020-06-26 00:14:02', 0),
(86, 'Bon de retour', 84, 70, 71, 1, '/bonretours', 'fa-history', '2020-06-26 00:02:53', '2020-07-01 19:07:17', 0),
(87, 'Factures', 84, 74, 75, 1, '/factures', 'fa-file-text-o', '2020-06-26 00:03:40', '2020-07-01 18:15:12', 0),
(88, 'Achats', NULL, 89, 98, 1, '', 'fa-bullhorn', '2020-06-26 00:07:50', '2020-06-26 00:07:50', 0),
(89, 'Bon de commande', 88, 92, 93, 1, '/boncommandes', 'fa-pencil-square-o', '2020-06-26 00:08:11', '2020-07-01 00:52:01', 0),
(90, 'Devis', 84, 60, 61, 1, '/devis', 'fa-file-text-o', '2020-06-27 00:21:09', '2020-06-27 00:21:09', 0),
(91, 'Sessions', 1, 10, 11, 1, '/sessions', 'fa-rss', '2020-07-03 17:32:20', '2020-07-03 17:32:20', 0),
(92, 'DÃ©pence & Charge', NULL, 109, 112, 1, '', 'fa-usd', '2020-07-14 02:58:13', '2021-01-08 01:51:52', 1),
(93, 'Stock', 38, 52, 53, 1, '/monstock', 'fa-cubes', '2020-07-17 14:22:07', '2020-07-28 18:42:36', 0),
(94, 'Réception', 88, 94, 95, 1, '/bonreceptions', 'fa-angle-double-down', '2020-07-24 15:05:04', '2023-05-22 12:54:22', 0),
(95, 'Sortie de stock', 38, 48, 49, 1, '/sortie', 'fa-check-square-o', '2020-07-25 00:47:25', '2020-07-25 00:47:39', 0),
(96, 'Calendrier', NULL, 113, 118, 1, '/calendriers', 'fa-calendar', '2020-07-31 01:04:50', '2020-07-31 01:04:50', 1),
(97, 'Réinitialisation systéme', 1, 12, 13, 1, '/reinitialisation', 'fa-recycle', '2020-08-02 23:55:35', '2023-05-22 12:49:33', 0),
(99, 'Journal du vente', NULL, 103, 108, 1, '', 'fa-area-chart', '2020-09-11 14:28:45', '2020-10-11 22:47:12', 1),
(100, 'Inventaire', 38, 50, 51, 1, '/inventaires', 'fa-cogs', '2020-09-29 12:42:29', '2020-09-29 12:42:29', 0),
(101, 'J.V Par jour', 99, 110, 111, 1, '/journaleventes', 'fa-archive', '2020-10-11 14:24:12', '2020-10-11 22:47:29', 1),
(102, 'J.V pÃ©riodique', 99, 120, 121, 1, '/jounalperiodique', 'fa-usd', '2020-10-11 14:24:45', '2020-10-11 14:24:45', 1),
(103, 'CrÃ©dit', NULL, 123, 128, 1, '', 'fa-usd', '2020-10-11 14:27:58', '2020-10-11 14:27:58', 1),
(104, 'CrÃ©dit clients', 103, 124, 125, 1, '/creditclients', 'fa-usd', '2020-10-11 14:28:21', '2020-10-11 14:28:21', 1),
(105, 'CrÃ©dit fournisseurs', 103, 126, 127, 1, '/creditfournisseurs', 'fa-usd', '2020-10-11 14:28:44', '2020-10-11 14:28:44', 1),
(106, 'Historique des mouvements', 38, 54, 55, 1, '/history', 'fa-history', '2020-10-11 23:49:01', '2020-10-11 23:49:01', 0),
(107, 'Etat vente', NULL, 129, 130, 1, '/etatventes', 'fa-usd', '2020-11-14 17:45:28', '2020-11-14 17:45:28', 1),
(108, 'CatÃ©gorie dÃ©pence', 92, 114, 115, 1, '/categoriedepences', 'fa-cogs', '2021-01-08 01:51:13', '2021-01-08 01:51:13', 1),
(109, 'DÃ©pence', 92, 116, 117, 1, '/depences', 'fa-usd', '2021-01-08 01:51:35', '2021-01-08 01:51:35', 1),
(110, 'Dépôts', 38, 38, 39, 1, '/depots', 'fa-bank', '2021-01-08 12:22:20', '2021-03-05 02:05:34', 0),
(111, 'Transfert', 38, 36, 71, 1, '/transferts', 'fa-history', '2021-01-08 12:36:17', '2021-01-08 12:36:17', 1),
(112, 'Groupes', 1, 16, 17, 1, '/groupes', 'fa-users', '2021-01-19 19:33:50', '2021-01-19 19:33:50', 0),
(113, ' Bon entrée', 38, 44, 45, 1, '/bonentrees', 'fa-arrow-down', '2021-01-22 21:14:22', '2023-05-22 12:53:54', 0),
(114, 'Bon de transfert', 38, 46, 47, 1, '/bontransferts', 'fa-history', '2021-01-22 21:28:54', '2021-01-22 21:28:54', 0),
(115, 'Modèle PDF', 1, 18, 19, 1, '/pdfmodeles', 'fa-file', '2021-02-18 01:12:44', '2023-05-22 12:50:26', 0),
(116, 'Sites', 118, 32, 33, 1, '/stores', 'fa-flag', '2021-02-22 16:11:21', '2021-03-04 23:01:16', 0),
(117, 'Produits', 38, 40, 41, 1, '/ingredients', 'fa-cutlery', '2021-02-28 22:19:01', '2021-02-28 22:19:01', 0),
(118, 'Fichiers', NULL, 29, 36, 1, '', 'fa-cogs', '2021-03-04 22:58:24', '2021-03-04 22:58:24', 0),
(119, 'Retours', 88, 96, 97, 1, '/bonretourachats', 'fa-history', '2021-03-04 23:35:08', '2021-03-04 23:35:08', 0),
(120, 'Point de vente', NULL, 101, 102, 1, '/salepoints', 'fa-usd', '2021-04-30 17:21:50', '2021-04-30 17:21:50', 1),
(121, 'Production', NULL, 103, 108, 1, '', 'fa-flask', '2021-04-30 17:22:17', '2023-05-22 13:10:31', 0),
(122, 'Transformation', 121, 106, 107, 1, '/transformations', 'fa-pencil-square-o', '2021-05-01 02:27:13', '2021-06-16 10:12:45', 0),
(123, 'Vente POS', 84, 72, 73, 1, '/salepoints', 'fa-usd', '2021-05-16 23:57:25', '2021-05-18 15:18:05', 0),
(124, 'Bon de commande', 84, 62, 63, 1, '/commandes', 'fa-pencil-square-o', '2021-05-18 02:02:21', '2021-05-18 02:02:21', 0),
(125, 'Restaurant', NULL, 109, 120, 1, '', 'fa-cutlery', '2021-06-02 20:58:36', '2021-06-08 11:56:11', 0),
(126, 'Vue de la cuisine', 125, 114, 115, 1, '/kitchen', 'fa-list', '2021-06-02 20:59:46', '2021-06-02 20:59:46', 0),
(127, 'Vue du serveur', 125, 116, 117, 1, '/waiter', 'fa-list', '2021-06-02 21:00:20', '2021-06-02 21:00:20', 0),
(128, 'Tables', 125, 112, 113, 1, '/tables', 'fa-list', '2021-06-02 21:09:26', '2021-06-02 21:09:26', 0),
(129, 'Menu du restaurant', 125, 118, 119, 1, '/menu', 'fa-list', '2021-06-02 21:10:10', '2021-06-02 21:10:10', 0),
(130, 'Gestionnaire des caisses', 118, 34, 35, 1, '/caisses', 'fa-dashboard', '2021-06-10 03:25:06', '2021-06-10 03:25:06', 0),
(131, 'Ordre de fabrication', 121, 104, 105, 1, '/productions', 'fa-tags', '2021-06-16 10:13:14', '2023-05-22 13:09:53', 0),
(132, 'E-commerce', 84, 66, 67, 1, '/ecommerces', 'fa-at', '2021-06-16 19:59:21', '2021-06-16 19:59:21', 0),
(133, 'Gestionnaire KDS', 125, 110, 111, 1, '/kitchensystems', 'fa-list', '2021-06-20 20:34:26', '2021-06-20 20:34:26', 0),
(134, 'Compteurs', 1, 7, 8, 1, '/compteurs', 'fa-plus', '2017-12-28 16:28:48', '2023-05-22 12:48:31', 0),
(135, 'Sessions Vente', 84, 73, 62, 1, '/sessionusers', 'fa-usd', '2021-11-11 23:57:25', '2021-11-11 00:00:00', 0),
(136, 'Offline', 1, 21, 22, 1, '/Offline', 'fa-users', '2019-04-10 00:10:28', '2021-02-24 18:30:33', 0),
(137, 'Permission POS\r\n', 1, 21, 22, 1, '/PermissionPOS\r\n', 'fa-users', '2019-04-10 00:10:28', '2021-02-24 18:30:33', 0),
(141, 'Ventes magasin', 84, 76, 77, 1, '/Ventesmagasin/index', 'fa-check-square-o', '2022-02-03 12:55:05', '2022-02-06 17:37:51', 0),
(142, 'Ventes caisse', 84, 78, 79, 1, '/Ventescaisse/index', 'fa-check-square-o', '2022-02-07 13:01:30', '2022-02-08 09:06:43', 0),
(150, 'Permission POS', 1, 22, 23, 1, '/PermissionPos', 'fa-users', '2019-04-10 00:10:28', '2021-02-24 18:30:33', 1),
(210, 'Ventes par ticket', 84, 80, 81, 1, '/ventesticket/index', 'fa-check-square-o', '2022-02-08 13:36:05', '2022-02-09 13:08:09', 0),
(345, 'Ventes magasin comptable', 84, 82, 83, 1, '/Ventesmagasincomptable/index', 'fa-check-square-o', '2022-02-09 13:13:47', '2022-02-09 20:59:03', 0),
(346, 'Ventes caisse comptable', 84, 84, 85, 1, '/Ventescaissecomptable/index', 'fa-check-square-o', '2022-02-09 13:14:35', '2022-02-09 20:59:13', 0),
(347, 'Ventes ticket comptable', 84, 86, 87, 1, '/Ventesticketcomptable/index', 'fa-check-square-o', '2022-02-09 13:15:20', '2022-02-09 20:59:23', 0),
(348, 'Annuler ticket', 123, 75, 76, 1, '', 'fa-check-square-o', '2022-04-19 03:14:16', '2022-04-19 03:14:16', 0),
(349, 'Remise', 124, 63, 64, 1, '', 'fa-check-square-o', '2022-04-19 03:16:49', '2022-04-19 03:16:49', 0),
(350, 'Bon avoirs', 84, 92, 93, 1, '/Bonavoirs', 'fa-check-square-o', '2022-04-19 03:18:09', '2022-04-19 03:18:09', 0),
(351, 'Fidélité', NULL, 80, 87, 1, '', 'fa-check-square-o', '2020-06-26 00:07:50', '2023-05-22 13:08:50', 0),
(352, 'Bon achat', 351, 93, 94, 1, '/bonachats', 'fa-check-square-o', '2022-06-29 15:39:48', '2022-06-29 15:39:48', 0),
(353, 'cheque cadeau', 351, 95, 96, 1, '/Chequecadeaus', 'fa-check-square-o', '2022-06-29 15:40:12', '2022-06-29 15:40:12', 0),
(354, 'Fidelites', 351, 97, 98, 1, '/Fidelites', 'fa-check-square-o', '2022-06-29 15:40:40', '2022-06-29 15:40:40', 0),
(355, 'wallet', 351, 99, 100, 1, '/Wallets', 'fa-check-square-o', '2022-07-01 00:00:00', '0000-00-00 00:00:00', 0),
(356, 'Commandes Glovo', 84, 68, 69, 1, '/Commandeglovos', 'fa-check-square-o', '2022-11-23 14:22:28', '2022-11-23 14:22:28', 0),
(357, 'Configuration', 1, 24, 96, 1, '/Configs', 'fa-cogs', '2023-04-10 20:00:14', '2023-04-10 20:05:35', 0),
(358, 'Synchronisations', 1, 26, 27, 1, '/synchronisations', 'fa-exchange', '2023-04-12 07:17:54', '2023-05-22 13:11:36', 0);

-- --------------------------------------------------------

--
-- Structure de la table `motifplanifications`
--

CREATE TABLE `motifplanifications` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `motifs`
--

CREATE TABLE `motifs` (
  `id` int(11) NOT NULL,
  `barcode` text NOT NULL,
  `motif` text NOT NULL,
  `user_c` int(11) NOT NULL,
  `date_c` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `motifs`
--

INSERT INTO `motifs` (`id`, `barcode`, `motif`, `user_c`, `date_c`) VALUES
(1, '010844', 'injoignable & non disponible', 2, '2022-01-12 19:44:35'),
(2, '010846', 'Erreur de scannage', 2, '2022-01-18 10:37:38'),
(3, '010846', 'Erreur de scannage', 5, '2022-01-18 10:38:03'),
(4, '010846', 'ProblÃ¨me de paiement', 2, '2022-01-18 10:38:26'),
(5, '010846', 'injoignable & non disponible', 2, '2022-01-18 14:38:02'),
(6, '010844', 'ProblÃ¨me de paiement', 2, '2022-01-19 21:40:08'),
(7, '010846', 'injoignable & non disponible', 2, '2022-01-19 21:40:32'),
(8, '5fb14323ae565', 'Erreur de scannage', 2, '2022-01-20 07:13:34'),
(9, '010854', 'Erreur de scannage', 2, '2022-01-20 10:15:18'),
(10, '010854', 'ProblÃ¨me de paiement', 2, '2022-01-20 10:20:57'),
(11, '010846', 'Erreur de scannage', 2, '2022-01-20 10:25:04'),
(12, '010854', 'Erreur de scannage', 2, '2022-01-20 10:29:30'),
(13, '010855', 'Erreur de scannage', 2, '2022-01-20 11:17:51'),
(14, '010856', 'Erreur de scannage', 2, '2022-01-20 12:09:57'),
(15, '010857', 'Erreur de scannage', 2, '2022-01-20 14:06:03'),
(16, '010854', 'Erreur de scannage', 2, '2022-01-20 14:33:59'),
(17, '010854', 'Erreur de scannage', 2, '2022-01-20 14:34:30'),
(18, '010861', 'injoignable & non disponible', 2, '2022-01-20 14:47:40'),
(19, '010863', 'Erreur de scannage', 2, '2022-01-20 15:39:45'),
(20, '010881', 'Erreur de scannage', 11, '2022-01-25 19:05:25'),
(21, '010884', 'changement d\'avis', 11, '2022-01-25 19:23:04'),
(22, '010888', 'Erreur de prÃ©paration', 2, '2022-01-27 21:03:57'),
(23, '010895', 'Erreur de scannage', 2, '2022-01-30 17:07:59'),
(24, '0108104', 'Erreur de prÃ©paration', 2, '2022-01-31 09:36:18'),
(25, '0108112', 'Erreur de scannage', 2, '2022-01-31 11:06:04'),
(26, '0110986', 'changement d\'avis', 2, '2022-12-23 10:57:50'),
(27, '0110986', 'changement d\'avis', 2, '2022-12-23 10:57:51');

-- --------------------------------------------------------

--
-- Structure de la table `motifsabandons`
--

CREATE TABLE `motifsabandons` (
  `id` int(11) NOT NULL,
  `libelle` varchar(100) NOT NULL,
  `user_c` int(11) NOT NULL,
  `date_c` datetime NOT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `motifsabandons`
--

INSERT INTO `motifsabandons` (`id`, `libelle`, `user_c`, `date_c`, `user_u`, `date_u`, `deleted`) VALUES
(1, 'Erreur de scannage', 2, '2021-11-10 14:33:09', 2, '2021-11-15 12:31:36', 0),
(2, 'ProblÃ¨me de paiement', 2, '2021-11-10 14:37:30', 2, '2021-11-15 12:31:22', 0),
(3, 'Erreur de prÃ©paration', 2, '2021-11-15 12:31:52', NULL, NULL, 0),
(4, 'code balance erronÃ©', 2, '2021-11-15 12:32:09', NULL, NULL, 0),
(5, 'changement d\'avis', 2, '2021-11-15 12:32:21', NULL, NULL, 0),
(6, 'injoignable & non disponible', 2, '2021-11-15 12:32:47', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `mouvementprincipals`
--

CREATE TABLE `mouvementprincipals` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL,
  `date_sortie` datetime NOT NULL,
  `depot_source_id` int(11) NOT NULL,
  `depot_destination_id` int(11) DEFAULT NULL,
  `nb_produits` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `valide` int(11) NOT NULL,
  `deleted` int(11) DEFAULT '0',
  `user_c` int(11) NOT NULL,
  `date_c` datetime NOT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `mouvementprincipals`
--

INSERT INTO `mouvementprincipals` (`id`, `reference`, `description`, `date`, `date_sortie`, `depot_source_id`, `depot_destination_id`, `nb_produits`, `type`, `valide`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'S-000001', 'Motifo', '2023-06-10 00:00:00', '2023-06-10 00:00:00', 11, 10, 2, 'Expedition', 1, 0, 1, '2023-06-10 17:20:38', NULL, NULL),
(2, 'S-000002', '2900109005011', '2023-06-10 00:00:00', '2023-06-10 00:00:00', 3, 10, 1, 'Expedition', 1, 0, 1, '2023-06-10 17:24:02', NULL, NULL),
(3, 'S-000003', '2900274000011', '2023-06-10 00:00:00', '2023-06-10 00:00:00', 3, 10, 1, 'Expedition', 1, 0, 1, '2023-06-10 18:06:14', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `mouvements`
--

CREATE TABLE `mouvements` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `num_lot` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `prix_achat` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  `stock_source` decimal(10,3) DEFAULT NULL,
  `paquet_source` int(11) DEFAULT NULL,
  `total_general` int(11) DEFAULT NULL,
  `stock_destination` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `depot_source_id` int(11) DEFAULT NULL,
  `depot_destination_id` int(11) DEFAULT NULL,
  `vente_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `retour_id` int(11) DEFAULT NULL,
  `fournisseur_id` int(11) DEFAULT NULL,
  `operation` int(11) NOT NULL DEFAULT '-1',
  `returned` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mouvements`
--

INSERT INTO `mouvements` (`id`, `reference`, `num_lot`, `description`, `prix_achat`, `date`, `date_sortie`, `stock_source`, `paquet_source`, `total_general`, `stock_destination`, `produit_id`, `client_id`, `depot_source_id`, `depot_destination_id`, `vente_id`, `facture_id`, `retour_id`, `fournisseur_id`, `operation`, `returned`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'MVT-000001', NULL, 'Numéro du bon de sortie : SD-000002', NULL, '2023-06-10', '2023-06-10', '0.501', NULL, NULL, NULL, 7, NULL, 11, 10, NULL, NULL, NULL, NULL, 1, -1, 0, 1, '2023-06-10 17:21:01', NULL, NULL),
(2, 'MVT-000002', NULL, 'Numéro du bon de sortie : SD-000001', NULL, '2023-06-10', '2023-06-10', '0.501', NULL, NULL, NULL, 6, NULL, 11, 10, NULL, NULL, NULL, NULL, 1, -1, 0, 1, '2023-06-10 17:21:01', NULL, NULL),
(3, 'MVT-000003', NULL, NULL, '249.00', '2023-06-10', NULL, '0.201', NULL, NULL, NULL, 7, NULL, 10, NULL, NULL, NULL, NULL, NULL, -1, -1, 0, 1, '2023-06-10 17:52:22', NULL, NULL),
(4, 'MVT-000004', NULL, NULL, '172.00', '2023-06-10', NULL, '0.501', NULL, NULL, NULL, 6, NULL, 10, NULL, NULL, NULL, NULL, NULL, -1, -1, 0, 1, '2023-06-10 17:52:23', NULL, NULL),
(5, 'MVT-000005', '', 'Numéro du bon de sortie : SD-000003', NULL, '2023-06-10', '2023-06-10', '1.801', NULL, NULL, NULL, 6, NULL, 3, 10, NULL, NULL, NULL, NULL, 1, -1, 0, 1, '2023-06-10 18:00:43', NULL, NULL),
(6, 'MVT-000006', NULL, NULL, '172.00', '2023-06-10', NULL, '3.801', NULL, NULL, NULL, 6, NULL, 10, NULL, NULL, NULL, NULL, NULL, -1, -1, 0, 1, '2023-06-10 18:02:22', NULL, NULL),
(7, 'MVT-000007', NULL, 'Numéro du bon de sortie : SD-000004', NULL, '2023-06-10', '2023-06-10', '1.000', NULL, NULL, NULL, 115, NULL, 3, 10, NULL, NULL, NULL, NULL, 1, -1, 0, 1, '2023-06-10 18:06:20', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `privee` int(11) NOT NULL DEFAULT '0',
  `read` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `notifications_users`
--

CREATE TABLE `notifications_users` (
  `id` int(11) NOT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `notifications_vues`
--

CREATE TABLE `notifications_vues` (
  `id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `societe_id` int(11) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `objectifclients`
--

CREATE TABLE `objectifclients` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `annee` int(11) DEFAULT NULL,
  `objectif` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `objectifs`
--

CREATE TABLE `objectifs` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `dated` date DEFAULT NULL,
  `datef` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_jrs_travail` decimal(10,2) DEFAULT NULL,
  `c_a_mensuel` decimal(10,2) DEFAULT NULL,
  `visite_mensuel` decimal(10,2) DEFAULT NULL,
  `nbr_livraision` decimal(10,2) DEFAULT NULL,
  `taux` decimal(10,2) DEFAULT NULL,
  `c_a_moyen` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `offlines`
--

CREATE TABLE `offlines` (
  `id` int(11) NOT NULL,
  `caisse_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `societe_id` int(11) NOT NULL,
  `date_sync` int(11) NOT NULL,
  `user_c` int(11) NOT NULL,
  `date_c` int(11) NOT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `optionproduits`
--

CREATE TABLE `optionproduits` (
  `id` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `id_option` int(11) NOT NULL,
  `user_c` int(11) NOT NULL,
  `date_c` datetime NOT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `options`
--

CREATE TABLE `options` (
  `id` int(255) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `options`
--

INSERT INTO `options` (`id`, `libelle`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(4, 'epice-beldia', 0, 2, '2021-11-25 14:20:10', NULL, NULL),
(3, 'entier-four', 0, 2, '2021-11-25 14:20:10', NULL, NULL),
(2, 'emince', 0, 2, '2021-11-25 14:20:10', NULL, NULL),
(1, 'Brochettes', 0, 2, '2021-11-25 14:34:35', NULL, NULL),
(5, 'epice-grill', 0, 2, '2021-11-25 14:20:10', NULL, NULL),
(6, 'escalope', 0, 2, '2021-11-25 14:20:10', NULL, NULL),
(7, 'nature', 0, 2, '2021-11-25 14:20:10', NULL, NULL),
(8, 'roti', 0, 2, '2021-11-25 14:20:10', NULL, NULL),
(9, 'steak', 0, 2, '2021-11-25 14:20:10', NULL, NULL),
(10, 'tajine', 0, 2, '2021-11-25 14:20:10', NULL, NULL),
(11, 'hachÃ©', 0, 2, '2021-11-26 08:10:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `paiement_wallets`
--

CREATE TABLE `paiement_wallets` (
  `id` int(11) NOT NULL,
  `reference` text,
  `mode` text,
  `montant` float DEFAULT NULL,
  `num_cheque` text,
  `wallet_id` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_c` int(11) DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `parametrealerts`
--

CREATE TABLE `parametrealerts` (
  `id` int(11) NOT NULL,
  `groupe_id` int(11) DEFAULT NULL,
  `email_check` int(11) DEFAULT NULL,
  `parent_check` int(11) DEFAULT NULL,
  `periodicite` int(11) DEFAULT NULL,
  `date_declenchement` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `parametrestes`
--

CREATE TABLE `parametrestes` (
  `id` int(11) NOT NULL,
  `key` varchar(50) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `societe_id` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `parametrestes`
--

INSERT INTO `parametrestes` (`id`, `key`, `value`, `deleted`, `societe_id`) VALUES
(1, 'Email_all', '-1', 0, 1),
(2, 'SMTP_host', 'test', 0, 1),
(3, 'SMTP_port', 'test', 0, 1),
(4, 'SMTP_username', 'test', 0, 1),
(5, 'SMTP_password', 'test', 0, 1),
(6, 'SMTP_auth', 'test', 0, 1),
(7, 'SMTP_from', 'test', 0, 1),
(8, 'Alert_duree', '3', 0, 1),
(9, 'Alert_groupe', '1', 0, 1),
(10, 'cb_identifiant', '2900', 0, 1),
(11, 'cb_produit_depart', '4', 0, 1),
(12, 'cb_produit_longeur', '3', 0, 1),
(13, 'cb_quantite_depart', '7', 0, 1),
(14, 'cb_quantite_longeur', '5', 0, 1),
(15, 'cb_div_kg', '1000', 0, 1),
(16, 'Api pending', 'https://api.lafonda.info/rest/fnd/v1/orders/pending', 0, 1),
(17, 'Api update pos', 'https://api.lafonda.info/rest/fnd/v1/orders/update', 0, 1),
(18, 'Api annulation partielle', 'https://api.lafonda.info/rest/fnd/v1/orders/partial-update', 0, 1),
(19, 'Api Abondan total', 'https://api.lafonda.info/rest/fnd/v1/orders/cancel', 0, 1),
(20, 'User', 'restapi', 0, 1),
(21, 'Password', 'eb9x ULdV Gzav PsI4 o5D9 nRgt', 0, 1),
(22, 'Api sync produits', 'https://api.lafonda.info/rest/fnd/v1/products/sync', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE `pays` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id`, `libelle`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'Maroc', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `pdfmodeles`
--

CREATE TABLE `pdfmodeles` (
  `id` int(11) NOT NULL,
  `libelle` varchar(250) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `pdfmodeles`
--

INSERT INTO `pdfmodeles` (`id`, `libelle`, `image`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'ModÃ©le PDF 1', 'modele_cache2.jpg', 0, 1, '2021-02-18 01:21:17', 2, '2021-04-01 10:54:50'),
(2, 'ModÃ¨le PDF 2', 'modele3.jpg', 0, 2, '2021-04-01 10:54:44', NULL, NULL),
(3, 'ModÃ¨le PDF 3', 'modele1_cache.jpg', 0, 2, '2021-04-01 10:55:59', NULL, NULL);

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
(8, 1, 39, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-01-08 00:19:22', 0),
(9, 1, 40, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-01-08 00:19:22', 0),
(10, 1, 59, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-01-08 00:19:22', 0),
(12, 1, 68, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-01-08 00:19:22', 0),
(52, 1, 70, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-24 22:20:19', 0),
(53, 1, 73, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-25 02:06:09', 0),
(54, 1, 77, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-25 02:06:25', 0),
(55, 1, 79, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-25 02:06:35', 0),
(56, 1, 80, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-25 02:06:43', 0),
(57, 1, 83, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-25 02:07:05', 0),
(58, 1, 81, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-25 02:07:41', 0),
(59, 1, 76, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-25 02:08:01', 0),
(60, 3, 42, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-06-25 23:26:26', 0),
(61, 1, 60, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-06-25 23:55:47', 0),
(62, 1, 61, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-06-25 23:55:47', 0),
(63, 1, 62, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-06-25 23:55:47', 0),
(80, 2, 70, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-30 23:44:51', 0),
(93, 1, 63, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-30 23:46:51', 0),
(94, 1, 65, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-30 23:46:59', 0),
(95, 1, 66, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-30 23:47:08', 0),
(96, 1, 74, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-30 23:47:31', 0),
(97, 1, 75, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-30 23:47:38', 0),
(98, 1, 78, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-06-30 23:47:49', 0),
(103, 1, 71, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-07-01 16:37:51', 0),
(105, 1, 82, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-07-01 20:10:09', 0),
(126, 4, 69, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-07-08 07:06:28', 0),
(127, 4, 1, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-07-08 07:09:47', 0),
(174, 4, 82, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-20 16:11:11', 0),
(176, 2, 98, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-08-20 17:07:44', 0),
(178, 1, 98, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-08-20 17:08:00', 0),
(180, 5, 88, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-20 17:11:15', 0),
(181, 5, 88, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-20 17:11:15', 0),
(182, 5, 38, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-20 17:11:15', 0),
(183, 5, 67, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-20 17:11:15', 0),
(184, 5, 69, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-20 17:11:15', 0),
(185, 5, 42, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-08-20 17:11:15', 0),
(186, 5, 88, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-20 17:11:15', 0),
(187, 5, 89, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-20 17:11:15', 0),
(188, 5, 94, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-20 17:11:15', 0),
(189, 5, 58, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-20 17:11:15', 0),
(190, 5, 84, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, '2020-08-20 17:11:15', 0),
(191, 5, 90, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, '2020-08-20 17:11:15', 0),
(192, 5, 85, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, '2020-08-20 17:11:15', 0),
(193, 5, 87, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, '2020-08-20 17:11:15', 0),
(194, 5, 86, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-20 17:11:15', 0),
(195, 5, 82, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-20 17:11:15', 0),
(196, 5, 57, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-08-20 17:11:15', 0),
(212, 1, 99, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-10-11 14:25:17', 0),
(213, 1, 101, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-10-11 14:25:17', 0),
(214, 1, 102, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-10-11 14:25:17', 0),
(215, 1, 103, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-10-11 14:29:07', 0),
(216, 1, 104, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-10-11 14:29:07', 0),
(217, 1, 105, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-10-11 14:29:07', 0),
(230, 2, 103, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-02-18 00:25:05', 0),
(231, 2, 103, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-02-18 00:25:05', 0),
(262, 2, 82, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-10-24 17:49:23', 0),
(270, 2, 99, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-02-18 00:24:53', 0),
(271, 2, 99, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-02-18 00:24:53', 0),
(280, 1, 107, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2020-11-14 17:46:08', 0),
(295, 2, 92, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2021-01-08 01:52:19', 0),
(296, 2, 108, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2021-01-08 01:52:19', 0),
(297, 2, 109, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2021-01-08 01:52:19', 0),
(298, 1, 92, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2021-01-08 01:52:25', 0),
(299, 1, 108, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2021-01-08 01:52:25', 0),
(300, 1, 109, 1, 1, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 0, '2021-01-08 01:52:25', 0),
(416, 2, 99, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-02-18 00:24:53', 0),
(417, 2, 101, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-02-18 00:24:53', 0),
(418, 2, 102, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-02-18 00:24:53', 0),
(419, 2, 103, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-02-18 00:25:05', 0),
(420, 2, 104, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-02-18 00:25:05', 0),
(421, 2, 105, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-02-18 00:25:05', 0),
(422, 2, 107, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-02-18 00:25:14', 0),
(472, 2, 96, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-02-18 00:44:19', 0),
(480, 1, 96, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-02-26 23:38:54', 0),
(481, 2, 38, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:23', 0),
(482, 2, 110, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:23', 0),
(484, 2, 67, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:23', 0),
(485, 2, 69, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:23', 0),
(486, 2, 93, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:23', 0),
(487, 2, 95, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:23', 0),
(488, 2, 100, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:23', 0),
(489, 2, 106, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:23', 0),
(490, 2, 111, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:23', 0),
(491, 2, 113, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:23', 0),
(492, 2, 114, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:23', 0),
(493, 1, 38, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:39', 0),
(494, 1, 110, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:39', 0),
(495, 1, 117, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:39', 0),
(496, 1, 67, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:39', 0),
(497, 1, 69, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:39', 0),
(498, 1, 93, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:39', 0),
(499, 1, 95, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:39', 0),
(500, 1, 100, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:39', 0),
(501, 1, 106, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:39', 0),
(502, 1, 111, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:39', 0),
(503, 1, 113, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:39', 0),
(504, 1, 114, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:39', 0),
(558, 2, 88, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-03-05 02:06:50', 0),
(559, 2, 58, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-03-05 02:06:50', 0),
(560, 2, 89, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-03-05 02:06:50', 0),
(561, 2, 94, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-03-05 02:06:50', 0),
(562, 2, 119, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-03-05 02:06:50', 0),
(565, 1, 88, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-03-05 02:07:38', 0),
(566, 1, 58, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-03-05 02:07:38', 0),
(567, 1, 89, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-03-05 02:07:38', 0),
(568, 1, 94, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-03-05 02:07:38', 0),
(569, 1, 119, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-03-05 02:07:38', 0),
(571, 2, 120, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-04-30 17:28:35', 0),
(574, 1, 120, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-04-30 17:29:28', 0),
(603, 1, 118, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-10 03:25:20', 0),
(604, 1, 37, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-10 03:25:20', 0),
(605, 1, 116, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-10 03:25:20', 0),
(606, 1, 130, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-10 03:25:20', 0),
(611, 1, 121, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-16 10:13:28', 0),
(612, 1, 122, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-16 10:13:28', 0),
(613, 1, 131, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-16 10:13:28', 0),
(614, 2, 121, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-16 10:13:51', 0),
(615, 2, 122, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-16 10:13:51', 0),
(616, 2, 131, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-16 10:13:51', 0),
(619, 1, 123, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-16 19:59:32', 0),
(620, 1, 124, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-16 19:59:32', 0),
(628, 2, 123, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-16 19:59:42', 0),
(635, 1, 125, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-20 20:35:07', 0),
(636, 1, 133, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-20 20:35:07', 0),
(637, 1, 126, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-20 20:35:07', 0),
(638, 1, 127, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-20 20:35:07', 0),
(639, 1, 128, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-20 20:35:07', 0),
(640, 1, 129, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-06-20 20:35:07', 0),
(642, 2, 125, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-12-09 09:24:17', 0),
(643, 2, 125, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-12-09 09:24:17', 0),
(644, 2, 125, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-12-09 09:24:17', 0),
(645, 2, 125, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-12-09 09:24:17', 0),
(646, 2, 125, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-12-09 09:24:17', 0),
(649, 5, 118, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-07 10:44:28', 0),
(651, 5, 130, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2021-12-07 11:43:46', 0),
(652, 6, 38, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '2021-12-27 13:19:08', 0),
(653, 6, 110, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '2021-12-27 13:19:08', 0),
(654, 6, 117, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '2021-12-27 13:19:08', 0),
(655, 6, 67, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '2021-12-27 13:19:08', 0),
(656, 6, 93, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-27 13:19:08', 0),
(657, 6, 95, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-27 13:19:08', 0),
(658, 6, 100, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-27 13:19:08', 0),
(659, 6, 106, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-27 13:19:08', 0),
(660, 6, 113, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-27 13:19:08', 0),
(661, 6, 114, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-27 13:19:08', 0),
(664, 6, 123, 1, 1, 1, 1, 0, 0, 0, 1, 0, 0, 1, 1, 0, '2021-12-27 13:20:36', 0),
(666, 6, 124, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-27 13:20:36', 0),
(672, 6, 88, 1, 1, 1, 0, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-27 13:21:20', 0),
(673, 6, 58, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '2021-12-27 13:21:20', 0),
(674, 6, 89, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-27 13:21:20', 0),
(675, 6, 94, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-27 13:21:20', 0),
(676, 6, 119, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-27 13:21:20', 0),
(677, 6, 121, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-27 13:21:45', 0),
(678, 6, 131, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-27 13:21:45', 0),
(679, 6, 122, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-12-27 13:21:45', 0),
(680, 2, 139, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2020-01-08 00:19:22', 0),
(681, 9, 118, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2022-01-31 15:53:16', 0),
(685, 9, 84, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, '2022-01-31 16:18:14', 0),
(686, 9, 57, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-01-31 16:18:14', 0),
(687, 9, 123, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-01-31 16:18:14', 0),
(688, 9, 135, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-01-31 16:18:14', 0),
(689, 9, 124, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-01-31 16:18:14', 0),
(690, 9, 90, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-01-31 16:18:14', 0),
(691, 9, 85, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-01-31 16:18:14', 0),
(692, 9, 87, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-01-31 16:18:14', 0),
(693, 9, 86, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-01-31 16:18:14', 0),
(694, 9, 132, 1, 1, 0, 1, 0, 0, 0, 1, 1, 0, 1, 0, 0, '2022-01-31 16:18:14', 0),
(695, 9, 130, 1, 1, 1, 1, 0, 0, 0, 1, 0, 0, 1, 1, 0, '2022-01-31 16:19:12', 0),
(727, 10, 121, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:44', 0),
(728, 10, 121, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:44', 0),
(729, 11, 38, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '2022-02-01 22:20:57', 0),
(730, 11, 110, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '2022-02-01 22:20:57', 0),
(731, 11, 117, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '2022-02-01 22:20:57', 0),
(732, 11, 67, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '2022-02-01 22:20:57', 0),
(733, 11, 93, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(734, 11, 95, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(735, 11, 100, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(736, 11, 106, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(737, 11, 113, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(738, 11, 114, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(739, 11, 84, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(740, 11, 57, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(741, 11, 123, 1, 1, 1, 1, 0, 0, 0, 1, 0, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(742, 11, 135, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(743, 11, 124, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(744, 11, 90, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(745, 11, 85, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(746, 11, 87, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(747, 11, 86, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(748, 11, 132, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(749, 11, 88, 1, 1, 1, 0, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(750, 11, 58, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '2022-02-01 22:20:57', 0),
(751, 11, 89, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(752, 11, 94, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(753, 11, 119, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(754, 11, 121, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(755, 11, 131, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(756, 11, 122, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-02-01 22:20:57', 0),
(805, 6, 118, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-02-11 09:07:31', 0),
(806, 6, 37, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-02-11 09:07:31', 0),
(807, 6, 116, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-02-11 09:07:31', 0),
(808, 6, 130, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-02-11 09:07:31', 0),
(809, 9, 38, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2022-03-09 10:16:28', 0),
(814, 9, 117, 1, 1, 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2022-03-09 10:17:12', 0),
(819, 2, 118, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-03-15 15:34:57', 0),
(820, 2, 37, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-03-15 15:34:57', 0),
(821, 2, 116, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-03-15 15:34:57', 0),
(823, 2, 130, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-05-30 17:35:00', 0),
(828, 2, 348, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:03:58', 0),
(836, 2, 84, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:00', 0),
(837, 2, 57, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:00', 0),
(838, 2, 90, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:00', 0),
(839, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2022-06-30 14:19:00', 0),
(840, 2, 85, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:01', 0),
(841, 2, 132, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:01', 0),
(842, 2, 86, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:01', 0),
(843, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2022-06-30 14:19:01', 0),
(844, 2, 135, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:01', 0),
(845, 2, 87, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:01', 0),
(846, 2, 141, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:01', 0),
(847, 2, 142, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:01', 0),
(848, 2, 210, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:01', 0),
(849, 2, 345, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:01', 0),
(850, 2, 346, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:01', 0),
(851, 2, 347, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:01', 0),
(852, 2, 350, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:01', 0),
(853, 2, 124, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:23', 0),
(854, 2, 349, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:19:23', 0),
(871, 2, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:20:34', 0),
(872, 2, 26, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:20:34', 0),
(873, 2, 2, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:20:34', 0),
(874, 2, 3, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:20:34', 0),
(875, 2, 134, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:20:34', 0),
(876, 2, 27, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:20:34', 0),
(877, 2, 91, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:20:34', 0),
(878, 2, 97, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:20:34', 0),
(879, 2, 72, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:20:34', 0),
(880, 2, 112, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:20:34', 0),
(881, 2, 115, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:20:34', 0),
(882, 2, 56, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:20:35', 0),
(883, 2, 136, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:20:35', 0),
(884, 2, 137, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:20:35', 0),
(885, 2, 42, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:20:35', 0),
(886, 2, 150, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:20:35', 0),
(887, 1, 351, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:21:25', 0),
(888, 1, 352, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:21:25', 0),
(889, 1, 353, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:21:25', 0),
(890, 1, 354, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:21:25', 0),
(907, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(908, 1, 26, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(909, 1, 2, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(910, 1, 3, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(911, 1, 134, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(912, 1, 27, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(913, 1, 91, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(914, 1, 97, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(915, 1, 72, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(916, 1, 112, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(917, 1, 115, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(918, 1, 56, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(919, 1, 136, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(920, 1, 137, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(921, 1, 42, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(922, 1, 150, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:18', 0),
(923, 1, 84, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(924, 1, 57, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(925, 1, 90, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(926, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2022-06-30 14:23:58', 0),
(927, 1, 85, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(928, 1, 132, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(929, 1, 86, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(930, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2022-06-30 14:23:58', 0),
(931, 1, 135, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(932, 1, 87, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(933, 1, 141, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(934, 1, 142, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(935, 1, 210, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(936, 1, 345, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(937, 1, 346, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(938, 1, 347, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(939, 1, 350, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-06-30 14:23:58', 0),
(943, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2022-06-30 14:26:31', 0),
(947, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2022-06-30 14:26:31', 0),
(960, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2022-06-30 14:27:25', 0),
(964, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2022-06-30 14:27:25', 0),
(974, 6, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(975, 6, 26, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(976, 6, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(977, 6, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(978, 6, 134, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(979, 6, 27, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(980, 6, 91, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(981, 6, 97, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(982, 6, 72, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(983, 6, 112, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(984, 6, 115, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(985, 6, 56, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(986, 6, 136, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(987, 6, 137, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(988, 6, 42, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(989, 6, 150, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-06-30 14:27:42', 0),
(993, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2022-06-30 14:57:59', 0),
(997, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2022-06-30 14:57:59', 0),
(1008, 2, 71, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-07-13 12:25:17', 0),
(1009, 2, 351, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-07-13 12:26:07', 0),
(1010, 2, 352, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-07-13 12:26:07', 0),
(1011, 2, 353, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-07-13 12:26:07', 0),
(1012, 2, 354, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-07-13 12:26:07', 0),
(1013, 2, 355, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-07-13 12:26:07', 0),
(1014, 2, 356, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2022-11-23 14:24:51', 0),
(1015, 2, 125, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-12-09 09:24:17', 0),
(1016, 2, 133, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-12-09 09:24:17', 0),
(1017, 2, 128, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-12-09 09:24:17', 0),
(1018, 2, 126, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-12-09 09:24:17', 0),
(1019, 2, 127, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-12-09 09:24:17', 0),
(1020, 2, 129, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2022-12-09 09:24:17', 0),
(1038, 6, 84, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-12 09:35:25', 0),
(1039, 6, 57, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, '2023-01-12 09:35:25', 0),
(1040, 6, 90, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-12 09:35:26', 0),
(1041, 6, 85, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-12 09:35:26', 0),
(1042, 6, 132, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, '2023-01-12 09:35:26', 0),
(1043, 6, 356, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, '2023-01-12 09:35:26', 0),
(1044, 6, 86, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-12 09:35:26', 0),
(1045, 6, 135, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-12 09:35:26', 0),
(1046, 6, 87, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-12 09:35:26', 0),
(1047, 6, 141, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-12 09:35:26', 0),
(1048, 6, 142, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-12 09:35:26', 0),
(1049, 6, 210, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-12 09:35:26', 0),
(1050, 6, 345, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-12 09:35:26', 0),
(1051, 6, 346, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-12 09:35:26', 0),
(1052, 6, 347, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-12 09:35:26', 0),
(1053, 6, 350, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 0, 0, '2023-01-12 09:35:26', 0),
(1122, 4, 123, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 14:49:23', 0),
(1123, 4, 348, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 14:49:23', 0),
(1204, 4, 118, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:11:22', 0),
(1205, 4, 37, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:11:22', 0),
(1206, 4, 116, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:11:22', 0),
(1207, 4, 130, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:11:22', 0),
(1208, 4, 38, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:26', 0),
(1209, 4, 110, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:26', 0),
(1210, 4, 117, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:26', 0),
(1211, 4, 67, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:26', 0),
(1212, 4, 113, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:26', 0),
(1213, 4, 114, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:26', 0),
(1214, 4, 95, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:26', 0),
(1215, 4, 100, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:26', 0),
(1216, 4, 93, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:26', 0),
(1217, 4, 106, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:26', 0),
(1218, 4, 84, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:40', 0),
(1219, 4, 57, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:40', 0),
(1220, 4, 90, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:40', 0),
(1221, 4, 85, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:40', 0),
(1222, 4, 132, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:40', 0),
(1223, 4, 356, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:40', 0),
(1224, 4, 86, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:40', 0),
(1225, 4, 135, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:40', 0),
(1226, 4, 87, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:40', 0),
(1227, 4, 141, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:41', 0),
(1228, 4, 142, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:41', 0),
(1229, 4, 210, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:41', 0),
(1230, 4, 345, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:41', 0),
(1231, 4, 346, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:41', 0),
(1232, 4, 347, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:41', 0),
(1233, 4, 350, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:12:41', 0),
(1239, 4, 88, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:13:09', 0),
(1240, 4, 58, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:13:09', 0),
(1241, 4, 89, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:13:09', 0),
(1242, 4, 94, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:13:09', 0),
(1243, 4, 119, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:13:09', 0),
(1324, 10, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1325, 10, 26, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1326, 10, 2, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1327, 10, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1328, 10, 134, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1329, 10, 27, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1330, 10, 91, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1331, 10, 97, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1332, 10, 72, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1333, 10, 112, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1334, 10, 115, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1335, 10, 56, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1336, 10, 136, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1337, 10, 137, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1338, 10, 42, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:12', 0),
(1343, 10, 118, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:20:56', 0),
(1344, 10, 37, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:56', 0),
(1345, 10, 116, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:20:56', 0),
(1346, 10, 130, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, '2023-01-25 15:20:56', 0),
(1357, 10, 38, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:04', 0),
(1358, 10, 110, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:04', 0),
(1359, 10, 117, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:04', 0),
(1360, 10, 67, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:04', 0),
(1361, 10, 113, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:04', 0),
(1362, 10, 114, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:04', 0),
(1363, 10, 95, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:04', 0),
(1364, 10, 100, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:04', 0),
(1365, 10, 93, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:04', 0),
(1366, 10, 106, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:04', 0),
(1367, 10, 121, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:44', 0),
(1368, 10, 131, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:44', 0),
(1369, 10, 122, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:22:44', 0),
(1375, 10, 88, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:23:36', 0),
(1376, 10, 58, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:23:36', 0),
(1377, 10, 89, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:23:36', 0),
(1378, 10, 94, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:23:36', 0),
(1379, 10, 119, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:23:36', 0),
(1396, 10, 124, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:26:36', 0),
(1397, 10, 349, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:26:36', 0),
(1398, 10, 84, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-01-25 15:26:53', 0),
(1399, 10, 57, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:26:53', 0),
(1400, 10, 90, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2023-01-25 15:26:53', 0),
(1401, 10, 85, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:26:53', 0),
(1402, 10, 132, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, '2023-01-25 15:26:53', 0),
(1403, 10, 356, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, '2023-01-25 15:26:53', 0),
(1404, 10, 86, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:26:53', 0),
(1405, 10, 135, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:26:53', 0),
(1406, 10, 87, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2023-01-25 15:26:53', 0),
(1407, 10, 141, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:26:53', 0),
(1408, 10, 142, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:26:53', 0),
(1409, 10, 210, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:26:53', 0),
(1410, 10, 345, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:26:53', 0),
(1411, 10, 346, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:26:53', 0),
(1412, 10, 347, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:26:53', 0),
(1413, 10, 350, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:26:53', 0),
(1414, 10, 123, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, '2023-01-25 15:27:07', 0),
(1415, 10, 348, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-01-25 15:27:07', 0),
(1416, 8, 39, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-01-08 00:19:22', 0),
(1417, 2, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:01:35', 0),
(1419, 1, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:07:38', 0),
(1421, 1, 358, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-04-12 07:30:07', 0),
(1438, 8, 38, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2020-01-08 00:19:22', 0),
(1439, 4, 130, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 0, '2022-05-30 17:35:00', 0),
(1440, 4, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:07:38', 0),
(1441, 6, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:07:38', 0),
(1442, 8, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:07:38', 0),
(1443, 9, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:07:38', 0),
(1444, 10, 357, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 1, '2023-04-10 20:07:38', 0),
(1445, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-04-26 10:55:05', 0),
(1446, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-04-26 10:56:23', 0),
(1448, 2, 117, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2023-05-22 11:55:06', 0);

-- --------------------------------------------------------

--
-- Structure de la table `permissionpos`
--

CREATE TABLE `permissionpos` (
  `id` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `permission` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `permissionpos`
--

INSERT INTO `permissionpos` (`id`, `nom`, `permission`, `role_id`, `deleted`) VALUES
(36, 'Remise', 1, 2, 0),
(37, 'Remise ticket', 1, 2, 0),
(38, 'Offert', 1, 2, 0),
(39, 'Annuler ticket', 1, 2, 0),
(40, 'Cloture caisse', 1, 2, 0),
(41, 'Activation cheque cadeau', 1, 2, 0),
(42, 'Activation bon d\'achat', 1, 2, 0),
(43, 'Activation carte client', 1, 2, 0),
(44, 'Correction mode paiement', 1, 2, 0),
(45, 'Retour produit', 1, 2, 0),
(46, 'Reimpression facture ou ticket', 1, 2, 0),
(47, 'Remise', 1, 6, 0),
(48, 'Remise ticket', 1, 6, 0),
(49, 'Offert', 1, 6, 0),
(50, 'Annuler ticket', 1, 6, 0),
(51, 'Cloture caisse', 1, 6, 0),
(52, 'Activation cheque cadeau', 1, 6, 0),
(53, 'Activation bon d\'achat', 1, 6, 0),
(54, 'Activation carte client', 1, 6, 0),
(55, 'Correction mode paiement', 1, 6, 0),
(56, 'Retour produit', 1, 6, 0),
(57, 'Reimpression facture ou ticket', 1, 6, 0),
(58, 'Remise', 0, 9, 0),
(59, 'Remise ticket', 0, 9, 0),
(60, 'Offert', 0, 9, 0),
(61, 'Annuler ticket', 1, 9, 0),
(62, 'Cloture caisse', 0, 9, 0),
(63, 'Activation cheque cadeau', 0, 9, 0),
(64, 'Activation bon d\'achat', 0, 9, 0),
(65, 'Activation carte client', 0, 9, 0),
(66, 'Correction mode paiement', 0, 9, 0),
(67, 'Retour produit', 0, 9, 0),
(68, 'Reimpression facture ou ticket', 0, 9, 0),
(69, 'Remise', 0, 10, 0),
(70, 'Remise ticket', 0, 10, 0),
(71, 'Offert', 0, 10, 0),
(72, 'Annuler ticket', 1, 10, 0),
(73, 'Cloture caisse', 0, 10, 0),
(74, 'Activation cheque cadeau', 0, 10, 0),
(75, 'Activation bon d\'achat', 0, 10, 0),
(76, 'Activation carte client', 0, 10, 0),
(77, 'Correction mode paiement', 0, 10, 0),
(78, 'Retour produit', 0, 10, 0),
(79, 'Reimpression facture ou ticket', 0, 10, 0),
(80, 'Offert', 1, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `personalisations`
--

CREATE TABLE `personalisations` (
  `id` int(11) NOT NULL,
  `color_theme` varchar(255) DEFAULT 'default.css',
  `header_type` varchar(255) DEFAULT NULL,
  `footer_type` varchar(255) DEFAULT NULL,
  `sidebar_type` varchar(255) DEFAULT NULL,
  `sidebar_position` varchar(255) DEFAULT NULL,
  `sidebar_style` varchar(255) DEFAULT NULL,
  `layout` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `pieces`
--

CREATE TABLE `pieces` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `extention` varchar(50) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `devi_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `bonlivraison_id` int(11) DEFAULT NULL,
  `vente_id` int(11) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `user_c` int(1) DEFAULT NULL,
  `user_u` int(1) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `planifications`
--

CREATE TABLE `planifications` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `motifplanification_id` int(11) DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `statut` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `productiondetails`
--

CREATE TABLE `productiondetails` (
  `id` int(11) NOT NULL,
  `production_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `quantite_reel` decimal(10,3) NOT NULL DEFAULT '0.000',
  `quantite_theo` decimal(10,3) NOT NULL DEFAULT '0.000',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `done` int(11) NOT NULL DEFAULT '-1',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `productions`
--

CREATE TABLE `productions` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `quantite` decimal(10,3) DEFAULT NULL,
  `prix_theo` float DEFAULT NULL,
  `quantite_prod` float DEFAULT NULL,
  `prix_prod` float DEFAULT NULL,
  `date` date DEFAULT NULL,
  `statut` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produitingredients`
--

CREATE TABLE `produitingredients` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `ingredient_id` int(11) DEFAULT NULL,
  `quantite` decimal(10,2) DEFAULT NULL,
  `prix_achat` decimal(10,2) DEFAULT NULL,
  `pourcentage_perte` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `produitprices`
--

CREATE TABLE `produitprices` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `prix_achat` decimal(10,2) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `societe_id` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `fournisseur_id` int(11) DEFAULT NULL,
  `categorieclient_id` int(11) DEFAULT NULL,
  `tva` int(11) DEFAULT NULL,
  `default_frs` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default.jpg',
  `code_barre` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `prixachat` decimal(10,2) DEFAULT NULL,
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `pourcentage_perte` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pmp` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cout_achat` decimal(10,2) NOT NULL DEFAULT '0.00',
  `active` int(11) DEFAULT '1',
  `type` int(11) DEFAULT '1',
  `display_on` int(11) DEFAULT '1',
  `categorieproduit_id` int(11) DEFAULT NULL,
  `souscategorieproduit_id` int(11) DEFAULT NULL,
  `unite_id` int(11) DEFAULT NULL,
  `stockactuel` float NOT NULL DEFAULT '0',
  `stock_min` int(11) DEFAULT '10',
  `tva_achat` int(11) NOT NULL DEFAULT '20',
  `tva_vente` int(11) NOT NULL DEFAULT '20',
  `cpt_achat` varchar(255) NOT NULL,
  `cpt_vente` varchar(255) NOT NULL,
  `cpt_stock` varchar(255) NOT NULL,
  `pese` varchar(255) NOT NULL,
  `type_of` varchar(255) NOT NULL,
  `type_conditionnement` varchar(255) NOT NULL,
  `options` varchar(255) NOT NULL,
  `conditionnement` decimal(5,3) DEFAULT NULL,
  `num_lot` tinyint(1) DEFAULT NULL,
  `poids` float DEFAULT NULL,
  `volume` float DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `dlc_jours` int(11) DEFAULT NULL,
  `dlc_annees` int(11) DEFAULT NULL,
  `dlc_mois` int(11) DEFAULT NULL,
  `dlc_heures` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `reference`, `libelle`, `description`, `image`, `code_barre`, `date`, `prixachat`, `prix_vente`, `pourcentage_perte`, `pmp`, `cout_achat`, `active`, `type`, `display_on`, `categorieproduit_id`, `souscategorieproduit_id`, `unite_id`, `stockactuel`, `stock_min`, `tva_achat`, `tva_vente`, `cpt_achat`, `cpt_vente`, `cpt_stock`, `pese`, `type_of`, `type_conditionnement`, `options`, `conditionnement`, `num_lot`, `poids`, `volume`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`, `dlc_jours`, `dlc_annees`, `dlc_mois`, `dlc_heures`) VALUES
(1, 'PROD-000001', 'GESIER S/PRODUIT', NULL, 'default.jpg', '010', '2022-02-01', '3.00', '3.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'PROD-000002', 'FOIE POULET S/PRODUIT', NULL, 'default.jpg', '011', '2022-02-01', '6.00', '6.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'PROD-000003', 'CARCASSE PLT S/PRODUIT', NULL, 'default.jpg', '012', '2022-02-01', '1.60', '1.60', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'PROD-000004', 'COEUR DE VOLAILLE VRAC', NULL, 'default.jpg', '013', '2022-02-01', '2.00', '2.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'PROD-000005', 'GRAISSE S/PRODUIT', NULL, 'default.jpg', '014', '2022-02-01', '10.00', '10.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'PROD-000006', 'FAUX FILET', 'FAUX FILET', 'default.jpg', '109', '2022-02-01', '167.00', '172.00', '0.00', '369.97', '0.00', 1, 2, 2, 8, 21, 1, 2, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:16:53', NULL, NULL, NULL, NULL),
(7, 'PROD-000007', 'FILET', '', 'default.jpg', '110', '2022-02-01', '239.00', '249.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 21, 1, -0.3, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:17:17', NULL, NULL, NULL, NULL),
(8, 'PROD-000008', 'TRANCHE BOEUF', '', 'default.jpg', '111', '2022-02-01', '145.00', '146.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 21, 1, -2.706, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-03-27 11:00:41', NULL, NULL, NULL, NULL),
(9, 'PROD-000009', 'COTTE BOEUF', 'COTE DE BŒUF', 'default.jpg', '112', '2022-02-01', '120.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 21, 1, -20.7, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-12 10:12:22', NULL, NULL, NULL, NULL),
(10, 'PROD-000010', 'CÃ–TE DE BOEUF A LA CREME POIVRE', 'COTE DE BŒUF À LA CRÈME POIVRE', 'default.jpg', '113', '2022-02-01', '128.00', '128.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 6, 1, -5.962, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-05-23 11:52:42', NULL, NULL, NULL, NULL),
(11, 'PROD-000011', 'TRANCHE VEAU', 'TRANCHE VEAU', 'default.jpg', '121', '2022-02-01', '148.00', '149.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 22, 1, -130.094, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-03-27 11:00:01', NULL, NULL, NULL, NULL),
(12, 'PROD-000012', 'PLATE COTE VEAU VH SV', NULL, 'default.jpg', '122', '2022-02-01', '89.00', '89.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0.5, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'PROD-000013', 'NOIX BOEUF', '', 'default.jpg', '123', '2022-02-01', '109.00', '128.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, -18.772, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-27 14:18:45', NULL, NULL, NULL, NULL),
(14, 'PROD-000014', 'RUMSTEAK SS OS', 'RUMSTEAK SANS OS', 'default.jpg', '124', '2022-02-01', '164.00', '165.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 21, 1, -40.006, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-27 14:17:33', NULL, NULL, NULL, NULL),
(15, 'PROD-000015', 'RUMSTEAK  VEAU A/OS', 'RUMSTEAK VEAU AVEC OS', 'default.jpg', '125', '2022-02-01', '120.00', '124.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, -16.75, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-27 14:17:55', NULL, NULL, NULL, NULL),
(16, 'PROD-000016', 'JARRET BOEUF COUPE', 'JARRET BOEUF COUPE', 'default.jpg', '126', '2022-02-01', '122.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, -315.219, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:17:45', NULL, NULL, NULL, NULL),
(17, 'PROD-000017', 'EPAULE VEAU', '', 'default.jpg', '127', '2022-02-01', '118.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, -258.396, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-03-14 16:52:15', NULL, NULL, NULL, NULL),
(18, 'PROD-000018', 'T-BONE', 'T-BONE', 'default.jpg', '128', '2022-02-01', '135.00', '145.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 21, 1, -0.39, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:18:11', NULL, NULL, NULL, NULL),
(19, 'PROD-000019', 'JARRET VEAU  ENTIER', 'JARRET VEAU ENTIER', 'default.jpg', '129', '2022-02-01', '127.00', '135.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, NULL, 1, -122.108, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:27:00', NULL, NULL, NULL, NULL),
(20, 'PROD-000020', 'NOIX VEAU SS/OS', 'NOIX VEAU SANS OS', 'default.jpg', '130', '2022-02-01', '109.00', '125.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, -117.136, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-05-03 10:15:20', NULL, NULL, NULL, NULL),
(21, 'PROD-000021', 'VIANDE HACHEE GITE', '', 'default.jpg', '131', '2022-02-01', '109.00', '125.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 21, 1, -1675.6, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:18:35', NULL, NULL, NULL, NULL),
(22, 'PROD-000022', 'QUEUE DE BOEUF', '', 'default.jpg', '132', '2022-02-01', '135.00', '135.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, 0, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-07-05 12:23:46', NULL, NULL, NULL, NULL),
(23, 'PROD-000023', 'SOURIS AGNEAU', NULL, 'default.jpg', '133', '2022-02-01', '600.00', '600.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'PROD-000024', 'EPAULE RONDE', NULL, 'default.jpg', '134', '2022-02-01', '200.00', '200.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'PROD-000025', 'NOIX VEAU AVEC OS', '', 'default.jpg', '135', '2022-02-01', '110.00', '110.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, -0.814, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-12 10:13:43', NULL, NULL, NULL, NULL),
(26, 'PROD-000026', 'V.H REGIME', '', 'default.jpg', '136', '2022-02-01', '148.00', '155.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, -450.985, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-12-17 17:15:35', NULL, NULL, NULL, NULL),
(27, 'PROD-000027', 'VIANDE HACHEE EPICE', '', 'default.jpg', '137', '2022-02-01', '109.50', '115.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 21, 1, 0, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-23 12:35:27', NULL, NULL, NULL, NULL),
(28, 'PROD-000028', 'COTE A L\"OS DE VEAU', '', 'default.jpg', '138', '2022-02-01', '125.00', '132.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, -0.724, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-27 14:21:04', NULL, NULL, NULL, NULL),
(29, 'PROD-000029', 'CARRE DE VEAU', 'CARRÉ DE VEAU', 'default.jpg', '139', '2022-02-01', '119.00', '119.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, 0, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 1, '2022-08-19 15:33:53', NULL, NULL, NULL, NULL),
(30, 'PROD-000030', 'GIGOT MECHOUI FARCI', NULL, 'default.jpg', '140', '2022-02-01', '381.00', '381.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'PROD-000031', 'AGNEAU', '', 'default.jpg', '141', '2022-02-01', '135.00', '135.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 20, 1, -2, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-12 10:11:09', NULL, NULL, NULL, NULL),
(32, 'PROD-000032', 'AGNEAU MECHOUI NATURE', '', 'default.jpg', '142', '2022-02-01', '1420.00', '1330.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 6, 4, 0, 0, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-12-17 19:10:37', NULL, NULL, NULL, NULL),
(33, 'PROD-000033', 'AGNEAU MECHOUI MARINEE', NULL, 'default.jpg', '143', '2022-02-01', '1020.00', '1020.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'PROD-000034', 'DEMI MECHOUI FARCI', NULL, 'default.jpg', '144', '2022-02-01', '1000.00', '1000.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'PROD-000035', 'DEMI AGNEAU MECHOUI MARINEE', NULL, 'default.jpg', '145', '2022-02-01', '670.00', '670.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'PROD-000036', 'DEMI AGNEAU MECHOUI NATURE', '', 'default.jpg', '146', '2022-02-01', '700.00', '700.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 6, 4, 0, 0, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-12-17 19:11:13', NULL, NULL, NULL, NULL),
(37, 'PROD-000037', 'AGNEAU MECHOUI DESSOSE  FARCI', NULL, 'default.jpg', '147', '2022-02-01', '1800.00', '1800.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'PROD-000038', 'COTES D\"AGNEAU', 'COTELETTES D\"AGNEAU', 'default.jpg', '148', '2022-02-01', '165.00', '167.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 20, 1, -0.918, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-27 14:20:48', NULL, NULL, NULL, NULL),
(39, 'PROD-000039', 'GIGOT D\"AGNEAU', 'GIGOT D\"AGNEAU ENTIER', 'default.jpg', '149', '2022-02-01', '128.00', '135.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, -44.588, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-27 14:19:36', NULL, NULL, NULL, NULL),
(40, 'PROD-000040', 'EPAULE D\"AGNEAU', 'EPAULE D\"AGNEAU - 2.5 KG', 'default.jpg', '150', '2022-02-01', '115.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 20, 1, -0.65, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-27 14:20:30', NULL, NULL, NULL, NULL),
(41, 'PROD-000041', 'ROGNON ROUGE', '', 'default.jpg', '160', '2022-02-01', '90.00', '95.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 19, 1, 0, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-27 14:18:24', NULL, NULL, NULL, NULL),
(42, 'PROD-000042', 'ROGNON BLANC', NULL, 'default.jpg', '161', '2022-02-01', '130.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'PROD-000043', 'FOIE DE VEAU', 'FOIE DE VEAU', 'default.jpg', '162', '2022-02-01', '189.00', '199.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 19, 1, -102.766, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-27 14:56:18', NULL, NULL, NULL, NULL),
(44, 'PROD-000044', 'CERVELLE VEAU', '', 'default.jpg', '163', '2022-02-01', '60.00', '80.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 22, 4, 0, 0, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-03-15 14:22:32', NULL, NULL, NULL, NULL),
(45, 'PROD-000045', 'CERVELLES D\"AGNEAU', '', 'default.jpg', '164', '2022-02-01', '59.00', '64.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 4, 0, 0, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-03-24 14:32:23', NULL, NULL, NULL, NULL),
(46, 'PROD-000046', 'PIED DE VEAU', '', 'default.jpg', '165', '2022-02-01', '105.00', '125.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 22, 4, -2, 0, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-12-09 09:04:49', NULL, NULL, NULL, NULL),
(47, 'PROD-000047', 'CREPINE S/V', '', 'default.jpg', '167', '2022-02-01', '60.00', '60.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 19, 1, -6.628, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-06-30 17:21:57', NULL, NULL, NULL, NULL),
(48, 'PROD-000048', 'BROCHETTE VIANDE CREME POIVRE', '', 'default.jpg', '168', '2022-02-01', '180.00', '189.00', '0.00', '0.00', '0.00', 1, 2, 2, 7, 17, 1, -165.626, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:19:34', NULL, NULL, NULL, NULL),
(49, 'PROD-000049', 'BROCHETTE VIANDE CHAR GRILL', '', 'default.jpg', '169', '2022-02-01', '180.00', '180.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, 0, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-08-19 15:59:48', NULL, NULL, NULL, NULL),
(50, 'PROD-000050', 'FOIE AGNEAU', '', 'default.jpg', '170', '2022-02-01', '189.00', '199.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 19, 1, -0.984, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-27 14:56:53', NULL, NULL, NULL, NULL),
(51, 'PROD-000051', 'EPAULE DESOSSE FARCI', NULL, 'default.jpg', '171', '2022-02-01', '820.00', '820.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(52, 'PROD-000052', 'EPAULE COLLE NATURE', NULL, 'default.jpg', '172', '2022-02-01', '619.00', '619.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(53, 'PROD-000053', 'GIGOT DESOSSE FARCI', NULL, 'default.jpg', '173', '2022-02-01', '276.25', '276.25', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(54, 'PROD-000054', 'EPAULE  MARINEE', NULL, 'default.jpg', '174', '2022-02-01', '308.75', '308.75', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'PROD-000055', 'EPAULE COLLEE FARCI', '', 'default.jpg', '175', '2022-02-01', '720.00', '900.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 7, 1, 0, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-12-17 19:12:10', NULL, NULL, NULL, NULL),
(56, 'PROD-000056', 'DEMI MECHOUI MARINE', NULL, 'default.jpg', '176', '2022-02-01', '650.00', '650.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'PROD-000057', 'EPAULE  FARCIE', NULL, 'default.jpg', '177', '2022-02-01', '350.00', '350.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'PROD-000058', 'EPAULE NATURE', NULL, 'default.jpg', '178', '2022-02-01', '337.50', '337.50', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(59, 'PROD-000059', 'COURONNE AGNEAU', NULL, 'default.jpg', '179', '2022-02-01', '130.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'PROD-000060', 'PIEDS AGNEAU PACK DE 12', NULL, 'default.jpg', '180', '2022-02-01', '75.00', '75.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'PROD-000061', 'RATE AGNEAU', NULL, 'default.jpg', '181', '2022-02-01', '29.17', '35.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'PROD-000062', 'EPAULE AGNEAU FAR/PCE', '', 'default.jpg', '190', '2022-02-01', '580.00', '580.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 7, 4, -21, 0, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-12-23 14:24:06', NULL, NULL, NULL, NULL),
(63, 'PROD-000063', 'GIGOT AGNEAU CONFIT', '', 'default.jpg', '191', '2022-02-01', '331.67', '435.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 4, -26, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-12 08:57:10', NULL, NULL, NULL, NULL),
(64, 'PROD-000064', 'BROCHETTE AGNEAU MENTHE', NULL, 'default.jpg', '192', '2022-02-01', '180.00', '180.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'PROD-000065', 'STEAK DE VIANDE', NULL, 'default.jpg', '199', '2022-02-01', '118.00', '118.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'PROD-000066', 'POULET EVIDES', NULL, 'default.jpg', '201', '2022-02-01', '45.00', '45.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'PROD-000067', 'BROCHETTE POULET NAT', 'BROCHETTE POULET NATURE', 'default.jpg', '202', '2022-02-01', '114.00', '125.00', '0.00', '0.00', '0.00', 1, 2, 2, 7, NULL, 1, -752.775, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-03-14 16:55:02', NULL, NULL, NULL, NULL),
(68, 'PROD-000068', 'COQUELETS', NULL, 'default.jpg', '203', '2022-02-01', '28.00', '28.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'PROD-000069', 'BROCHETTES POULET MEXICAINES', 'BROCHETTES POULET MEXICAINES', 'default.jpg', '204', '2022-02-01', '110.00', '118.00', '0.00', '0.00', '0.00', 1, 2, 2, 7, NULL, 1, -257.531, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, 1, 1, 0, 1, '2022-02-01 00:00:00', 2, '2022-12-14 14:09:18', NULL, NULL, NULL, NULL),
(70, 'PROD-000070', 'PILONS POULET', 'PILONS DE POULET', 'default.jpg', '205', '2022-02-01', '85.00', '88.00', '0.00', '0.00', '0.00', 1, 2, 2, 7, 17, 1, -268.28, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:26:40', NULL, NULL, NULL, NULL),
(71, 'PROD-000071', 'BROCHETTE PLT CURRY', 'BROCHETTE POULET AU CURRY', 'default.jpg', '206', '2022-02-01', '99.00', '110.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 1, -183.878, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:17:14', NULL, NULL, NULL, NULL),
(72, 'PROD-000072', 'BROCHETTE PLT CHARGRILL', 'BROCHETTE DE POULET CHARGRILL', 'default.jpg', '207', '2022-02-01', '150.00', '150.00', '0.00', '0.00', '0.00', 1, 2, 2, 7, NULL, 1, -121.127, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-05-23 11:48:18', NULL, NULL, NULL, NULL),
(73, 'PROD-000073', 'POULET BELDI', NULL, 'default.jpg', '208', '2022-02-01', '130.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'PROD-000074', 'DEMI COQUELET MARINE FERMIER LAB', '', 'default.jpg', '209', '2022-02-01', '20.00', '22.00', '0.00', '0.00', '0.00', 1, 2, 2, 7, 17, 4, -489, 0, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:20:14', NULL, NULL, NULL, NULL),
(75, 'PROD-000075', 'PIGEONS', NULL, 'default.jpg', '210', '2022-02-01', '35.00', '35.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'PROD-000076', 'DEMI COQUELET FERMIER LAB MAR X 12 P', NULL, 'default.jpg', '211', '2022-02-01', '240.00', '240.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'PROD-000077', 'CAILLES', NULL, 'default.jpg', '212', '2022-02-01', '35.00', '35.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(78, 'PROD-000078', 'COQUELET FERMIER LABEL', '', 'default.jpg', '213', '2022-02-01', '33.00', '36.00', '0.00', '0.00', '0.00', 1, 2, 2, 7, 18, 4, -663, 0, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:24:31', NULL, NULL, NULL, NULL),
(79, 'PROD-000079', 'POULET FERMIER LABEL', 'POULET FERMIER LABEL', 'default.jpg', '214', '2022-02-01', '82.00', '84.00', '0.00', '82.00', '0.00', 1, 2, 2, 7, 18, 1, 0.104, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:24:51', NULL, NULL, NULL, NULL),
(80, 'PROD-000080', 'BROCHETTES SOTCHI', NULL, 'default.jpg', '215', '2022-02-01', '140.00', '140.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(82, 'PROD-000081', 'V.H CHICH KEBAB', 'CHICH KEBAB', 'default.jpg', '216', '2022-02-01', '115.00', '125.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, -287.628, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:16:44', NULL, NULL, NULL, NULL),
(83, 'PROD-000082', 'POULET PAC S/V SRG', NULL, 'default.jpg', '217', '2022-02-01', '45.00', '45.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(84, 'PROD-000083', 'DINDE', '', 'default.jpg', '220', '2022-02-01', '89.00', '89.00', '0.00', '0.00', '0.00', 1, 2, 2, 7, NULL, 1, 0, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-14 15:49:03', NULL, NULL, NULL, NULL),
(85, 'PROD-000084', 'DINDE FARCIE SALEE', '', 'default.jpg', '223', '2022-02-01', '139.00', '145.00', '0.00', '0.00', '0.00', 1, 2, 2, 4, 11, 1, -35.096, 0, 0, 0, '', '', '', '1', 'auto', '', '', '5.500', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-12-19 08:01:36', NULL, NULL, NULL, NULL),
(86, 'PROD-000085', 'DINDE FARCIE SUCREE', '', 'default.jpg', '224', '2022-02-01', '145.00', '149.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, NULL, 1, -5.368, 0, 0, 0, '', '', '', '1', 'auto', '', '', '5.500', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-12-20 09:38:01', NULL, NULL, NULL, NULL),
(87, 'PROD-000086', 'V.H MINI CHICH KEBAB POULET', 'MINI CHICH KEBAB DE POULET', 'default.jpg', '225', '2022-02-01', '118.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, 13, 1, -91.916, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.500', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:20:34', NULL, NULL, NULL, NULL),
(88, 'PROD-000087', 'V.H MINI CHICH KABAB VIANDE', '', 'default.jpg', '226', '2022-02-01', '125.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, 13, 1, -136.058, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.500', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:20:55', NULL, NULL, NULL, NULL),
(89, 'PROD-000088', 'VSM', NULL, 'default.jpg', '230', '2022-02-01', '9.00', '9.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(90, 'PROD-000089', 'COEUR  PLT S/PRODUIT', NULL, 'default.jpg', '240', '2022-02-01', '2.00', '2.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(91, 'PROD-000090', 'V.H CHICH KABAB POULET', 'CHICH KEBAB DE POULET', 'default.jpg', '250', '2022-02-01', '110.00', '118.00', '0.00', '0.00', '0.00', 1, 2, 2, 7, NULL, 1, -196.702, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:19:14', NULL, NULL, NULL, NULL),
(92, 'PROD-000091', 'CHICH TAOUK', NULL, 'default.jpg', '251', '2022-02-01', '79.17', '95.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(93, 'PROD-000092', 'SUPREME PARIS', NULL, 'default.jpg', '252', '2022-02-01', '81.67', '98.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(94, 'PROD-000093', 'WOK HAWAI', NULL, 'default.jpg', '253', '2022-02-01', '81.67', '98.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(95, 'PROD-000094', 'PASTILLA BOEUF FÃ‰TA Ã‰PINARD', '', 'default.jpg', '254', '2022-02-01', '54.17', '68.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 4, -82, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:37:00', NULL, NULL, NULL, NULL),
(96, 'PROD-000095', 'PASTILLA POULET', '', 'default.jpg', '255', '2022-02-01', '54.17', '68.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 4, -242, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:38:04', NULL, NULL, NULL, NULL),
(97, 'PROD-000096', 'CHICAGO BURGER', '', 'default.jpg', '256', '2022-02-01', '100.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, 4, NULL, 1, 0, 0, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-05-23 11:37:23', NULL, NULL, NULL, NULL),
(98, 'PROD-000097', 'BROCHETTES POULET THAI', '', 'default.jpg', '257', '2022-02-01', '150.00', '155.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, 14, 1, 0, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:15:48', NULL, NULL, NULL, NULL),
(99, 'PROD-000098', 'NEMS SHAWARMA', NULL, 'default.jpg', '258', '2022-02-01', '45.83', '55.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(100, 'PROD-000099', 'NEMS FORESTIERE', '', 'default.jpg', '259', '2022-02-01', '43.33', '55.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:35:52', NULL, NULL, NULL, NULL),
(101, 'PROD-000100', 'MINI BROCHETTE BOEUF', NULL, 'default.jpg', '260', '2022-02-01', '150.00', '150.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(102, 'PROD-000101', 'PASTILLA POULET PRALINE 8 PRS', '', 'default.jpg', '261', '2022-02-01', '491.67', '620.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, NULL, 4, -19, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:39:02', NULL, NULL, NULL, NULL),
(103, 'PROD-000102', 'PASTILLA FRUIT DE MER AU SAUMON 8 PRS', NULL, 'default.jpg', '262', '2022-02-01', '566.67', '680.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -12, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(104, 'PROD-000103', 'BROCHETTE PLT POIVRON', 'MINI BROCHETTE DE POULET AU POIVRON (8 PCS)', 'default.jpg', '263', '2022-02-01', '150.00', '160.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, 12, 1, -104.003, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-09-06 13:40:21', NULL, NULL, NULL, NULL),
(105, 'PROD-000104', 'PASTILLA POULET PRALINÃ‰ 12 PRS', '', 'default.jpg', '264', '2022-02-01', '1500.00', '1600.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:38:18', NULL, NULL, NULL, NULL),
(106, 'PROD-000105', 'PASTILLA FRUIT DE MER', '', 'default.jpg', '265', '2022-02-01', '62.50', '78.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 4, -91, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:37:50', NULL, NULL, NULL, NULL),
(107, 'PROD-000106', 'HARGMA', '', 'default.jpg', '266', '2022-02-01', '192.00', '195.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 4, -39, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:31:11', NULL, NULL, NULL, NULL),
(108, 'PROD-000107', 'TRIPE AGNEAU CUISINÃ‰E', '', 'default.jpg', '267', '2022-02-01', '129.17', '180.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 6, 4, -1, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:13:38', NULL, NULL, NULL, NULL),
(109, 'PROD-000108', 'POULET M\"QALI AUX OLIVES', '', 'default.jpg', '268', '2022-02-01', '112.50', '155.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 4, -70, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:14:21', NULL, NULL, NULL, NULL),
(110, 'PROD-000109', 'POULET Ã€ L\'ORANGE ET FRUITS SECS', '', 'default.jpg', '269', '2022-02-01', '125.00', '165.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 6, 4, -29, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:15:46', NULL, NULL, NULL, NULL),
(111, 'PROD-000110', 'MINI PASTILLA POULET PRALINE', '', 'default.jpg', '270', '2022-02-01', '62.50', '78.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 4, -294, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:34:05', NULL, NULL, NULL, NULL),
(112, 'PROD-000111', 'JAMBONEAU PLT MAITRE HOTEL', NULL, 'default.jpg', '271', '2022-02-01', '88.00', '88.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(113, 'PROD-000112', 'JAMBONEAU PLT BBQ', NULL, 'default.jpg', '272', '2022-02-01', '88.00', '88.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(114, 'PROD-000113', 'KABAB MAGHDOUR', '', 'default.jpg', '273', '2022-02-01', '129.17', '168.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 6, 4, -29, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:14:40', NULL, NULL, NULL, NULL),
(115, 'PROD-000114', 'BOULETTES DE KEFTA A LA TOMATE', NULL, 'default.jpg', '274', '2022-02-01', '120.00', '144.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -1, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(116, 'PROD-000115', 'MINI PASTILLA BOEUF FÃ‰TA Ã‰PINARD', '', 'default.jpg', '275', '2022-02-01', '60.00', '75.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 4, -96, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:33:34', NULL, NULL, NULL, NULL),
(117, 'PROD-000116', 'MINI PASTILLA FRUIT DE MER', '', 'default.jpg', '276', '2022-02-01', '60.00', '75.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, NULL, 4, -191, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:33:50', NULL, NULL, NULL, NULL),
(118, 'PROD-000117', 'MINI NEMS JAMBON FROMAGE', '', 'default.jpg', '277', '2022-02-01', '60.00', '75.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, NULL, 4, -199, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:32:13', NULL, NULL, NULL, NULL),
(119, 'PROD-000118', 'MINI NEMS TRUFFES/ARTICHAUT', '', 'default.jpg', '278', '2022-02-01', '60.00', '75.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, NULL, 4, -110, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:33:11', NULL, NULL, NULL, NULL),
(120, 'PROD-000119', 'MINI NEMS POULET CHAMP FOIE GRAS', '', 'default.jpg', '279', '2022-02-01', '60.00', '75.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, NULL, 4, -130, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:32:53', NULL, NULL, NULL, NULL),
(121, 'PROD-000120', 'CHICKEN MASSALA', '', 'default.jpg', '280', '2022-02-01', '125.00', '155.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, NULL, 1, 0, 0, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:19:19', NULL, NULL, NULL, NULL),
(122, 'PROD-000121', 'NEMS JAMBON FROMAGE', '', 'default.jpg', '281', '2022-02-01', '51.67', '65.00', '0.00', '51.67', '0.00', 1, 2, 2, 2, 4, 4, 1, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:36:04', NULL, NULL, NULL, NULL),
(123, 'PROD-000122', 'NEMS ASIA', '', 'default.jpg', '282', '2022-02-01', '51.67', '65.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, NULL, 4, -317, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:35:10', NULL, NULL, NULL, NULL),
(124, 'PROD-000123', 'NEMS TRUFFES/ARTICHAUT', '', 'default.jpg', '283', '2022-02-01', '54.17', '68.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 4, -70, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:36:28', NULL, NULL, NULL, NULL),
(125, 'PROD-000124', 'MINI NEMS BOEUF MENTHE', '', 'default.jpg', '284', '2022-02-01', '60.00', '75.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, NULL, 4, -112, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:31:52', NULL, NULL, NULL, NULL),
(126, 'PROD-000125', 'MINI NEMS KEBAB', '', 'default.jpg', '285', '2022-02-01', '60.00', '75.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, NULL, 4, -75, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:32:34', NULL, NULL, NULL, NULL),
(127, 'PROD-000126', 'PASTILLA FRUIT DE MER AU SAUMON 12 PRS', '', 'default.jpg', '290', '2022-02-01', '1250.00', '1600.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, NULL, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:37:33', NULL, NULL, NULL, NULL),
(128, 'PROD-000127', 'PASTILLA BOEUF FÃ‰TA Ã‰PINARD 8 PERS', '', 'default.jpg', '291', '2022-02-01', '566.67', '680.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 4, -5, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-02-04 21:24:12', NULL, NULL, NULL, NULL),
(129, 'PROD-000128', 'MINI TARTE JAMBON FROMAGE', '', 'default.jpg', '292', '2022-02-01', '60.00', '72.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, NULL, 4, -178, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-08-19 15:45:14', NULL, NULL, NULL, NULL),
(130, 'PROD-000129', 'MIN FRIAND HOT DOG', '', 'default.jpg', '293', '2022-02-01', '60.00', '72.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, NULL, 4, -207, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-08-19 15:45:43', NULL, NULL, NULL, NULL),
(131, 'PROD-000130', 'MINI CHAUSSON VH', '', 'default.jpg', '294', '2022-02-01', '60.00', '75.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, NULL, 4, -94, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:31:34', NULL, NULL, NULL, NULL),
(132, 'PROD-000131', 'MINI FEUILLETE NAPOLITAIN', '', 'default.jpg', '295', '2022-02-01', '60.00', '72.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, NULL, 4, -39, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-08-19 15:47:15', NULL, NULL, NULL, NULL),
(133, 'PROD-000132', 'SALAMI ITALIEN / SALAMINI', 'SALAMI ITALIEN / SALAMINI SEMI SEC', 'default.jpg', '300', '2022-02-01', '208.33', '250.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(134, 'PROD-000133', 'PASTRAMI DE BOEUF', 'PASTRAMI DE BŒUF', 'default.jpg', '301', '2022-02-01', '250.00', '300.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, -61.785, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 1, '2022-08-19 15:26:15', NULL, NULL, NULL, NULL),
(135, 'PROD-000134', 'JAMBON DE VEAU', 'JAMBON DE VEAU', 'default.jpg', '302', '2022-02-01', '191.67', '240.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, -65.502, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:09:48', NULL, NULL, NULL, NULL),
(136, 'PROD-000135', 'SAUCISSON PETIT PARIS', 'SAUCISSON PETIT PARIS', 'default.jpg', '303', '2022-02-01', '208.33', '250.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, -41.828, 0, 20, 20, '', '', '', '1', '', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(137, 'PROD-000136', 'ROTI DE VEAU CUIT AU FINE HERBE', 'RÔTI DE VEAU POIVRE', 'default.jpg', '304', '2022-02-01', '183.33', '220.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(138, 'PROD-000137', 'BALLOTINE CANARD TRUFFES', 'BALLOTTINE DE CANARD AUX ÉCLATS DE TRUFFE', 'default.jpg', '305', '2022-02-01', '295.83', '380.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, -39.383, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:16:06', NULL, NULL, NULL, NULL),
(139, 'PROD-000138', 'JAMBON DE POULET', 'JAMBON DE POULET', 'default.jpg', '306', '2022-02-01', '166.67', '200.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, -251.371, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 1, '2022-08-19 15:26:40', NULL, NULL, NULL, NULL),
(140, 'PROD-000139', 'PASTRAMI DE DINDE', 'PASTRAMI DE DINDE', 'default.jpg', '307', '2022-02-01', '150.00', '190.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, -53.504, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:10:28', NULL, NULL, NULL, NULL),
(141, 'PROD-000140', 'GALANTINE DE VOLAILLE', 'GALANTINE DE VOLAILLE', 'default.jpg', '308', '2022-02-01', '187.50', '230.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, -56.276, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:19:14', NULL, NULL, NULL, NULL),
(142, 'PROD-000141', 'CHOPPED DE VOLAILLE', NULL, 'default.jpg', '309', '2022-02-01', '133.33', '160.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(143, 'PROD-000142', 'CORNED BEEF', 'CORNED BEEF', 'default.jpg', '310', '2022-02-01', '195.83', '240.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, -46.929, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:10:43', NULL, NULL, NULL, NULL),
(144, 'PROD-000143', 'SAUCISSON FUME', 'SAUCISSON FUMÉ', 'default.jpg', '311', '2022-02-01', '183.33', '220.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, -52.759, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 1, '2022-08-19 15:28:12', NULL, NULL, NULL, NULL),
(145, 'PROD-000144', 'SAUCISSON DE BOEUF', NULL, 'default.jpg', '312', '2022-02-01', '83.33', '100.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(146, 'PROD-000145', 'SALAMI', 'SALAMI AU POIVRE', 'default.jpg', '313', '2022-02-01', '166.67', '200.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, -45.945, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 1, '2022-08-19 15:29:02', NULL, NULL, NULL, NULL),
(147, 'PROD-000146', 'GRAISSES', NULL, 'default.jpg', '315', '2022-02-01', '30.00', '30.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(148, 'PROD-000147', 'PATE DE FOIE VOLAILLE', NULL, 'default.jpg', '316', '2022-02-01', '133.33', '160.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(149, 'PROD-000148', 'PATE DE FOIE DE VOLAILLE POIVRE', '', 'default.jpg', '317', '2022-02-01', '133.33', '170.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 2, 1, 0, 0, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:17:48', NULL, NULL, NULL, NULL),
(150, 'PROD-000149', 'MORTADELLE SICILIENNE', 'MORTADELLE SICILIENNE', 'default.jpg', '319', '2022-02-01', '91.67', '110.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(151, 'PROD-000150', 'MORTADELLE AUX OLIVES', 'MORTADELLE AUX OLIVES', 'default.jpg', '320', '2022-02-01', '95.83', '115.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(152, 'PROD-000151', 'GALANTINES AUX VERDURES', 'GALANTINE AUX VERDURES', 'default.jpg', '322', '2022-02-01', '158.33', '190.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, NULL, 1, -41.434, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 1, '2022-08-19 15:29:26', NULL, NULL, NULL, NULL),
(153, 'PROD-000152', 'LONGANNYSES', NULL, 'default.jpg', '323', '2022-02-01', '150.00', '180.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(154, 'PROD-000153', 'SAUCISSES  FRUNKFURT', 'SAUCISSES FRUNKFURT', 'default.jpg', '324', '2022-02-01', '133.33', '160.00', '0.00', '0.00', '0.00', 1, 2, 2, 6, 16, 1, -60.926, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.300', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-08-19 15:52:51', NULL, NULL, NULL, NULL),
(155, 'PROD-000154', 'SAUCISSE STRASBOURG', 'SAUCISSE STRASBOURG', 'default.jpg', '325', '2022-02-01', '133.33', '160.00', '0.00', '0.00', '0.00', 1, 2, 2, 6, NULL, 1, -62.128, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.330', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-09 12:33:23', NULL, NULL, NULL, NULL),
(156, 'PROD-000155', 'SAUCISSES DE VIENNE', 'SAUCISSES DE VIENNE', 'default.jpg', '327', '2022-02-01', '137.50', '165.00', '0.00', '0.00', '0.00', 1, 2, 2, 6, NULL, 1, -59.921, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.300', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-24 19:14:39', NULL, NULL, NULL, NULL),
(157, 'PROD-000156', 'BACON DE VEAU', 'BACON DE VEAU', 'default.jpg', '329', '2022-02-01', '225.00', '270.00', '0.00', '225.00', '0.00', 1, 2, 2, 1, 1, 1, 0.428, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-24 07:41:19', NULL, NULL, NULL, NULL),
(158, 'PROD-000157', 'CARPACCIO BOEUF', 'CARPACCIO', 'default.jpg', '332', '2022-02-01', '258.33', '320.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, -52.887, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.280', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-02-10 07:58:34', NULL, NULL, NULL, NULL),
(159, 'PROD-000158', 'JAMBON MEXICAIN', 'JAMBON MEXICAIN', 'default.jpg', '334', '2022-02-01', '158.33', '190.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, NULL, 1, -46.43, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 1, '2022-08-19 15:30:06', NULL, NULL, NULL, NULL),
(160, 'PROD-000159', 'JAMBON VIENOIX', 'JAMBON VIENNOIS', 'default.jpg', '335', '2022-02-01', '150.00', '180.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, NULL, 1, -42.428, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 1, '2022-08-19 15:30:32', NULL, NULL, NULL, NULL),
(161, 'PROD-000160', 'CARPACCIO TRUFFES', '', 'default.jpg', '336', '2022-02-01', '275.00', '330.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, 0, 0, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 1, '2022-08-19 15:33:30', NULL, NULL, NULL, NULL),
(162, 'PROD-000161', 'CARPACCIO PARMESAN', '', 'default.jpg', '337', '2022-02-01', '250.00', '300.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, 0, 0, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-04-11 09:20:42', NULL, NULL, NULL, NULL),
(163, 'PROD-000162', 'VIANDE GRISON HALAL', '', 'default.jpg', '338', '2022-02-01', '598.00', '598.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 3, 1, -11.411, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.150', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-10 13:14:20', NULL, NULL, NULL, NULL),
(164, 'PROD-000163', 'MINI CHARCUTERIE 28', NULL, 'default.jpg', '340', '2022-02-01', '23.33', '28.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(165, 'PROD-000164', 'MINI MORTADELLE 18', NULL, 'default.jpg', '341', '2022-02-01', '15.00', '18.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(166, 'PROD-000165', 'JAMBON NOISETTE', 'JAMBON NOISETTE', 'default.jpg', '343', '2022-02-01', '191.67', '230.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, -45.558, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-10 13:15:37', NULL, NULL, NULL, NULL);
INSERT INTO `produits` (`id`, `reference`, `libelle`, `description`, `image`, `code_barre`, `date`, `prixachat`, `prix_vente`, `pourcentage_perte`, `pmp`, `cout_achat`, `active`, `type`, `display_on`, `categorieproduit_id`, `souscategorieproduit_id`, `unite_id`, `stockactuel`, `stock_min`, `tva_achat`, `tva_vente`, `cpt_achat`, `cpt_vente`, `cpt_stock`, `pese`, `type_of`, `type_conditionnement`, `options`, `conditionnement`, `num_lot`, `poids`, `volume`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`, `dlc_jours`, `dlc_annees`, `dlc_mois`, `dlc_heures`) VALUES
(167, 'PROD-000166', 'PLA BALLOTINE DE CANARD', '', 'default.jpg', '345', '2022-02-01', '266.67', '355.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, 0, 0, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:20:19', NULL, NULL, NULL, NULL),
(168, 'PROD-000167', 'PLAT CHARCUTERIE VARIEE', 'PLATEAU DE CHARCUTERIE VARIÉE', 'default.jpg', '346', '2022-02-01', '233.33', '280.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, 0, 0, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-05-23 11:02:42', NULL, NULL, NULL, NULL),
(169, 'PROD-000168', 'PLATEAU CHARCUTERIE PREMIUM', NULL, 'default.jpg', '347', '2022-02-01', '266.67', '320.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(170, 'PROD-000169', 'TERRINE CAMPAGNARDE', '', 'default.jpg', '348', '2022-02-01', '133.33', '170.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, 0, 0, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:13:22', NULL, NULL, NULL, NULL),
(171, 'PROD-000170', 'MOUSSE CANNARD / FIGUES', '', 'default.jpg', '349', '2022-02-01', '183.33', '230.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 2, 1, 0, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.150', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-23 12:36:45', NULL, NULL, NULL, NULL),
(172, 'PROD-000171', 'BRESSAOLA BÅ’UF HALAL', 'BRESSAOLA', 'default.jpg', '350', '2022-02-01', '315.00', '315.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, -43.129, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.200', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-10 13:14:50', NULL, NULL, NULL, NULL),
(173, 'PROD-000172', 'SALADE THON', 'SALADE AU THON', 'default.jpg', '351', '2022-02-01', '104.17', '125.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 27, 1, -15.216, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.200', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-02 17:35:58', NULL, NULL, NULL, NULL),
(174, 'PROD-000173', 'SALADE PLT CURRY', 'SALADE POULET CURRY', 'default.jpg', '352', '2022-02-01', '100.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 27, 1, -7.161, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.200', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-02 17:35:36', NULL, NULL, NULL, NULL),
(175, 'PROD-000174', 'SALADE CHARCUTERIE', 'SALADE CHARCUTERIE', 'default.jpg', '353', '2022-02-01', '108.33', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 27, 1, -13.93, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.200', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-02 17:35:01', NULL, NULL, NULL, NULL),
(176, 'PROD-000175', 'CREAMLING POULET GRILLE', NULL, 'default.jpg', '354', '2022-02-01', '100.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(177, 'PROD-000176', 'CREAMLING JAMBON', NULL, 'default.jpg', '355', '2022-02-01', '100.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(178, 'PROD-000177', 'PEPERONI', 'PEPPERONI', 'default.jpg', '360', '2022-02-01', '175.00', '210.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, NULL, 1, -112.165, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 1, '2022-08-19 15:31:18', NULL, NULL, NULL, NULL),
(179, 'PROD-000178', 'CHORIZO', 'CHORIZO', 'default.jpg', '361', '2022-02-01', '191.67', '230.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 3, 1, -72.787, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.200', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-10 13:15:14', NULL, NULL, NULL, NULL),
(180, 'PROD-000179', 'JAMBON POULET FERMIER A LA NOISETTE', NULL, 'default.jpg', '363', '2022-02-01', '183.33', '220.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(181, 'PROD-000180', 'SAUCISSON SEC BOEUF', 'SAUCISSON SEC DE BŒUF', 'default.jpg', '364', '2022-02-01', '566.67', '680.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, -23.549, 0, 20, 20, '', '', '', '1', '', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(182, 'PROD-000181', 'PATE DE FOIE DE VOLAILLE NATURE 150 GR', NULL, 'default.jpg', '371', '2022-02-01', '23.33', '28.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -189, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(183, 'PROD-000182', 'PATE DE FOIE DE VOLAILLE POIVRE 150 GR', NULL, 'default.jpg', '372', '2022-02-01', '23.33', '28.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -181, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(184, 'PROD-000183', 'TERRINE CAMPAGNARDE 150 GR', NULL, 'default.jpg', '373', '2022-02-01', '23.33', '28.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -90, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(185, 'PROD-000184', 'RILLETTE DE SAUMON 150 GR', NULL, 'default.jpg', '374', '2022-02-01', '40.00', '48.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(186, 'PROD-000185', 'SALADE VARIÃ‰E (CHARCUTERIE)', '', 'default.jpg', '375', '2022-02-01', '133.33', '160.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 27, 1, 0, 0, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-02-04 21:22:55', NULL, NULL, NULL, NULL),
(187, 'PROD-000186', 'MOUSSE CANNARD / FIGUES  150GR', NULL, 'default.jpg', '376', '2022-02-01', '29.17', '35.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -4, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(188, 'PROD-000187', 'CUISSE POULET CONFITE', NULL, 'default.jpg', '400', '2022-02-01', '66.67', '80.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(189, 'PROD-000188', 'ROTI DE VEAU A LA CREME POIVRE', '', 'default.jpg', '401', '2022-02-01', '183.33', '260.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 1, -23.452, 0, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-01 17:40:07', NULL, NULL, NULL, NULL),
(190, 'PROD-000189', 'POULET BRESILIEN', '', 'default.jpg', '402', '2022-02-01', '241.67', '300.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, -86.997, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-03-14 17:19:47', NULL, NULL, NULL, NULL),
(191, 'PROD-000190', 'AILES POULET MAR', NULL, 'default.jpg', '403', '2022-02-01', '36.00', '36.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(192, 'PROD-000191', 'ROTI DE VEAU FARCI', NULL, 'default.jpg', '404', '2022-02-01', '610.00', '610.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(193, 'PROD-000192', 'BBQ CHICKEN WINGS', '', 'default.jpg', '405', '2022-02-01', '60.00', '60.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, NULL, 4, -150, 0, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-08-19 15:49:12', NULL, NULL, NULL, NULL),
(194, 'PROD-000193', 'POULET DESOCE FARCI', '', 'default.jpg', '406', '2022-02-01', '137.50', '190.00', '0.00', '0.00', '0.00', 1, 2, 2, 7, NULL, 4, -145, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:16:05', NULL, NULL, NULL, NULL),
(195, 'PROD-000194', 'V.H PASTEL VDE', 'PASTEL DE VIANDE', 'default.jpg', '409', '2022-02-01', '145.00', '150.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, -134.024, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.350', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-10 13:15:56', NULL, NULL, NULL, NULL),
(196, 'PROD-000195', 'PAUPIETTES', '', 'default.jpg', '410', '2022-02-01', '162.00', '162.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 1, -64.937, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.450', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-24 19:27:58', NULL, NULL, NULL, NULL),
(197, 'PROD-000196', 'POULET FERMIER ROTI CUIT', NULL, 'default.jpg', '411', '2022-02-01', '79.17', '95.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(198, 'PROD-000197', 'POULET CHEVRE BASILIC', NULL, 'default.jpg', '413', '2022-02-01', '145.83', '175.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(199, 'PROD-000198', 'CIGARE PLT SCAMORZZA', 'CIGARE DE POULET À LA SCAMORZZA', 'default.jpg', '414', '2022-02-01', '91.67', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, NULL, 1, -232.62, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.250', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-09-06 13:41:03', NULL, NULL, NULL, NULL),
(200, 'PROD-000199', 'CARRÃ‰ D\'AGNEAU ROYAL', '', 'default.jpg', '415', '2022-02-01', '398.00', '430.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 9, 1, -1.7, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-03-31 09:17:31', NULL, NULL, NULL, NULL),
(201, 'PROD-000200', 'CARRÃ‰ DE VEAU ROYAL', 'CARRÉ DE VEAU ROYAL', 'default.jpg', '416', '2022-02-01', '398.00', '398.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 9, 1, -0.744, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-02-04 21:21:13', NULL, NULL, NULL, NULL),
(202, 'PROD-000201', 'STRUDEL', NULL, 'default.jpg', '417', '2022-02-01', '15.00', '18.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(203, 'PROD-000202', 'GALETTE DES ROIS CANARD', '', 'default.jpg', '418', '2022-02-01', '290.83', '360.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 5, 4, -13, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-03-14 17:23:16', NULL, NULL, NULL, NULL),
(204, 'PROD-000203', 'TOURTE EPINARD FOIS GRAS', NULL, 'default.jpg', '419', '2022-02-01', '15.00', '18.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(205, 'PROD-000204', 'ENTRECOTTE P/C', '', 'default.jpg', '420', '2022-02-01', '230.00', '230.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, NULL, 1, -23.529, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.300', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-02-24 12:12:58', NULL, NULL, NULL, NULL),
(206, 'PROD-000205', 'FRAIS DE LIVRAISON   (AIN DIAB)', NULL, 'default.jpg', '444', '2022-02-01', '16.67', '20.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(207, 'PROD-000206', 'ROSEBEEF', NULL, 'default.jpg', '450', '2022-02-01', '150.00', '180.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(208, 'PROD-000207', 'ROTI POULET FERMIER TRUFFE', 'POULET FERMIER RÔTI AUX ÉCLATS DE TRUFFES ET MOUSSE DE FOIE DE VOLAILLE', 'default.jpg', '451', '2022-02-01', '183.33', '220.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, -20.387, 0, 20, 20, '', '', '', '1', '', '', '', '0.200', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(209, 'PROD-000208', 'ROULADE VOLAILLE FETA/OLIVES', 'ROULADE VOLAILLE FETA/OLIVES', 'default.jpg', '463', '2022-02-01', '150.00', '185.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 1, -53.494, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:40:39', NULL, NULL, NULL, NULL),
(210, 'PROD-000209', 'KOULIBIAC SAUMON', '', 'default.jpg', '470', '2022-02-01', '408.33', '490.00', '0.00', '0.00', '0.00', 1, 2, 2, 4, 11, 4, -7, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-04-08 15:37:43', NULL, NULL, NULL, NULL),
(211, 'PROD-000210', 'BUCHE SAUMON', '', 'default.jpg', '472', '2022-02-01', '290.00', '355.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 5, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:19:05', NULL, NULL, NULL, NULL),
(212, 'PROD-000211', 'WELLINGTON BOEUF', NULL, 'default.jpg', '473', '2022-02-01', '374.17', '449.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -6, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(213, 'PROD-000212', 'SAUCISSE DE VIANDE', 'SAUCISSE DE VIANDE', 'default.jpg', '501', '2022-02-01', '112.00', '118.00', '0.00', '0.00', '0.00', 1, 2, 2, 6, NULL, 1, -655.955, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-27 14:16:33', NULL, NULL, NULL, NULL),
(214, 'PROD-000213', 'SAUCISSE POULET', 'SAUCISSE DE POULET', 'default.jpg', '502', '2022-02-01', '105.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, 6, NULL, 1, -798.957, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:21:26', NULL, NULL, NULL, NULL),
(215, 'PROD-000214', 'SAUCISSE DE FOIE', 'SAUCISSE DE FOIE', 'default.jpg', '503', '2022-02-01', '115.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, 6, 16, 1, -512.682, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:21:55', NULL, NULL, NULL, NULL),
(216, 'PROD-000215', 'SAUCISSE FOIE CUIT', '', 'default.jpg', '504', '2022-02-01', '100.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, 6, NULL, 1, 0, 0, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:27:19', NULL, NULL, NULL, NULL),
(217, 'PROD-000216', 'SAUCISSE CKTL VDE', '', 'default.jpg', '505', '2022-02-01', '130.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, 6, NULL, 1, 0, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-20 14:31:57', NULL, NULL, NULL, NULL),
(218, 'PROD-000217', 'SAUCISSE CKTL PLT', 'SAUCISSE COCKTAIL POULET', 'default.jpg', '506', '2022-02-01', '125.00', '130.00', '0.00', '125.00', '0.00', 1, 2, 2, 6, NULL, 1, 0.706, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:22:24', NULL, NULL, NULL, NULL),
(219, 'PROD-000218', 'SAUCISSES FERMIERE', NULL, 'default.jpg', '507', '2022-02-01', '95.00', '95.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(220, 'PROD-000219', 'SAUCISSES CHIPOLATA CKT', 'SAUCISSE COCKTAIL CHIPOLATA', 'default.jpg', '508', '2022-02-01', '110.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, 6, NULL, 1, -241.472, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:23:26', NULL, NULL, NULL, NULL),
(221, 'PROD-000220', 'SAUCISSES FETA CKT', '', 'default.jpg', '509', '2022-02-01', '95.83', '135.00', '0.00', '0.00', '0.00', 1, 2, 2, 6, NULL, 1, -577.731, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:23:47', NULL, NULL, NULL, NULL),
(222, 'PROD-000221', 'SAUCE GREC MARINADE', NULL, 'default.jpg', '550', '2022-02-01', '104.17', '125.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(223, 'PROD-000222', 'CHAPLURE FANTASTICO', NULL, 'default.jpg', '551', '2022-02-01', '104.17', '125.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(224, 'PROD-000223', 'EPICE VIANDE HACHEE MAGASIN', NULL, 'default.jpg', '552', '2022-02-01', '91.25', '109.50', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(225, 'PROD-000224', 'EPICE VIANDE HACHEE BELDIA', NULL, 'default.jpg', '553', '2022-02-01', '91.25', '109.50', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(226, 'PROD-000225', 'MECHOUI AGNEAU AU ROMARIN', NULL, 'default.jpg', '555', '2022-02-01', '180.00', '180.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(227, 'PROD-000226', 'ROTI PLT/FROMAGE', '', 'default.jpg', '601', '2022-02-01', '100.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 9, 1, -200.316, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.850', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:24:07', NULL, NULL, NULL, NULL),
(228, 'PROD-000227', 'BLANC PLT NAT', 'BLANC DE POULET NATURE', 'default.jpg', '602', '2022-02-01', '110.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, 7, NULL, 1, -220.83, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-09-07 16:14:02', NULL, NULL, NULL, NULL),
(229, 'PROD-000228', 'ESCALOPPE PLT PANNE FROM', 'ESCALOPE DE POULET CORDON BLEU', 'default.jpg', '604', '2022-02-01', '106.67', '138.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 1, -657.295, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:25:55', NULL, NULL, NULL, NULL),
(230, 'PROD-000229', 'MAKROUSTY', '', 'default.jpg', '607', '2022-02-01', '55.00', '55.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 4, -79, 0, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-08-19 15:58:20', NULL, NULL, NULL, NULL),
(231, 'PROD-000230', 'HAMBURGER PLT', 'HAMBURGER POULET', 'default.jpg', '609', '2022-02-01', '118.00', '128.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, NULL, 1, -190.831, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.280', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-03-14 17:20:26', NULL, NULL, NULL, NULL),
(232, 'PROD-000231', 'ESCALOPPE PLT NAT', 'ESCALOPE DE POULET NATURE', 'default.jpg', '610', '2022-02-01', '112.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 1, -893.847, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:17:47', NULL, NULL, NULL, NULL),
(233, 'PROD-000232', 'ESCALOPPE PLT EPI', '', 'default.jpg', '611', '2022-02-01', '108.00', '125.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 1, -109.699, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:18:11', NULL, NULL, NULL, NULL),
(234, 'PROD-000233', 'BLANC POULET NAT S/SEL', '', 'default.jpg', '612', '2022-02-01', '108.00', '110.00', '0.00', '0.00', '0.00', 1, 2, 2, 7, NULL, 1, 0, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-12-17 19:12:39', NULL, NULL, NULL, NULL),
(235, 'PROD-000234', 'ESCALOPPE PLT HER', 'ESCALOPE DE POULET AUX HERBES', 'default.jpg', '613', '2022-02-01', '108.00', '125.00', '0.00', '108.00', '0.00', 1, 2, 2, 3, NULL, 1, 0.472, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:18:30', NULL, NULL, NULL, NULL),
(236, 'PROD-000235', 'CUISSE A L\"ORANGE', NULL, 'default.jpg', '614', '2022-02-01', '50.00', '60.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(237, 'PROD-000236', 'HAMBURGER  POULET FROM', 'HAMBURGER DE POULET AU CHEDDAR ET JAMBON DE POULET', 'default.jpg', '616', '2022-02-01', '98.33', '138.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, 14, 1, -251.222, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.280', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-03-14 17:21:27', NULL, NULL, NULL, NULL),
(238, 'PROD-000237', 'BOULETTE CHILI PEPPER', '', 'default.jpg', '618', '2022-02-01', '112.50', '138.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, NULL, 1, -158.034, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.450', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-03-14 17:22:30', NULL, NULL, NULL, NULL),
(239, 'PROD-000238', 'BOULETTES NAPOLI', '', 'default.jpg', '619', '2022-02-01', '112.50', '138.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, 14, 1, -155.634, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.450', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-03-14 17:22:13', NULL, NULL, NULL, NULL),
(240, 'PROD-000239', 'BOULETTES  POULET FROMAGE', '', 'default.jpg', '620', '2022-02-01', '106.67', '138.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, NULL, 1, -529.747, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.450', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-03-14 17:21:50', NULL, NULL, NULL, NULL),
(241, 'PROD-000240', 'WOK ASIATIQUE', 'WOK ASIATIQUE', 'default.jpg', '621', '2022-02-01', '98.00', '110.00', '0.00', '192.08', '0.00', 1, 2, 2, 2, 4, 1, 1, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:12:29', NULL, NULL, NULL, NULL),
(242, 'PROD-000241', 'BROCHETTE POULET TANDOORI', 'BROCHETTE DE POULET TANDOORI', 'default.jpg', '622', '2022-02-01', '120.00', '125.00', '0.00', '0.00', '0.00', 1, 2, 2, 7, NULL, 1, -182.799, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:12:46', NULL, NULL, NULL, NULL),
(243, 'PROD-000242', 'SUPREME DE POULET CAESAR', '', 'default.jpg', '623', '2022-02-01', '110.00', '128.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, NULL, 1, -157.043, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-10 13:52:37', NULL, NULL, NULL, NULL),
(244, 'PROD-000243', 'WOK CHAWARMA', 'WOK CHAWARMA', 'default.jpg', '624', '2022-02-01', '125.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 1, 0, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:18:50', NULL, NULL, NULL, NULL),
(245, 'PROD-000244', 'CHAWARMA POULET', NULL, 'default.jpg', '625', '2022-02-01', '80.00', '80.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(246, 'PROD-000245', 'SCHNEIK VIANDE', NULL, 'default.jpg', '626', '2022-02-01', '100.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(247, 'PROD-000246', 'ESCALOPE MILANAISE VEAU', NULL, 'default.jpg', '627', '2022-02-01', '155.00', '155.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(248, 'PROD-000247', 'MEDAILLON BOEUF', NULL, 'default.jpg', '628', '2022-02-01', '120.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(249, 'PROD-000248', 'MEDAILLON POULET', NULL, 'default.jpg', '629', '2022-02-01', '120.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(250, 'PROD-000249', 'BROCHETTES GOURMANDES', NULL, 'default.jpg', '630', '2022-02-01', '100.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(251, 'PROD-000250', 'RIBS BBQ', 'RIBS BARBECUE', 'default.jpg', '631', '2022-02-01', '100.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 19, 1, -46.763, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-23 12:05:09', NULL, NULL, NULL, NULL),
(252, 'PROD-000251', 'CUISSE CAMEMBERT', '', 'default.jpg', '632', '2022-02-01', '138.00', '138.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, NULL, 1, -63.392, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.600', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-01-10 13:17:14', NULL, NULL, NULL, NULL),
(253, 'PROD-000252', 'FRIAND HOT DOG', '', 'default.jpg', '634', '2022-02-01', '141.67', '192.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 1, -0.52, 0, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:25:41', NULL, NULL, NULL, NULL),
(254, 'PROD-000253', 'CHAUSSON HACHE LEGUMES', '', 'default.jpg', '635', '2022-02-01', '16.67', '25.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:30:56', NULL, NULL, NULL, NULL),
(255, 'PROD-000254', 'SAUCE GOURMET', NULL, 'default.jpg', '636', '2022-02-01', '100.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(256, 'PROD-000255', 'TARTE JAMBON FROMAGE', '', 'default.jpg', '637', '2022-02-01', '125.00', '160.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 5, 1, 0, 0, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:26:20', NULL, NULL, NULL, NULL),
(257, 'PROD-000256', 'FEUILLETÃ‰ PINTADE ORANGE CHILI', '', 'default.jpg', '638', '2022-02-01', '183.33', '220.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 5, 1, 0, 0, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-02-04 21:20:08', NULL, NULL, NULL, NULL),
(258, 'PROD-000257', 'FEUILLETE NAPOLITAIN', NULL, 'default.jpg', '639', '2022-02-01', '16.67', '20.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(259, 'PROD-000258', 'SAUCE POIVRE CREME', '', 'default.jpg', '640', '2022-02-01', '33.33', '48.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, NULL, 4, -139, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-10 13:53:23', NULL, NULL, NULL, NULL),
(260, 'PROD-000259', 'SAUCE 4 FROMAGE', '', 'default.jpg', '641', '2022-02-01', '33.33', '48.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, NULL, 4, -164, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-10 13:53:37', NULL, NULL, NULL, NULL),
(261, 'PROD-000260', 'SAUCE FORESTIERE', '', 'default.jpg', '642', '2022-02-01', '33.33', '48.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, NULL, 4, -165, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-10 13:53:11', NULL, NULL, NULL, NULL),
(262, 'PROD-000261', 'SAUCE SUPREME FOIS GRAS', '', 'default.jpg', '643', '2022-02-01', '25.00', '48.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 10, 4, -9, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-10 13:53:55', NULL, NULL, NULL, NULL),
(263, 'PROD-000262', 'SAUCE CREME SAFRAN', NULL, 'default.jpg', '644', '2022-02-01', '20.83', '25.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(264, 'PROD-000263', 'SAUCE JUS AGNEAU ROMARIN', NULL, 'default.jpg', '645', '2022-02-01', '20.83', '25.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(265, 'PROD-000264', 'SAUCE TRUFFE', '', 'default.jpg', '646', '2022-02-01', '25.00', '48.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 10, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-10 13:54:09', NULL, NULL, NULL, NULL),
(266, 'PROD-000265', 'BROCHETTE PLT NEW ICE', NULL, 'default.jpg', '647', '2022-02-01', '88.00', '88.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(267, 'PROD-000266', 'CANARD EVIDEE', NULL, 'default.jpg', '648', '2022-02-01', '100.00', '100.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(268, 'PROD-000267', 'SAUCE 4 EPICES', NULL, 'default.jpg', '649', '2022-02-01', '20.83', '25.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(269, 'PROD-000268', 'SAUCE MASSALA', NULL, 'default.jpg', '650', '2022-02-01', '81.67', '98.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(270, 'PROD-000269', 'SAUCE TOMATE TOSCANA', NULL, 'default.jpg', '651', '2022-02-01', '31.67', '38.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -58, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(271, 'PROD-000270', 'SAUCE DIP ANDALOUSE', NULL, 'default.jpg', '652', '2022-02-01', '31.67', '38.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -16, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(272, 'PROD-000271', 'SAUCE DIP GRILL BARBECUE', NULL, 'default.jpg', '653', '2022-02-01', '31.67', '38.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -30, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(273, 'PROD-000272', 'SAUCE DIP SMOKEY HABANERO', NULL, 'default.jpg', '654', '2022-02-01', '31.67', '38.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -17, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(274, 'PROD-000273', 'SAUCE DIP CURRY KETCHUP', NULL, 'default.jpg', '655', '2022-02-01', '31.67', '38.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -30, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(275, 'PROD-000274', 'RAVIOLI JAMBON FROMAGE', '', 'default.jpg', '660', '2022-02-01', '141.67', '190.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, NULL, 1, -93.75, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.330', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:21:28', NULL, NULL, NULL, NULL),
(276, 'PROD-000275', 'RAVIOLI BOLOGNAISE', '', 'default.jpg', '661', '2022-02-01', '135.00', '190.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, NULL, 1, -80.56, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.330', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:21:49', NULL, NULL, NULL, NULL),
(277, 'PROD-000276', 'CANNELONI BOLOGNAISE', NULL, 'default.jpg', '662', '2022-02-01', '58.33', '70.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -123, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(278, 'PROD-000277', 'RAVIOLI TRUFFES ARTICHAUT', 'RAVIOLI TRUFFE ARTICHAUT (14 PCS)', 'default.jpg', '663', '2022-02-01', '183.33', '230.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, NULL, 1, -36.112, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.350', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:22:16', NULL, NULL, NULL, NULL),
(279, 'PROD-000278', 'RAVIOLI POULET CHAMP F GRAS', '', 'default.jpg', '664', '2022-02-01', '154.17', '220.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, NULL, 1, -41.5, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.360', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:22:36', NULL, NULL, NULL, NULL),
(280, 'PROD-000279', 'FRAIS DE LIVRAISON (DAR BOUAAZA)ET(BOUSKOURA)', NULL, 'default.jpg', '666', '2022-02-01', '25.00', '30.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(281, 'PROD-000280', 'CHAUSSON HACHE LEGUMES X 15 PC', '', 'default.jpg', '670', '2022-02-01', '250.00', '330.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:30:35', NULL, NULL, NULL, NULL),
(282, 'PROD-000281', 'FEUILLETE NAPOLITAIN X 8 PC', NULL, 'default.jpg', '671', '2022-02-01', '133.33', '160.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(283, 'PROD-000282', 'VEGGIE BURGER QUINOA', NULL, 'default.jpg', '680', '2022-02-01', '165.00', '198.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(284, 'PROD-000283', 'CHAUSSON HACHEE LEGUME X 3', '', 'default.jpg', '681', '2022-02-01', '56.25', '70.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 5, 4, -119, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-06 09:30:50', NULL, NULL, NULL, NULL),
(285, 'PROD-000284', 'FEUILLETE NAPOLITAIN  X 2', NULL, 'default.jpg', '682', '2022-02-01', '37.50', '45.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -88, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(286, 'PROD-000285', 'TARTE JAMBON FROMAGE X 2', NULL, 'default.jpg', '683', '2022-02-01', '40.83', '49.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, -177, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(287, 'PROD-000286', 'FRIAND HOT DOG X 3', '', 'default.jpg', '684', '2022-02-01', '40.00', '50.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, NULL, 4, -450, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2023-04-15 10:15:19', NULL, NULL, NULL, NULL),
(288, 'PROD-000287', 'CHARCU-TREE', '', 'default.jpg', '689', '2022-02-01', '266.67', '320.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 1, 4, -3, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 1, '2022-08-19 15:33:08', NULL, NULL, NULL, NULL),
(289, 'PROD-000288', 'BROCHETTE PLT MASSALA', 'BROCHETTES POULET MASSALA', 'default.jpg', '698', '2022-02-01', '150.00', '155.00', '0.00', '0.00', '0.00', 1, 2, 2, 7, 17, 1, -69.392, 0, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:20:51', NULL, NULL, NULL, NULL),
(290, 'PROD-000289', 'CHEESY HAM', 'CHEESY HAM', 'default.jpg', '700', '2022-02-01', '150.00', '190.00', '0.00', '0.00', '0.00', 1, 2, 2, 5, 13, 1, -40.845, 0, 20, 20, '', '', '', '1', 'auto', '', '', '0.100', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-11-09 12:18:25', NULL, NULL, NULL, NULL),
(291, 'PROD-000290', 'FRIAND CUIT', '', 'default.jpg', '701', '2022-02-01', '18.33', '22.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-08-19 15:31:36', NULL, NULL, NULL, NULL),
(292, 'PROD-000291', 'TARTE JAM/FRO CUITE', '', 'default.jpg', '702', '2022-02-01', '29.17', '35.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, NULL, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-08-19 15:32:18', NULL, NULL, NULL, NULL),
(293, 'PROD-000292', 'FEUILLETE NAPOLITAIN CUIT', '', 'default.jpg', '703', '2022-02-01', '23.33', '30.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 5, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-12-17 19:14:03', NULL, NULL, NULL, NULL),
(294, 'PROD-000293', 'CHAUSSON HACHE LEGUMES CUIT', '', 'default.jpg', '704', '2022-02-01', '28.00', '30.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 5, 4, 0, 0, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-12-17 19:14:25', NULL, NULL, NULL, NULL),
(295, 'PROD-000294', 'PASTILLA POULET CUITE', '', 'default.jpg', '705', '2022-02-01', '31.67', '38.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, NULL, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-08-19 15:33:11', NULL, NULL, NULL, NULL),
(296, 'PROD-000295', 'PASTILLA BOEUF FÃ‰TA Ã‰PINARD CUITE', '', 'default.jpg', '706', '2022-02-01', '31.67', '38.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 6, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-08-19 15:37:01', NULL, NULL, NULL, NULL),
(297, 'PROD-000296', 'PASTILLA FRUIT DE MER CUITE', '', 'default.jpg', '707', '2022-02-01', '33.33', '40.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-08-19 15:37:38', NULL, NULL, NULL, NULL),
(298, 'PROD-000297', 'NEMS ASIA CUIT', '', 'default.jpg', '708', '2022-02-01', '15.00', '18.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-06-29 08:58:54', NULL, NULL, NULL, NULL),
(299, 'PROD-000298', 'NEMS JAMBON FROMAGE CUIT', '', 'default.jpg', '709', '2022-02-01', '15.00', '18.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-06-29 08:58:17', NULL, NULL, NULL, NULL),
(300, 'PROD-000299', 'NEMS TRUFFES/ARTICHAUT CUIT', '', 'default.jpg', '710', '2022-02-01', '16.67', '20.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 4, 0, 0, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-06-29 08:57:44', NULL, NULL, NULL, NULL),
(301, 'PROD-000392', 'SAC POUBLELLE', NULL, 'default.jpg', 'CON001', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(302, 'PROD-000393', 'ALCOPLUS 5L', NULL, 'default.jpg', 'CON002', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(303, 'PROD-000394', 'NOBLA 5L', NULL, 'default.jpg', 'CON003', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(304, 'PROD-000395', 'PAPIER ESSUI MAIN RLX', NULL, 'default.jpg', 'CON004', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(305, 'PROD-000396', 'HALONET 10 L', NULL, 'default.jpg', 'CON005', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(306, 'PROD-000397', 'AQUASOL 5L', NULL, 'default.jpg', 'CON006', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(307, 'PROD-000398', 'BROSSE', NULL, 'default.jpg', 'CON007', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(308, 'PROD-000399', 'MANCHE RACLETTE BOIS', NULL, 'default.jpg', 'CON008', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(309, 'PROD-000400', 'SERPILIAIRE', NULL, 'default.jpg', 'CON009', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(310, 'PROD-000401', 'PAPIER HYGIENIQUE RLX', NULL, 'default.jpg', 'CON010', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(311, 'PROD-000402', 'CHRYOX SPRAY', NULL, 'default.jpg', 'CON011', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(312, 'PROD-000403', 'GANT LATEX (BOITE)', NULL, 'default.jpg', 'CON012', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(313, 'PROD-000404', 'TABLIER PLASTIQUE (BOITE DE 100)', NULL, 'default.jpg', 'CON013', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(314, 'PROD-000405', 'MANCHETTE AVANT BRAS (BOITE DE 100 PC)', NULL, 'default.jpg', 'CON014', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(315, 'PROD-000406', 'MASQUE (BOITE DE 100 PC)', NULL, 'default.jpg', 'CON015', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(316, 'PROD-000407', 'ABRASSIF', NULL, 'default.jpg', 'CON016', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(317, 'PROD-000408', 'RACLETTE', NULL, 'default.jpg', 'CON018', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(318, 'PROD-000409', 'DESODORSANT AIR FRAICH', NULL, 'default.jpg', 'CON019', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(319, 'PROD-000410', 'TORCHANT', NULL, 'default.jpg', 'CON020', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(320, 'PROD-000411', 'NETTOYANT VITRE', NULL, 'default.jpg', 'CON021', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(321, 'PROD-000412', 'POUBELLE', NULL, 'default.jpg', 'CON022', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(322, 'PROD-000413', 'CHARLOTTE', NULL, 'default.jpg', 'CON023', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(323, 'PROD-000414', 'DETERGENT AU KG ( TIDE)', NULL, 'default.jpg', 'CON024', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(324, 'PROD-000415', 'FILM ALIMENTAIRE ( RLX)', NULL, 'default.jpg', 'CON025', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(325, 'PROD-000416', 'PAPIER ALUMINUM RLX', NULL, 'default.jpg', 'CON026', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(326, 'PROD-000417', 'SACHET 400*500', NULL, 'default.jpg', 'CON027', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(327, 'PROD-000418', 'SACHET SOUS VIDE 200*300', NULL, 'default.jpg', 'CON028', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(328, 'PROD-000419', 'SACHET SOUS VIDE 200*400', NULL, 'default.jpg', 'CON029', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(329, 'PROD-000420', 'ROULEAUX DE BALANCE', NULL, 'default.jpg', 'CON030', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(330, 'PROD-000421', 'FICELLE ALIMENTAIRE', NULL, 'default.jpg', 'CON031', '2022-02-01', '0.01', '0.01', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(331, 'PROD-000422', 'TENUE FEMME DE MENAGE', NULL, 'default.jpg', 'CON032', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(332, 'PROD-000423', 'GASOIL', NULL, 'default.jpg', 'CON033', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 10, 10, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `produits` (`id`, `reference`, `libelle`, `description`, `image`, `code_barre`, `date`, `prixachat`, `prix_vente`, `pourcentage_perte`, `pmp`, `cout_achat`, `active`, `type`, `display_on`, `categorieproduit_id`, `souscategorieproduit_id`, `unite_id`, `stockactuel`, `stock_min`, `tva_achat`, `tva_vente`, `cpt_achat`, `cpt_vente`, `cpt_stock`, `pese`, `type_of`, `type_conditionnement`, `options`, `conditionnement`, `num_lot`, `poids`, `volume`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`, `dlc_jours`, `dlc_annees`, `dlc_mois`, `dlc_heures`) VALUES
(333, 'PROD-000424', 'RLX DE CAISSE', NULL, 'default.jpg', 'CON034', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(334, 'PROD-000425', 'FEUILLE PLATSIQUE INT 22X24', NULL, 'default.jpg', 'CON035', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(335, 'PROD-000426', 'COUTEAU BOUCHER', NULL, 'default.jpg', 'CON036', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(336, 'PROD-000427', 'DEVANT', NULL, 'default.jpg', 'CON037', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(337, 'PROD-000428', 'TIGE 20 CM', NULL, 'default.jpg', 'CON038', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(338, 'PROD-000429', 'TIGE 15 CM', NULL, 'default.jpg', 'CON039', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(339, 'PROD-000430', 'COUTEAU D\"HACHOIR 98', NULL, 'default.jpg', 'CON040', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(340, 'PROD-000431', 'SEAU', NULL, 'default.jpg', 'CON041', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(341, 'PROD-000432', 'TICKETS CLIENTS', NULL, 'default.jpg', 'CON042', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(342, 'PROD-000433', 'GRILLE D\"HACHOIR 98', NULL, 'default.jpg', 'CON043', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(343, 'PROD-000434', 'MARQUEUR', NULL, 'default.jpg', 'CON044', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(344, 'PROD-000435', 'RUBANT ADHESIF', NULL, 'default.jpg', 'CON045', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(345, 'PROD-000436', 'LAMES D\"HACHOIR 98', NULL, 'default.jpg', 'CON046', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(346, 'PROD-000437', 'BAG INOX 1.3', NULL, 'default.jpg', 'CON047', '2022-02-01', '0.83', '1.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(347, 'PROD-000438', 'BALAI', NULL, 'default.jpg', 'CON048', '2022-02-01', '0.83', '1.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(348, 'PROD-000439', 'CURDENT', NULL, 'default.jpg', 'CON049', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(349, 'PROD-000440', 'VISIERE', NULL, 'default.jpg', 'CON050', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(350, 'PROD-000441', 'TENUE BLANC AVEC LOGO', NULL, 'default.jpg', 'CON051', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(351, 'PROD-000442', 'FUSIL', NULL, 'default.jpg', 'CON052', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(352, 'PROD-000443', 'LAME DE SCIE 1980', NULL, 'default.jpg', 'CON053', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(353, 'PROD-000444', 'LAME DE SCIE 1750', NULL, 'default.jpg', 'CON054', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(354, 'PROD-000445', 'LAME DE SCIE 2340', NULL, 'default.jpg', 'CON055', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(355, 'PROD-000446', 'MACHINE PRESSE BURGER', NULL, 'default.jpg', 'CON056', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(356, 'PROD-000447', 'PLANCHE A DECOUPER', NULL, 'default.jpg', 'CON057', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(357, 'PROD-000448', 'FRANGE MICROFIBRE', NULL, 'default.jpg', 'CON058', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(358, 'PROD-000449', 'BLOUSE VISITEUR', NULL, 'default.jpg', 'CON059', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(359, 'PROD-000450', 'BRAVO PINO', NULL, 'default.jpg', 'CON060', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(360, 'PROD-000451', 'FOAMCHLOR', NULL, 'default.jpg', 'CON061', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(361, 'PROD-000452', 'PLATEAU NOIR', NULL, 'default.jpg', 'CON062', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(362, 'PROD-000453', 'AMANDE EFFILEE', NULL, 'default.jpg', 'CON063', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(363, 'PROD-000454', 'CANELLE POUDRE', NULL, 'default.jpg', 'CON064', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(364, 'PROD-000455', 'BEURRE LIQUIDE /L', NULL, 'default.jpg', 'CON065', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 14, 14, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(365, 'PROD-000456', 'SUCRE GLACE', NULL, 'default.jpg', 'CON066', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 7, 7, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(366, 'PROD-000457', 'PAPIER CUISSON 10*12', NULL, 'default.jpg', 'CON067', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(367, 'PROD-000458', 'PLATEAU DORE', NULL, 'default.jpg', 'CON068', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(368, 'PROD-000459', 'MIL 92, SAVON DESINFECTANT POUR MAINS', NULL, 'default.jpg', 'CON069', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(369, 'PROD-000460', 'ABRASIF METALIQUE', NULL, 'default.jpg', 'CON070', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, -12, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(370, 'PROD-000461', 'CITRON', NULL, 'default.jpg', 'CON071', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(371, 'PROD-000462', 'POYSTERE CP12', NULL, 'default.jpg', 'CON072', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(372, 'PROD-000463', 'POYSTERE CP 15', NULL, 'default.jpg', 'CON073', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(373, 'PROD-000464', 'COUTEAU MAG GM REF 0260016', NULL, 'default.jpg', 'CON074', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(374, 'PROD-000465', 'COUTEAU MAG PM REF 0011015', NULL, 'default.jpg', 'CON075', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(375, 'PROD-000466', 'ETIQ POULET COQUELET FERMIER', NULL, 'default.jpg', 'CON076', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(376, 'PROD-000467', 'ETIQ POULET FERMIER', NULL, 'default.jpg', 'CON077', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(377, 'PROD-000468', 'MIEL DAR ESSALAM', NULL, 'default.jpg', 'CON078', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(378, 'PROD-000469', 'PAPIER CUISSON', NULL, 'default.jpg', 'CON079', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(379, 'PROD-000470', 'COUVERCLE GASTRO 1/4', NULL, 'default.jpg', 'CON080', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(380, 'PROD-000471', 'BAC GASTRO 1/4', NULL, 'default.jpg', 'CON081', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(381, 'PROD-000472', 'COUTEAU HACHOIR 32', NULL, 'default.jpg', 'CON082', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(382, 'PROD-000473', 'GRILLE HACHOIR 32', NULL, 'default.jpg', 'CON083', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(383, 'PROD-000474', 'LAME HACHOIR 32', NULL, 'default.jpg', 'CON084', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(384, 'PROD-000475', 'SAC 90/100', NULL, 'default.jpg', 'CON085', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(385, 'PROD-000476', 'MILAV/DETERGENT', NULL, 'default.jpg', 'CON086', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(386, 'PROD-000477', 'PAPIER AIR-LAID', NULL, 'default.jpg', 'CON087', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(387, 'PROD-000478', 'MANCHE RACLETTE PLASTIQUE A VIS 145 CM', NULL, 'default.jpg', 'CON088', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(388, 'PROD-000479', 'CUILLERES', NULL, 'default.jpg', 'CON089', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(389, 'PROD-000480', 'DEVIDOIR ADHESIF EMBALAGE', NULL, 'default.jpg', 'CON090', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(390, 'PROD-000481', 'CARTON', NULL, 'default.jpg', 'CON091', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(391, 'PROD-000482', 'GANTS EN PLASTIQUE', NULL, 'default.jpg', 'CON092', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(392, 'PROD-000483', 'CHEMISE', NULL, 'default.jpg', 'CON093', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(393, 'PROD-000484', 'BOITE NOIRE 350CC AVEC COUVERCLE', NULL, 'default.jpg', 'CON094', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(394, 'PROD-000485', 'BOITE NOIR 600CC AVEC COUVERCLE', NULL, 'default.jpg', 'CON095', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(395, 'PROD-000486', 'BOITE NOIRE 800 CC AVEC COUVERCLE', NULL, 'default.jpg', 'CON096', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(396, 'PROD-000487', 'FOURCHETTE TRANSPARENT', NULL, 'default.jpg', 'CON098', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(397, 'PROD-000488', 'SERVETTE COULEUR FUSHIA', NULL, 'default.jpg', 'CON099', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(398, 'PROD-000489', 'SERVIETTE COULEUR AQUA', NULL, 'default.jpg', 'CON100', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(399, 'PROD-000490', 'COUTEAU TRANSPARENT', NULL, 'default.jpg', 'CON111', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(400, 'PROD-000491', 'COUVERCLE GASTRO 1/3', NULL, 'default.jpg', 'CON179', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(401, 'PROD-000492', 'SACHET CLIENTS MM', NULL, 'default.jpg', 'CON810', '2022-02-01', '0.01', '0.01', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(402, 'PROD-000493', 'SACHET CLIENTS GM', NULL, 'default.jpg', 'CON813', '2022-02-01', '4.17', '5.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(403, 'PROD-000494', 'POYSTERE CP 16', NULL, 'default.jpg', 'CON820', '2022-02-01', '29.17', '35.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(404, 'PROD-000495', 'SACHET ARGENTE', NULL, 'default.jpg', 'CON927', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(405, 'PROD-000496', 'VIANDE HACHEE CUIT SRG', '', 'default.jpg', 'EC012', '2022-02-01', '85.00', '85.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 21, 1, 0, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 2, '2022-06-29 08:28:50', NULL, NULL, NULL, NULL),
(406, 'PROD-000497', 'FLEUTRE F.CASTEL BLEU TABLEAU', NULL, 'default.jpg', 'FOR002', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(407, 'PROD-000498', 'AGRAFES MAPED 24/6', NULL, 'default.jpg', 'FOR003', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 1, 0, 0, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(408, 'PROD-000499', 'AGRAFEUSE DELI', NULL, 'default.jpg', 'FOR004', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(409, 'PROD-000500', 'ARRACHE AGRAFES DELI', NULL, 'default.jpg', 'FOR005', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(410, 'PROD-000501', 'BOITE A TOMBON  MEMORY', NULL, 'default.jpg', 'FOR006', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(411, 'PROD-000502', 'BOITE ARCHIVE GM', NULL, 'default.jpg', 'FOR007', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(412, 'PROD-000503', 'CARNET A5 S/SPIRAL', NULL, 'default.jpg', 'FOR008', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(413, 'PROD-000504', 'ENCREUR BLEU', NULL, 'default.jpg', 'FOR009', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(414, 'PROD-000505', 'ENCREUR ROUGE', NULL, 'default.jpg', 'FOR010', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(415, 'PROD-000506', 'ENVELOPPE 11.5*23 AUTOCOLLANT SANS FENETRE', NULL, 'default.jpg', 'FOR011', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(416, 'PROD-000507', 'ENVLOPPE A5 JAUNE', NULL, 'default.jpg', 'FOR012', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(417, 'PROD-000508', 'FLUO F.CASTEL ORANGE', NULL, 'default.jpg', 'FOR013', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(418, 'PROD-000509', 'FLUO F.CASTEL ROSE', NULL, 'default.jpg', 'FOR014', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(419, 'PROD-000510', 'FLUO F.CASTEL VERT', NULL, 'default.jpg', 'FOR015', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(420, 'PROD-000511', 'POCHETTE DE COTE ATLAS', NULL, 'default.jpg', 'FOR016', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(421, 'PROD-000512', 'STYLO BIC', NULL, 'default.jpg', 'FOR017', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(422, 'PROD-000513', 'TROMBONNE 33 MM', NULL, 'default.jpg', 'FOR018', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 1, 0, 0, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(423, 'PROD-000514', 'CARTE VISITE', NULL, 'default.jpg', 'FOR019', '2022-02-01', '1.00', '1.20', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(424, 'PROD-000515', 'CATALOGUE', NULL, 'default.jpg', 'FOR020', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(425, 'PROD-000516', 'POST IT', NULL, 'default.jpg', 'FOR021', '2022-02-01', '1.00', '1.20', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(426, 'PROD-000517', 'POCHETTE A4', NULL, 'default.jpg', 'FOR022', '2022-02-01', '1.00', '1.20', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(427, 'PROD-000518', 'TONER HP COMPATIBLE CF283A', NULL, 'default.jpg', 'FOR023', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(428, 'PROD-000519', 'BLANCO', NULL, 'default.jpg', 'FOR024', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(429, 'PROD-000520', 'REGISTRE', NULL, 'default.jpg', 'FOR025', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(430, 'PROD-000521', 'RAMETTE PAPIER A4', NULL, 'default.jpg', 'FOR026', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(431, 'PROD-000522', 'ENVELOPPE A4 JAUNE', NULL, 'default.jpg', 'FOR027', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(432, 'PROD-000523', 'CARNET BON DE SORTIE', NULL, 'default.jpg', 'FOR028', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(433, 'PROD-000524', 'CISEAUX', NULL, 'default.jpg', 'FOR029', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(434, 'PROD-000525', 'PAPIER EN TETE', NULL, 'default.jpg', 'FOR030', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(435, 'PROD-000526', 'MARQUEUR PERMANANT', NULL, 'default.jpg', 'FOR031', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(436, 'PROD-000527', 'PORTE DOCUMENT', NULL, 'default.jpg', 'FOR032', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(437, 'PROD-000528', 'TONER CF217A', NULL, 'default.jpg', 'FOR033', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(438, 'PROD-000529', 'CALCULATRICE', NULL, 'default.jpg', 'FOR034', '2022-02-01', '0.83', '1.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(439, 'PROD-000530', 'TABLEAU MAGNETIQUE', NULL, 'default.jpg', 'FOR035', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 29, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(440, 'PROD-000531', 'PANSEMENT', NULL, 'default.jpg', 'MED001', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 30, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(441, 'PROD-000532', 'SERUM PHYSIOLOGIQUE', NULL, 'default.jpg', 'MED002', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 30, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(442, 'PROD-000533', 'COTTON', NULL, 'default.jpg', 'MED004', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 30, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(443, 'PROD-000534', 'DOLIPRANE', NULL, 'default.jpg', 'MED005', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 30, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(444, 'PROD-000535', 'BETADINE', NULL, 'default.jpg', 'MED007', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 30, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(445, 'PROD-000536', 'BIAFNE', NULL, 'default.jpg', 'MED008', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 30, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(446, 'PROD-000537', 'MEDICASOL PUDRE', NULL, 'default.jpg', 'MED010', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 30, 4, 0, 0, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(447, 'PROD-000538', 'ALCOOL', NULL, 'default.jpg', 'MED011', '2022-02-01', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, 9, 30, 4, 0, 0, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, 1, '2022-02-01 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL),
(448, 'PROD-000447', 'COQUELET FERMIER FOIE GRAS', 'COQUELET FERMIER FARCI FOIE GRAS', 'default.jpg', '890', '2022-02-19', '162.50', '198.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 7, 1, -22.436, 10, 20, 20, '', '', '', '1', 'auto', '', '', '0.450', 0, NULL, NULL, 0, 2, '2022-02-19 09:07:46', 2, '2023-04-10 13:52:21', NULL, NULL, NULL, NULL),
(449, 'PROD-000448', 'MINI FEUILLETÃ‰ NAPOLITAIN (6 UNITÃ‰S/PACK)', '', 'default.jpg', '296', '2022-02-19', '57.50', '69.00', '0.00', '69.00', '0.00', 1, 2, 2, 2, 4, 4, 0, 10, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 2, '2022-02-19 11:34:51', NULL, NULL, NULL, NULL, NULL, NULL),
(450, 'PROD-000449', 'LANGUE DE VEAU', 'LANGUE DE VEAU', 'default.jpg', '800', '2022-02-19', '105.00', '115.00', '0.00', '95.00', '0.00', 1, 2, 2, 8, 19, 1, 0, 10, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 2, '2022-02-19 11:36:54', 2, '2023-03-24 14:31:21', NULL, NULL, NULL, NULL),
(451, 'PROD-000450', 'COQUELET FERMIER DÃ‰SOSSE FARCI CUIT', '', 'default.jpg', '888', '2022-02-19', '162.50', '200.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 7, 1, -57.809, 10, 20, 20, '', '', '', '1', 'auto', '', '', '0.450', 0, NULL, NULL, 0, 2, '2022-02-19 11:42:17', 2, '2023-04-15 10:15:42', NULL, NULL, NULL, NULL),
(452, 'PROD-000451', 'PACK TRIPE Dâ€™AGNEAU', '', 'default.jpg', '991', '2022-02-19', '500.00', '500.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 19, 4, -8, 10, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 2, '2022-02-19 11:46:09', 1, '2022-08-19 15:25:50', NULL, NULL, NULL, NULL),
(453, 'PROD-000452', 'LA RATE FARCIE', 'LA RATE FARCIE', 'default.jpg', '994', '2022-02-19', '141.67', '170.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 7, 1, -48.248, 10, 20, 20, '', '', '', '1', 'auto', '', '', '0.380', 0, NULL, NULL, 0, 2, '2022-02-19 11:48:30', 2, '2023-01-12 19:20:53', NULL, NULL, NULL, NULL),
(454, 'PROD-000453', 'BROCHETTE POUR SOUPE SS OS', '', 'default.jpg', '560', '2022-03-16', '138.00', '138.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 21, 1, -43.168, 10, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 2, '2022-03-16 14:56:30', 2, '2022-11-07 11:37:46', NULL, NULL, NULL, NULL),
(455, 'PROD-000454', 'BROCHETTE POUR SOUPE AVEC OS', '', 'default.jpg', '561', '2022-03-16', '89.00', '89.00', '0.00', '89.00', '0.00', 1, 2, 2, 8, 21, 1, 0, 10, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 2, '2022-03-16 14:57:48', 2, '2022-03-16 14:58:26', NULL, NULL, NULL, NULL),
(456, 'PROD-000455', 'GIGOT CONFIT CHAUD', '', 'default.jpg', '727', '2022-05-23', '406.67', '495.00', '0.00', '460.00', '0.00', 1, 2, 2, 8, 20, 4, 0, 10, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 2, '2022-05-23 13:03:55', 2, '2023-04-12 08:57:27', NULL, NULL, NULL, NULL),
(457, 'PROD-000456', 'JARRET VEAU ENTIER', '', 'default.jpg', '760', '2022-05-23', '112.00', '112.00', '0.00', '112.00', '0.00', 1, 2, 2, 8, 22, 1, 0, 10, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 2, '2022-05-23 13:15:28', 2, '2022-06-29 08:28:03', NULL, NULL, NULL, NULL),
(458, 'PROD-000457', 'JARRET VEAU COUPE', '', 'default.jpg', '763', '2022-05-23', '112.00', '112.00', '0.00', '112.00', '0.00', 1, 2, 2, 8, 22, 1, 0, 10, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 2, '2022-05-23 13:16:14', 2, '2022-06-29 08:27:48', NULL, NULL, NULL, NULL),
(459, 'PROD-000458', 'EPAULE DE VEAU', '', 'default.jpg', '766', '2022-05-23', '100.00', '100.00', '0.00', '99.99', '0.00', 1, 2, 2, 8, 20, 1, 0, 10, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 2, '2022-05-23 13:18:24', 2, '2022-06-29 08:27:37', NULL, NULL, NULL, NULL),
(460, 'PROD-000459', 'KHLII FUME 175 GR', '', 'default.jpg', '286', '2022-06-14', '31.67', '38.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 6, 4, -84, 10, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, 2, '2022-06-14 11:47:59', NULL, NULL, NULL, NULL, NULL, NULL),
(461, 'PROD-000459', 'SAUCE KEBAB', NULL, 'default.jpg', '656', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(462, 'PROD-000460', 'SAUCE BURGER', NULL, 'default.jpg', '657', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(463, 'PROD-000461', 'SAUCE CHEDDAR', NULL, 'default.jpg', '658', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(464, 'PROD-000462', 'SAUCE CAESAR', '', 'default.jpg', '659', '2023-04-08', '45.83', '55.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 10, 4, 0, 10, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, NULL, NULL, 2, '2023-04-08 11:23:51', NULL, NULL, NULL, NULL),
(465, 'PROD-000463', 'BOULETTES FROMAGE X 5 CHAUD', NULL, 'default.jpg', '711', NULL, '29.17', '35.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(466, 'PROD-000464', 'BOULETTES NAPOLI X 5 CHAUD', NULL, 'default.jpg', '712', NULL, '29.17', '35.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(467, 'PROD-000465', 'BOULETTES CHILI X 5 CHAUD', NULL, 'default.jpg', '713', NULL, '29.17', '35.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(468, 'PROD-000466', 'MCROUSTY X 6 CUITE', NULL, 'default.jpg', '714', NULL, '45.83', '55.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(469, 'PROD-000467', 'WINGS BBQ X  6  CUITE', NULL, 'default.jpg', '715', NULL, '49.17', '59.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(470, 'PROD-000468', 'RAVIOLI CUISINEE', NULL, 'default.jpg', '720', NULL, '190.83', '229.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(471, 'PROD-000469', 'POULET FERMIER ROTI CHAUD', NULL, 'default.jpg', '721', NULL, '115.83', '139.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(472, 'PROD-000470', 'COQUELET FERMIER FARCI CHAUD', NULL, 'default.jpg', '722', NULL, '190.83', '229.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(473, 'PROD-000471', 'POULET FARCI CHAUD', NULL, 'default.jpg', '723', NULL, '165.00', '198.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(474, 'PROD-000472', 'PAUPIETTES BOEUF CUITES', NULL, 'default.jpg', '724', NULL, '207.50', '249.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(475, 'PROD-000473', 'ROTI AU POIVRE CHAUD', NULL, 'default.jpg', '725', NULL, '290.83', '349.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(476, 'PROD-000474', 'ROTI PLT FROMAGE CHAUD', NULL, 'default.jpg', '726', NULL, '207.50', '249.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(477, 'PROD-000475', 'EPAULE FARCIE CHAUD', NULL, 'default.jpg', '728', NULL, '566.67', '680.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(478, 'PROD-000476', 'CORDON BLEU CHAUD', NULL, 'default.jpg', '729', NULL, '190.83', '229.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(479, 'PROD-000477', 'PASTEL  CHAUD', NULL, 'default.jpg', '730', NULL, '190.83', '229.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(480, 'PROD-000478', 'SAUCISSE FOIE CH', '', 'default.jpg', '731', '2022-08-19', '130.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, 6, NULL, 1, 0, 10, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, 2, '2022-08-19 15:51:53', NULL, NULL, NULL, NULL),
(481, 'PROD-000479', 'CHICH KABAB CHAUD', NULL, 'default.jpg', '732', NULL, '165.00', '198.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(482, 'PROD-000480', 'PASTILLA PLT X 8  CHAUD', NULL, 'default.jpg', '733', NULL, '541.67', '650.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(483, 'PROD-000481', 'PASTILLA FDM X 8 CHAUD', NULL, 'default.jpg', '734', NULL, '625.00', '750.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(484, 'PROD-000482', 'CANNELLONI CHAUD', NULL, 'default.jpg', '735', NULL, '91.67', '110.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(485, 'PROD-000483', 'SAUCE CULINAIRE CHAUD', NULL, 'default.jpg', '736', NULL, '207.50', '249.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(486, 'PROD-000484', 'RATE FARCIE CHAUD', '', 'default.jpg', '737', '2023-01-23', '190.83', '229.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 7, 1, 0, 10, 20, 20, '', '', '', '1', 'auto', '', '', '0.380', 0, NULL, NULL, 0, NULL, NULL, 2, '2023-01-23 12:25:20', NULL, NULL, NULL, NULL),
(487, 'PROD-000485', 'WELLINGTON BOEUF CHAUD', NULL, 'default.jpg', '738', NULL, '415.83', '499.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(488, 'PROD-000486', 'GALETTE CANARD CHAUD', NULL, 'default.jpg', '739', NULL, '332.50', '399.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(489, 'PROD-000487', 'KOULIBIAC SAUMON CHAUD', NULL, 'default.jpg', '740', NULL, '457.50', '549.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(490, 'PROD-000488', 'CARRÉ D\"AGNEAU CHAUD', NULL, 'default.jpg', '741', NULL, '415.83', '499.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(491, 'PROD-000489', 'PASTILLA FÉTA ÉPIN X 8 CHAUD', NULL, 'default.jpg', '742', NULL, '625.00', '750.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(492, 'PROD-000490', 'PASTILLA PLT PRALINÉ X 12 CHAUD', NULL, 'default.jpg', '743', NULL, '1083.33', '1300.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(493, 'PROD-000491', 'PASTILLA FDM SAUMON X 12 CHAUD', NULL, 'default.jpg', '744', NULL, '1333.33', '1600.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(494, 'PROD-000492', 'PASTILLA FÉTA ÉPIN X 12 CHAUD', NULL, 'default.jpg', '745', NULL, '1333.33', '1600.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(495, 'PROD-000493', 'HOT DOG CHAUD', NULL, 'default.jpg', '746', NULL, '37.50', '45.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(496, 'PROD-000494', 'SAUCISSES MIXTE', NULL, 'default.jpg', '750', NULL, '120.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(497, 'PROD-000495', 'SAUCISSES COKTAIL MIXTE', NULL, 'default.jpg', '751', NULL, '130.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(498, 'PROD-000496', 'VIANDE HACHEE', NULL, 'default.jpg', '752', NULL, '115.00', '115.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(499, 'PROD-000497', 'MINI BROCHETTES MIXTE', NULL, 'default.jpg', '753', NULL, '170.00', '170.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(500, 'PROD-000498', 'BOULETTES MIXTE', NULL, 'default.jpg', '754', NULL, '120.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(501, 'PROD-000499', 'CHICH KABAB MIXTE', NULL, 'default.jpg', '755', NULL, '130.00', '130.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(502, 'PROD-000500', 'SALADES MIXTE', NULL, 'default.jpg', '756', NULL, '125.00', '150.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(503, 'PROD-000501', 'FAUX FILET', NULL, 'default.jpg', '757', NULL, '155.00', '155.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(504, 'PROD-000502', 'FILET', NULL, 'default.jpg', '758', NULL, '210.00', '210.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(505, 'PROD-000503', 'RUMSTEACK SS OS', NULL, 'default.jpg', '759', NULL, '138.00', '138.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(506, 'PROD-000504', 'NOIX VEAU AVEC OS', NULL, 'default.jpg', '761', NULL, '95.00', '95.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(507, 'PROD-000505', 'GIGOT D\"AGNEAU', NULL, 'default.jpg', '762', NULL, '115.00', '115.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(508, 'PROD-000506', 'COTE A L\"OS', NULL, 'default.jpg', '764', NULL, '119.00', '119.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(509, 'PROD-000507', 'NOIX SS OS', NULL, 'default.jpg', '765', NULL, '115.00', '115.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(510, 'PROD-000508', 'EPAULE D\"AGNEAU', NULL, 'default.jpg', '767', NULL, '115.00', '115.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `produits` (`id`, `reference`, `libelle`, `description`, `image`, `code_barre`, `date`, `prixachat`, `prix_vente`, `pourcentage_perte`, `pmp`, `cout_achat`, `active`, `type`, `display_on`, `categorieproduit_id`, `souscategorieproduit_id`, `unite_id`, `stockactuel`, `stock_min`, `tva_achat`, `tva_vente`, `cpt_achat`, `cpt_vente`, `cpt_stock`, `pese`, `type_of`, `type_conditionnement`, `options`, `conditionnement`, `num_lot`, `poids`, `volume`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`, `dlc_jours`, `dlc_annees`, `dlc_mois`, `dlc_heures`) VALUES
(511, 'PROD-000509', 'MINI FEUILLETE NAPOLITAIN CHAUD', NULL, 'default.jpg', '770', NULL, '74.17', '89.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(512, 'PROD-000510', 'MIN FRIAND HOT DOG CHAUD', NULL, 'default.jpg', '771', NULL, '74.17', '89.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(513, 'PROD-000511', 'ROULADE VOLAILLE FETA/OLIVES CHAUD', NULL, 'default.jpg', '772', NULL, '216.67', '260.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(514, 'PROD-000512', 'COTELETTE D\"AGNEAU', NULL, 'default.jpg', '777', NULL, '160.00', '160.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(515, 'PROD-000513', 'PACK BOULFAF', NULL, 'default.jpg', '782', NULL, '209.00', '209.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(516, 'PROD-000514', 'OS Ã€ MOELLE', '', 'default.jpg', '789', '2022-08-17', '30.00', '30.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 1, 0, 10, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, 2, '2022-08-17 15:40:06', NULL, NULL, NULL, NULL),
(517, 'PROD-000515', 'MINI PASTILLA POULET PRALINE CHAUD', NULL, 'default.jpg', '790', NULL, '74.17', '89.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(518, 'PROD-000516', 'MINI PASTILLA BOEUF FÃ‰TA Ã‰PINARD CHAUD', '', 'default.jpg', '791', '2022-08-17', '74.17', '89.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 4, 0, 10, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, 2, '2022-08-17 15:39:21', NULL, NULL, NULL, NULL),
(519, 'PROD-000517', 'MINI PASTILLA FRUIT DE MER CHAUD', NULL, 'default.jpg', '792', NULL, '74.17', '89.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(520, 'PROD-000518', 'MINI NEMS JAMBON FROMAGE CHAUD', NULL, 'default.jpg', '793', NULL, '74.17', '89.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(521, 'PROD-000519', 'MINI NEMS TRUFFES/ARTICHAUT CHAUD', NULL, 'default.jpg', '794', NULL, '74.17', '89.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(522, 'PROD-000520', 'MINI NEMS POULET CHAMP FOIE GRAS CHAUD', NULL, 'default.jpg', '795', NULL, '74.17', '89.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(523, 'PROD-000521', 'MINI NEMS BOEUF MENTHE CHAUD', NULL, 'default.jpg', '796', NULL, '74.17', '89.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(524, 'PROD-000522', 'MINI NEMS KEBAB CHAUD', NULL, 'default.jpg', '797', NULL, '74.17', '89.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(525, 'PROD-000523', 'MINI TARTE JAMBON FROMAGE CHAUD', NULL, 'default.jpg', '798', NULL, '74.17', '89.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(526, 'PROD-000524', 'MINI CHAUSSON VH CHAUD', NULL, 'default.jpg', '799', NULL, '74.17', '89.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(527, 'PROD-000525', 'FILM ALIMENTAIRE', NULL, 'default.jpg', '801', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(528, 'PROD-000526', 'SACHET BRETTELLE LA FONDA', NULL, 'default.jpg', '802', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(529, 'PROD-000527', 'SACHET NOIR POUBELLE', NULL, 'default.jpg', '803', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(530, 'PROD-000528', 'SOUS VIDE GRAND', NULL, 'default.jpg', '804', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(531, 'PROD-000529', 'GANTS', NULL, 'default.jpg', '805', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(532, 'PROD-000530', 'PAPIER ALUMINIUM', NULL, 'default.jpg', '806', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(533, 'PROD-000531', 'SOUS VIDE CLIENT', NULL, 'default.jpg', '807', NULL, '1.67', '2.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(534, 'PROD-000532', 'SACHET CLIENTS MM GRATUIT', NULL, 'default.jpg', '810', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(535, 'PROD-000533', 'SACHET CLIENTS GM PAYANT', NULL, 'default.jpg', '811', NULL, '6.25', '7.50', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(536, 'PROD-000534', 'SACHET CLIENT MM PAYANT INF 100DH', NULL, 'default.jpg', '812', NULL, '0.60', '0.72', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(537, 'PROD-000535', 'SACHET CLT GM SUP 1000 GRTAUIT', NULL, 'default.jpg', '813', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(538, 'PROD-000536', 'POLYESTER GM 16', NULL, 'default.jpg', '820', NULL, '29.17', '35.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(539, 'PROD-000537', 'POLYESTER GM 15', NULL, 'default.jpg', '821', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(540, 'PROD-000538', 'POLYESTER MM 12', NULL, 'default.jpg', '822', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(541, 'PROD-000539', 'POLYESTER PM 5', NULL, 'default.jpg', '823', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 0, 0, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(542, 'PROD-000540', 'BRASILIA  WC2014', NULL, 'default.jpg', '840', NULL, '29.17', '35.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(543, 'PROD-000541', 'CANARD ROTI', NULL, 'default.jpg', '887', NULL, '233.33', '280.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(544, 'PROD-000542', 'COQUELET BOULGOUR/NOISETTE', NULL, 'default.jpg', '889', NULL, '133.33', '160.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(545, 'PROD-000543', 'BARQUETTE', NULL, 'default.jpg', '900', NULL, '100.00', '100.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(546, 'PROD-000544', 'CAISSE GM 800X400', NULL, 'default.jpg', '901', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(547, 'PROD-000545', 'CAISSE PM 600X400', NULL, 'default.jpg', '902', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(548, 'PROD-000546', 'CAISSE GRISE', NULL, 'default.jpg', '903', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(549, 'PROD-000547', 'FRAIS TRANSPORT', NULL, 'default.jpg', '912', NULL, '1500.00', '1500.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(550, 'PROD-000548', 'BARQUETTE A1 230*160 P30', NULL, 'default.jpg', '920', NULL, '100.00', '100.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(551, 'PROD-000549', 'BARQUETTE A2 230*160 P40', NULL, 'default.jpg', '921', NULL, '100.00', '100.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(552, 'PROD-000550', 'BARQUETTE B1 190*150 P40', NULL, 'default.jpg', '922', NULL, '100.00', '100.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(553, 'PROD-000551', 'BARQUETTE B2 190*150 P60', NULL, 'default.jpg', '923', NULL, '100.00', '100.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(554, 'PROD-000552', 'BARQUETTE P1 380*300 P40', NULL, 'default.jpg', '924', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 20, 20, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(555, 'PROD-000553', 'BARQUETTE P2 380*300 P60', NULL, 'default.jpg', '925', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(556, 'PROD-000554', 'BARQUETTE P3 320*230 P10', NULL, 'default.jpg', '926', NULL, '0.00', '0.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 1, 0, 10, 0, 0, '', '', '', '1', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(557, 'PROD-000555', 'SACHET ARGENTE', '', 'default.jpg', '927', '2022-09-06', '1.50', '1.50', '0.00', '0.00', '0.00', 1, 2, 2, 9, 28, 4, -0.111, 10, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, NULL, NULL, 2, '2022-12-17 19:14:56', NULL, NULL, NULL, NULL),
(558, 'PROD-000556', 'COFFRET 1 (1BUCHE/1DINDE SUCREE/1TERINE/1MOUSSE)', NULL, 'default.jpg', '950', NULL, '791.67', '950.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(559, 'PROD-000557', 'COFFRET 2(1BUCHE/1DINDE SALEE/1TERINE/1MOUSSE)', NULL, 'default.jpg', '951', NULL, '791.67', '950.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(560, 'PROD-000558', 'COFFRET 3 (1BUCHE/1PLATEAU/1/KOULIBIAK/2SALADES)', NULL, 'default.jpg', '952', NULL, '708.33', '850.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(561, 'PROD-000559', 'COFFRET 4 (1BUCHE/1PLATEAU/1/WELLINTON/2SALADES)', NULL, 'default.jpg', '953', NULL, '791.67', '950.00', '0.00', '0.00', '0.00', 1, 2, 2, NULL, NULL, 4, 0, 10, 20, 20, '', '', '', '0', '', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(562, 'PROD-000560', 'TETE D\'AGNEAU', '', 'default.jpg', '992', '2022-08-17', '75.00', '75.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 19, 4, -2, 10, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, 2, '2022-08-17 15:35:47', NULL, NULL, NULL, NULL),
(563, 'PROD-000561', 'CREPINE', '', 'default.jpg', '993', '2022-06-30', '60.00', '60.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 19, 1, 0, 10, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, 2, '2022-06-30 17:20:55', NULL, NULL, NULL, NULL),
(564, 'PROD-000562', 'RATE DE VEAU', '', 'default.jpg', '995', '2022-08-17', '100.00', '100.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 19, 4, 0, 10, 0, 0, '', '', '', '0', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, 2, '2022-08-17 15:34:45', NULL, NULL, NULL, NULL),
(565, 'PROD-000563', 'RIS DE VEAU', '', 'default.jpg', '996', '2022-08-17', '100.00', '100.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 19, 1, 0, 10, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, 2, '2022-08-17 15:35:22', NULL, NULL, NULL, NULL),
(566, 'PROD-000564', 'GAMME FANTAISIE', '', 'default.jpg', '999', '2022-06-30', '100.00', '120.00', '0.00', '0.00', '0.00', 1, 2, 2, 4, 11, 1, 0, 10, 20, 20, '', '', '', '1', 'auto', '', '', '1.000', NULL, NULL, NULL, 0, NULL, NULL, 2, '2022-06-30 17:41:52', NULL, NULL, NULL, NULL),
(567, 'PROD-000566', 'FOIE TRANCHE MARINE', '', 'default.jpg', '166', '2022-08-01', '189.00', '199.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 19, 1, -12.714, 10, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 2, '2022-08-01 16:59:05', 2, '2023-04-27 14:56:33', NULL, NULL, NULL, NULL),
(568, 'PROD-000567', 'FOIE AGNEAU MARINÃ‰', '', 'default.jpg', '200', '2022-08-17', '189.00', '189.00', '0.00', '189.00', '0.00', 1, 2, 2, 8, 19, 1, 0, 10, 0, 0, '', '', '', '1', 'auto', '', '', '0.250', 0, NULL, NULL, 0, 2, '2022-08-17 15:33:15', 2, '2023-01-24 10:46:29', NULL, NULL, NULL, NULL),
(569, 'PROD-000568', 'SACHET SSV 400x500', '', 'default.jpg', '027', '2022-09-06', '2.50', '10.00', '0.00', '2.50', '0.00', 1, 2, 2, 9, 28, 4, 0, 10, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 2, '2022-09-06 14:31:24', 2, '2022-12-17 19:15:41', NULL, NULL, NULL, NULL),
(570, 'PROD-000569', 'SACHET SSV 200x300', '', 'default.jpg', '028', '2022-09-06', '1.50', '1.50', '0.00', '2.50', '0.00', 1, 2, 2, 9, 28, 4, 0, 10, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 2, '2022-09-06 14:32:12', 2, '2022-12-17 19:16:06', NULL, NULL, NULL, NULL),
(571, 'PROD-000570', 'SACHET SSV 200x400', '', 'default.jpg', '029', '2022-09-06', '2.50', '3.00', '0.00', '2.50', '0.00', 1, 2, 2, 9, 28, 4, 0, 10, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 2, '2022-09-06 14:33:29', 2, '2022-12-07 08:48:26', NULL, NULL, NULL, NULL),
(572, 'PROD-000571', 'DINDE FARCIE SALEE CHAUD', '', 'default.jpg', '221', '2022-12-22', '141.67', '170.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 7, 1, 0, 10, 20, 20, '', '', '', '1', 'auto', '', '', '5.500', 0, NULL, NULL, 0, 2, '2022-12-22 07:23:12', 2, '2022-12-28 11:34:03', NULL, NULL, NULL, NULL),
(573, 'PROD-000572', 'DINDE FARCIE SUCREE CHAUD', '', 'default.jpg', '222', '2022-12-22', '145.00', '174.00', '0.00', '0.00', '0.00', 1, 2, 2, 3, 7, 1, 0, 10, 20, 20, '', '', '', '1', 'auto', '', '', '5.500', 0, NULL, NULL, 0, 2, '2022-12-22 07:23:12', 2, '2022-12-28 11:33:43', NULL, NULL, NULL, NULL),
(574, 'PROD-000573', 'PASTILLA BOEUF FÃ‰TA Ã‰PINARD X 12', '', 'default.jpg', '299', '2022-12-22', '1250.00', '1600.00', '0.00', '0.00', '0.00', 1, 2, 2, 2, 4, 4, -2, 10, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 2, '2022-12-22 07:23:12', 2, '2023-04-06 09:36:48', NULL, NULL, NULL, NULL),
(575, 'PROD-000574', 'PATE VOLAILLE TRUFFE 150 GR', '', 'default.jpg', '377', '2022-12-22', '32.50', '39.00', '0.00', '0.00', '0.00', 1, 2, 2, 1, 2, 4, 0, 10, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 2, '2022-12-22 07:23:12', 2, '2022-12-26 13:25:44', NULL, NULL, NULL, NULL),
(591, 'PROD-000590', 'BUCHE SAUMON PORTION', '', 'default.jpg', '474', '2023-01-07', '73.33', '88.00', '0.00', '73.33', '0.00', 1, 2, 2, 4, 11, 4, 0, 10, 20, 20, '', '', '', '0', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 2, '2023-01-07 17:01:27', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `reference` text NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `montant` float DEFAULT NULL,
  `date_limite` datetime NOT NULL,
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `remiseclients`
--

CREATE TABLE `remiseclients` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `produit_id` int(11) NOT NULL,
  `nb_kilos` float DEFAULT NULL,
  `montant` float NOT NULL,
  `montant_ticket` float DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) NOT NULL,
  `date_c` datetime NOT NULL,
  `user_u` int(11) NOT NULL,
  `date_u` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `retourdetails`
--

CREATE TABLE `retourdetails` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `retour_id` int(11) DEFAULT NULL,
  `categorieproduit_id` int(11) DEFAULT NULL,
  `declaration` int(11) DEFAULT '1',
  `description` varchar(255) DEFAULT NULL,
  `qte` decimal(10,3) DEFAULT NULL,
  `prixachat` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `retours`
--

CREATE TABLE `retours` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `avoir_id` int(11) DEFAULT NULL,
  `etat` int(11) DEFAULT '-1',
  `total_qte` int(11) DEFAULT NULL,
  `total_a_payer` decimal(10,2) DEFAULT '0.00',
  `total_paye` decimal(10,2) DEFAULT '0.00',
  `reste_a_payer` decimal(10,2) DEFAULT '0.00',
  `total_apres_reduction` decimal(10,2) DEFAULT '0.00',
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `date_validation` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(10) NOT NULL,
  `libelle` varchar(25) NOT NULL,
  `created` datetime NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `libelle`, `created`, `deleted`) VALUES
(1, 'Super admin', '2018-02-13 23:00:02', 0),
(2, 'Administrateurs', '2018-02-13 23:00:02', 0),
(4, 'Caissiers', '2019-04-10 20:47:17', 0),
(5, 'Livreurs', '2020-08-20 17:11:15', 0),
(6, 'Gérnat', '2021-12-27 13:13:55', 0),
(8, 'Bouchers', '2021-12-27 16:48:11', 0),
(9, 'ECOM', '2022-01-31 15:51:59', 0),
(10, 'Vendeurs', '2023-01-25 15:14:32', 0);

-- --------------------------------------------------------

--
-- Structure de la table `salepointdetails`
--

CREATE TABLE `salepointdetails` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `salepoint_id` int(11) DEFAULT NULL,
  `commandedetail_id` int(11) DEFAULT NULL,
  `ecommercedetail_id` int(11) DEFAULT NULL,
  `categorieproduit_id` int(11) DEFAULT NULL,
  `qte_cmd` decimal(10,3) DEFAULT NULL,
  `qte` decimal(10,3) DEFAULT NULL,
  `prix_vente` decimal(10,2) DEFAULT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL,
  `marge` decimal(10,2) DEFAULT NULL,
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT NULL,
  `stat` int(11) NOT NULL DEFAULT '-1',
  `onhold` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `glovodetail_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `salepointdetails`
--

INSERT INTO `salepointdetails` (`id`, `produit_id`, `client_id`, `salepoint_id`, `commandedetail_id`, `ecommercedetail_id`, `categorieproduit_id`, `qte_cmd`, `qte`, `prix_vente`, `unit_price`, `total`, `ttc`, `marge`, `remise`, `montant_remise`, `stat`, `onhold`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`, `glovodetail_id`) VALUES
(1, 6, NULL, 1, NULL, NULL, NULL, NULL, '0.501', '172.00', '0.00', '86.17', '86.17', NULL, '0.00', '0.00', -1, -1, 0, 1, '2023-06-12 12:37:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `salepoints`
--

CREATE TABLE `salepoints` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `barecode` varchar(50) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `commande_id` int(11) DEFAULT NULL,
  `ecommerce_id` int(11) DEFAULT NULL,
  `glovo_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `etat` int(11) DEFAULT NULL,
  `paye` int(11) DEFAULT '-1',
  `onhold` int(11) NOT NULL DEFAULT '-1',
  `type_vente` int(11) NOT NULL DEFAULT '-1',
  `print` int(11) NOT NULL DEFAULT '-1',
  `total_a_payer_ht` decimal(10,2) DEFAULT '0.00',
  `total_a_payer_ttc` decimal(10,2) DEFAULT '0.00',
  `total_paye` decimal(10,2) DEFAULT '0.00',
  `reste_a_payer` decimal(10,2) DEFAULT '0.00',
  `total_apres_reduction` decimal(10,2) DEFAULT '0.00',
  `total_cmd` decimal(10,3) DEFAULT NULL,
  `montant_remise` decimal(10,2) DEFAULT '0.00',
  `remise` decimal(10,2) DEFAULT NULL,
  `montant_tva` decimal(10,2) DEFAULT NULL,
  `rendu` decimal(10,2) DEFAULT NULL,
  `fee` int(11) NOT NULL,
  `expedition` varchar(200) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `store` int(11) NOT NULL,
  `caisse_id` int(11) NOT NULL,
  `payment_method` varchar(60) NOT NULL,
  `boucher` varchar(100) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `msg_api` text NOT NULL,
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `sync` int(11) NOT NULL DEFAULT '0',
  `flag_retour` int(11) NOT NULL DEFAULT '0',
  `mnt_bonachat` float DEFAULT NULL,
  `points_fidelite` float DEFAULT '0',
  `check_cad` int(11) NOT NULL DEFAULT '0',
  `id_chequecadeau` int(11) DEFAULT NULL,
  `mnt_chequecad` float DEFAULT NULL,
  `id_bon_achat` int(11) DEFAULT NULL,
  `id_cheque_cad` int(11) DEFAULT NULL,
  `check_mode` int(11) NOT NULL DEFAULT '0',
  `remise_glob` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `salepoints`
--

INSERT INTO `salepoints` (`id`, `reference`, `barecode`, `client_id`, `commande_id`, `ecommerce_id`, `glovo_id`, `depot_id`, `etat`, `paye`, `onhold`, `type_vente`, `print`, `total_a_payer_ht`, `total_a_payer_ttc`, `total_paye`, `reste_a_payer`, `total_apres_reduction`, `total_cmd`, `montant_remise`, `remise`, `montant_tva`, `rendu`, `fee`, `expedition`, `user_id`, `date`, `store`, `caisse_id`, `payment_method`, `boucher`, `deleted`, `msg_api`, `user_c`, `date_c`, `user_u`, `date_u`, `sync`, `flag_retour`, `mnt_bonachat`, `points_fidelite`, `check_cad`, `id_chequecadeau`, `mnt_chequecad`, `id_bon_achat`, `id_cheque_cad`, `check_mode`, `remise_glob`) VALUES
(1, 'I2-Prov-000001', NULL, NULL, NULL, NULL, NULL, NULL, 1, -1, -1, -1, -1, '86.17', '86.17', '86.17', '86.17', '86.17', '0.000', '0.00', '0.00', '0.00', NULL, 0, '', 1, '2023-06-05 00:00:00', 0, 5, '', '2900858000017', 0, '', 1, '2023-06-12 11:36:00', 1, '2023-06-12 12:37:09', 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `segments`
--

CREATE TABLE `segments` (
  `id` int(11) NOT NULL,
  `libelle` varchar(250) DEFAULT NULL,
  `reference` varchar(250) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `segments`
--

INSERT INTO `segments` (`id`, `libelle`, `reference`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'Take away', 'SG-000001', 0, 1, '2021-02-27 00:52:15', NULL, NULL),
(2, 'Drivefood', 'SG-000002', 0, 1, '2021-02-27 00:52:23', NULL, NULL),
(3, 'Home delivery', 'SG-000003', 0, 1, '2021-02-27 00:52:31', NULL, NULL),
(4, 'Sur place', 'SG-000004', 0, 1, '2021-02-27 00:52:39', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sessionusers`
--

CREATE TABLE `sessionusers` (
  `id` int(11) NOT NULL,
  `reference` varchar(60) NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `caisse_id` int(11) NOT NULL,
  `chiffre_affaire` decimal(20,2) DEFAULT NULL,
  `print` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sessionusers`
--

INSERT INTO `sessionusers` (`id`, `reference`, `date_debut`, `date_fin`, `user_id`, `site_id`, `caisse_id`, `chiffre_affaire`, `print`, `deleted`) VALUES
(1, 'Session-000001', '2023-06-12 11:36:58', NULL, 1, 17, 5, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `societes`
--

CREATE TABLE `societes` (
  `id` int(10) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `capital` decimal(10,2) DEFAULT NULL,
  `tva` int(11) DEFAULT '20',
  `type` int(11) NOT NULL DEFAULT '1',
  `date` date DEFAULT NULL,
  `pdfmodele_id` int(11) DEFAULT NULL,
  `idfiscale` varchar(200) DEFAULT NULL,
  `cnss` varchar(200) DEFAULT NULL,
  `registrecommerce` varchar(200) DEFAULT NULL,
  `patent` varchar(200) DEFAULT NULL,
  `ice` varchar(200) DEFAULT NULL,
  `dg` varchar(200) DEFAULT NULL,
  `contact` varchar(200) DEFAULT NULL,
  `adresse` varchar(200) DEFAULT NULL,
  `telfixe` varchar(200) DEFAULT NULL,
  `telmobile` varchar(200) DEFAULT NULL,
  `fax` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `nature` varchar(200) DEFAULT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `fournisseur_id` int(11) DEFAULT NULL,
  `contact_service` varchar(200) DEFAULT NULL,
  `contact_assistance` varchar(200) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `societes`
--

INSERT INTO `societes` (`id`, `designation`, `capital`, `tva`, `type`, `date`, `pdfmodele_id`, `idfiscale`, `cnss`, `registrecommerce`, `patent`, `ice`, `dg`, `contact`, `adresse`, `telfixe`, `telmobile`, `fax`, `email`, `website`, `nature`, `avatar`, `client_id`, `fournisseur_id`, `contact_service`, `contact_assistance`, `created`, `updated`, `deleted`) VALUES
(1, 'I.A.F SARL', NULL, 20, 1, '2021-02-23', 1, '2220093', '', '83863', '', '001534231000001', '', 'Lorem ipsum dolor', '58 , BRAHIM, NAKHAI N 58 MAARIF CASABLANCA', '0123123123', '0123123123', '', '', '', 'LOT 339 LOTISSEMENT LINA SIDI MAAROUF', '/img\\logo\\1-25.jpg', 84, 4, '03030330', '123123', '2014-11-13 10:07:04', '2022-03-26 17:19:56', 0),
(2, 'DVIAM', NULL, 20, 1, '2021-02-26', 1, '1105131', '', ' 159085', '', '001534351000059', '', 'Lorem ipsum', 'adresse de test', '052342342342', '06234234234', '', '', '', 'BOUCHERIE EN DETAIL DES PRODUITS DE LA VIANDE', '/img\\logo\\2-18.jpg', 83, 8, NULL, NULL, '2021-02-26 16:27:10', '2023-01-24 20:18:29', 0),
(3, 'NDV SARL', NULL, 20, 2, '2021-02-01', 1, '2264531', '', '204499', '', '000191755000087', '', 'Lorem ipsum dolor', 'Lorem ipsum dolor', '', '', '', '', '', 'BOUCHERIE EN DETAIL DES PRODUITS DE LA VIANDE', '/img\\logo\\3-18.jpg', 82, 6, NULL, NULL, '2021-02-26 16:29:58', '2023-01-24 20:18:53', 0),
(4, 'ADV', NULL, 20, 1, '2021-11-23', 1, ' 1108512', '', '180791', '', '001347900000033', '', '', '', '', '', '', '', '', 'VENTE EN DETAIL DES PRODUITS DE LA VIANDE', '/img\\logo\\4-23.jpg', 85, 5, NULL, NULL, '2021-11-23 13:39:02', '2022-03-26 17:19:35', 0),
(5, 'T.M SARL', NULL, 20, 1, '2021-11-23', 1, '20713206', '', '365139', '', '001803052000053', '', '', '', '', '', '', '', '', 'VENTE EN DETAIL DES PRODUITS DE LA VIANDE', '/img\\logo\\5-19.jpg', 86, 7, NULL, NULL, '2021-11-23 13:39:26', '2023-01-24 20:19:06', 0);

-- --------------------------------------------------------

--
-- Structure de la table `sortiedetails`
--

CREATE TABLE `sortiedetails` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `num_lot` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `prix_achat` decimal(10,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `date_sortie` date DEFAULT NULL,
  `stock_source` float DEFAULT NULL,
  `paquet_source` int(11) DEFAULT NULL,
  `total_general` int(11) DEFAULT NULL,
  `stock_destination` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `depot_source_id` int(11) DEFAULT NULL,
  `depot_destination_id` int(11) DEFAULT NULL,
  `vente_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `retour_id` int(11) DEFAULT NULL,
  `fournisseur_id` int(11) DEFAULT NULL,
  `operation` int(11) NOT NULL DEFAULT '-1',
  `returned` int(11) NOT NULL DEFAULT '-1',
  `id_mouvementprincipal` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sortiedetails`
--

INSERT INTO `sortiedetails` (`id`, `reference`, `num_lot`, `description`, `prix_achat`, `date`, `date_sortie`, `stock_source`, `paquet_source`, `total_general`, `stock_destination`, `produit_id`, `client_id`, `depot_source_id`, `depot_destination_id`, `vente_id`, `facture_id`, `retour_id`, `fournisseur_id`, `operation`, `returned`, `id_mouvementprincipal`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'SD-000001', NULL, 'Motifo', NULL, '2023-06-10', '2023-06-10', 0.501, NULL, NULL, NULL, 6, NULL, 11, 10, NULL, NULL, NULL, NULL, 1, -1, 1, 0, 1, '2023-06-10 17:20:38', NULL, NULL),
(2, 'SD-000002', NULL, 'Motifo', NULL, '2023-06-10', '2023-06-10', 0.501, NULL, NULL, NULL, 7, NULL, 11, 10, NULL, NULL, NULL, NULL, 1, -1, 1, 0, 1, '2023-06-10 17:20:38', NULL, NULL),
(3, 'SD-000003', '', '2900109005011', NULL, '2023-06-10', '2023-06-10', 1.801, NULL, NULL, NULL, 6, NULL, 3, 10, NULL, NULL, NULL, NULL, 1, -1, 2, 0, 1, '2023-06-10 17:24:02', 1, '2023-06-10 18:00:36'),
(4, 'SD-000004', NULL, '2900274000011', NULL, '2023-06-10', '2023-06-10', 1, NULL, NULL, NULL, 115, NULL, 3, 10, NULL, NULL, NULL, NULL, 1, -1, 3, 0, 1, '2023-06-10 18:06:14', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `souscategorieproduits`
--

CREATE TABLE `souscategorieproduits` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `categorieproduit_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `souscategorieproduits`
--

INSERT INTO `souscategorieproduits` (`id`, `libelle`, `categorieproduit_id`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'Jambon & Galantine', 1, 0, 2, '2021-11-23 13:22:35', NULL, NULL),
(2, 'PatÃ© & Terrine', 1, 0, 2, '2021-11-23 13:22:49', NULL, NULL),
(3, 'SechÃ© & SechÃ©', 1, 0, 2, '2021-11-23 13:23:03', NULL, NULL),
(4, 'Pastilla & Nems', 2, 0, 2, '2021-11-23 13:23:55', NULL, NULL),
(5, 'Tarte SalÃ©e & Friand', 2, 0, 2, '2021-11-23 13:24:11', NULL, NULL),
(6, 'Beldi Signature', 3, 0, 2, '2021-11-23 13:25:00', NULL, NULL),
(7, 'Farci', 3, 0, 2, '2021-11-23 13:25:40', NULL, NULL),
(8, 'Ravioli & Gratin', 3, 0, 2, '2021-11-23 13:25:56', NULL, NULL),
(9, 'RÃ´ti', 3, 0, 2, '2021-11-23 13:26:08', NULL, NULL),
(10, 'Sauce Culinaire & Dip', 3, 0, 2, '2021-11-23 13:26:24', NULL, NULL),
(11, 'Plats Festifs & RÃ©ception', 4, 0, 2, '2021-11-23 13:27:15', NULL, NULL),
(12, 'A RÃ´tir', 5, 0, 2, '2021-11-23 13:27:47', NULL, NULL),
(13, 'HachÃ©s', 5, 0, 2, '2021-11-23 13:27:59', NULL, NULL),
(14, 'MarinÃ©s & Wok', 5, 0, 2, '2021-11-23 13:28:14', NULL, NULL),
(15, 'PannÃ©', 5, 0, 2, '2021-11-23 13:28:32', NULL, NULL),
(16, 'Saucisserie', 6, 0, 2, '2021-11-23 13:29:12', NULL, NULL),
(17, 'DÃ©coupe de Volaille', 7, 0, 2, '2021-11-23 13:29:43', NULL, NULL),
(18, 'Volaille EvidÃ©e', 7, 0, 2, '2021-11-23 13:29:58', NULL, NULL),
(19, 'Abats', 8, 0, 2, '2021-11-23 13:30:20', NULL, NULL),
(20, 'Agneau', 8, 0, 2, '2021-11-23 13:30:33', NULL, NULL),
(21, 'BÅ“uf', 8, 0, 2, '2021-11-23 13:30:45', 1, '2022-02-07 08:36:22'),
(22, 'Veau', 8, 0, 2, '2021-11-23 13:30:56', 2, '2021-11-26 07:35:37'),
(27, 'Salades', 1, 0, 2, '2021-12-03 14:15:53', 2, '2021-12-03 14:17:08'),
(28, 'Consommables', 9, 0, 2, '2022-02-04 21:54:37', NULL, NULL),
(29, 'Fournitures', 9, 0, 2, '2022-02-04 21:54:49', NULL, NULL),
(30, 'MÃ©dicales', 9, 0, 2, '2022-02-04 21:55:33', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `reference` varchar(250) DEFAULT NULL,
  `libelle` varchar(250) DEFAULT NULL,
  `adresse` varchar(250) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `societe_id` int(11) DEFAULT NULL,
  `id_ecommerce` int(11) DEFAULT NULL,
  `adresses_ip` text,
  `frais_livraison` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `ville` varchar(255) NOT NULL,
  `pays` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `numero_tp` varchar(255) NOT NULL,
  `code_journal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stores`
--

INSERT INTO `stores` (`id`, `reference`, `libelle`, `adresse`, `date`, `type`, `societe_id`, `id_ecommerce`, `adresses_ip`, `frais_livraison`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`, `ville`, `pays`, `tel`, `numero_tp`, `code_journal`) VALUES
(1, 'ST-000001', 'PV MLY DRISS', '98 BD MLY DRISS 1ER ENTRESOL', NULL, 2, 5, 13, '192.168.1', 2, 0, 1, '2021-02-22 23:53:02', 2, '2022-02-12 12:47:46', 'CASABLANCA', 'Maroc', '06 66 27 51 18 \\ 05 22 862 567 ', '34401276', 'VTS'),
(10, 'ST-000010', 'PV ANFA', '70 RUE AHMED CHARCI ', NULL, 2, 1, 9, '192.168.3', 4, 0, 2, '2021-11-23 14:08:12', 2, '2022-02-12 12:48:05', 'CASABLANCA', 'MAROC', '06 67 01 08 82 \\ 05 22 36 58 44', '35607287', 'VTA'),
(11, 'ST-000011', 'PV GAUTHIER', '61 AV. MOUSSA IBNOU NOUSSAIR', NULL, 2, 1, 11, '192.168.2', 4, 0, 2, '2021-11-23 14:09:10', 2, '2022-02-12 12:48:09', 'CASABLANCA', 'MAROC', '06 62 07 38 75 \\ 05 22 485 135', '35550035', 'VTG'),
(12, 'ST-000012', 'PV TANGER', 'SAHAT EL OMAME EL MOUTAHIDA', NULL, 2, 3, 18, '192.168.12', 2, 0, 2, '2021-11-23 14:10:22', 2, '2022-02-12 12:47:08', 'TANGER', 'MAROC', '06 66 17 47 74 ', '', '1'),
(14, 'ST-000014', 'PV FES', '12 RUE 22 AVENUE MY ELKAMEL', NULL, 2, 3, 17, '192.168.8', 2, 0, 2, '2021-11-23 14:13:02', 2, '2022-02-12 12:46:58', 'FES', 'MAROC', '06 66 27 55 41 \\ 05 35 653 096 ', '13612432', 'VTF'),
(15, 'ST-000015', 'PV RABAT', '15 BD ANNAKHIL ', NULL, 2, 2, 15, '192.168.4', 2, 0, 2, '2021-11-23 14:14:15', 2, '2022-02-12 12:46:19', 'RABAT', 'MAROC', '06 67 01 15 22 \\ 05 37 570 380 ', '25563479', 'VTR'),
(16, 'ST-000016', 'PV CALIFORNIE', '180 ROUTE TADDART', NULL, 2, 4, 10, '192.168.7', 2, 0, 2, '2021-11-23 14:15:15', 2, '2022-02-18 17:05:21', 'CASABLANCA', 'MAROC', '06 67 01 63 62 \\ 05 22 819 313 ', '3635089', 'VTT'),
(17, 'ST-000017', 'PV BELVEDERE', 'BD EMILE ZOLA ', NULL, 2, 4, 12, '41.250.154.15', 2, 0, 2, '2021-11-23 14:16:08', 2, '2022-02-17 13:29:25', 'CASABLANCA', 'MAROC', '06 67 02 45 95 \\ 05 22 405 969', '37946936', 'VTB'),
(18, 'ST-000018', 'PV GUELIZ', 'ANGLE, AV MV & BAQUAL BATOUL ', NULL, 2, 2, 16, '105.155.158.22', 4, 0, 2, '2021-11-23 14:17:37', 2, '2022-02-12 12:46:06', 'MARRAKECH', 'MAROC', '06 66 27 32 75 \\ 05 24 423 992  ', '45166874', 'VTM'),
(19, 'ST-000010', 'USINE', 'LOTISSEMENT 503 ZONE INDUSTRIELLE SAPINO NOUACER ', NULL, 2, 1, 8, '105.155.158.20', 4, 0, 2, '2021-11-26 09:05:58', 2, '2022-02-17 13:01:55', 'CASABLANCA', 'MAROC', '05 22 370 370', '', ''),
(20, 'ST-000011', 'PV MARINA', 'MARINA BEACH', NULL, 2, 3, 18, '105.155.158.66', 4, 0, 2, '2022-05-30 17:34:06', NULL, NULL, 'M\'DIQ', 'MAROC', '0', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `stores_users`
--

CREATE TABLE `stores_users` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `stores_users`
--

INSERT INTO `stores_users` (`id`, `store_id`, `user_id`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 12, 12, 0, NULL, NULL, NULL, NULL),
(2, 17, 79, 0, NULL, NULL, NULL, NULL),
(3, 16, 79, 0, NULL, NULL, NULL, NULL),
(4, 14, 79, 0, NULL, NULL, NULL, NULL),
(5, 11, 79, 0, NULL, NULL, NULL, NULL),
(6, 18, 79, 0, NULL, NULL, NULL, NULL),
(7, 1, 79, 0, NULL, NULL, NULL, NULL),
(8, 15, 79, 0, NULL, NULL, NULL, NULL),
(9, 12, 79, 0, NULL, NULL, NULL, NULL),
(10, 19, 79, 0, NULL, NULL, NULL, NULL),
(11, 16, 78, 0, NULL, NULL, NULL, NULL),
(36, 16, 57, 0, NULL, NULL, NULL, NULL),
(37, 10, 80, 0, NULL, NULL, NULL, NULL),
(38, 17, 80, 0, NULL, NULL, NULL, NULL),
(39, 16, 80, 0, NULL, NULL, NULL, NULL),
(40, 14, 80, 0, NULL, NULL, NULL, NULL),
(41, 11, 80, 0, NULL, NULL, NULL, NULL),
(42, 18, 80, 0, NULL, NULL, NULL, NULL),
(43, 1, 80, 0, NULL, NULL, NULL, NULL),
(44, 15, 80, 0, NULL, NULL, NULL, NULL),
(45, 12, 80, 0, NULL, NULL, NULL, NULL),
(46, 19, 80, 0, NULL, NULL, NULL, NULL),
(59, 16, 58, 0, NULL, NULL, NULL, NULL),
(81, 11, 67, 0, NULL, NULL, NULL, NULL),
(85, 11, 70, 0, NULL, NULL, NULL, NULL),
(86, 1, 61, 0, NULL, NULL, NULL, NULL),
(88, 17, 63, 0, NULL, NULL, NULL, NULL),
(91, 17, 60, 0, NULL, NULL, NULL, NULL),
(92, 10, 59, 0, NULL, NULL, NULL, NULL),
(99, 15, 64, 0, NULL, NULL, NULL, NULL),
(101, 14, 65, 0, NULL, NULL, NULL, NULL),
(106, 12, 68, 0, NULL, NULL, NULL, NULL),
(110, 10, 83, 0, NULL, NULL, NULL, NULL),
(111, 12, 77, 0, NULL, NULL, NULL, NULL),
(113, 15, 74, 0, NULL, NULL, NULL, NULL),
(114, 10, 73, 0, NULL, NULL, NULL, NULL),
(115, 16, 82, 0, NULL, NULL, NULL, NULL),
(116, 17, 72, 0, NULL, NULL, NULL, NULL),
(117, 1, 71, 0, NULL, NULL, NULL, NULL),
(120, 18, 66, 0, NULL, NULL, NULL, NULL),
(127, 15, 86, 0, NULL, NULL, NULL, NULL),
(128, 10, 87, 0, NULL, NULL, NULL, NULL),
(129, 14, 87, 0, NULL, NULL, NULL, NULL),
(131, 18, 85, 0, NULL, NULL, NULL, NULL),
(132, 17, 2, 0, NULL, NULL, NULL, NULL),
(135, 11, 12, 0, NULL, NULL, NULL, NULL),
(136, 10, 88, 0, NULL, NULL, NULL, NULL),
(137, 17, 88, 0, NULL, NULL, NULL, NULL),
(138, 16, 88, 0, NULL, NULL, NULL, NULL),
(139, 20, 2, 0, NULL, NULL, NULL, NULL),
(140, 17, 84, 0, NULL, NULL, NULL, NULL),
(141, 10, 1, 0, NULL, NULL, NULL, NULL),
(142, 17, 1, 0, NULL, NULL, NULL, NULL),
(143, 16, 1, 0, NULL, NULL, NULL, NULL),
(144, 14, 1, 0, NULL, NULL, NULL, NULL),
(145, 11, 1, 0, NULL, NULL, NULL, NULL),
(146, 18, 1, 0, NULL, NULL, NULL, NULL),
(147, 20, 1, 0, NULL, NULL, NULL, NULL),
(148, 1, 1, 0, NULL, NULL, NULL, NULL),
(149, 15, 1, 0, NULL, NULL, NULL, NULL),
(150, 12, 1, 0, NULL, NULL, NULL, NULL),
(151, 19, 1, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `synchronisations`
--

CREATE TABLE `synchronisations` (
  `id` int(11) NOT NULL,
  `source` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  `module` varchar(100) NOT NULL,
  `user_created` int(10) NOT NULL,
  `date_c` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Pour suivre les différentes synchronisations entre les modul';

-- --------------------------------------------------------

--
-- Structure de la table `t09s`
--

CREATE TABLE `t09s` (
  `id` int(11) NOT NULL,
  `reference` text NOT NULL,
  `montant` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `caisse_id` int(11) NOT NULL,
  `user_c` int(11) NOT NULL,
  `date_c` datetime NOT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `nbr_persons` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tables`
--

INSERT INTO `tables` (`id`, `reference`, `libelle`, `nbr_persons`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'TBL-000001', 'Table 1', 10, 0, 2, '2021-06-03 00:32:25', 2, '2021-06-17 23:32:01'),
(2, 'TBL-000002', 'Table 2', 8, 0, 2, '2021-06-03 00:32:31', 2, '2021-06-17 23:31:57'),
(3, 'TBL-000003', 'Table 3', 3, 0, 2, '2021-06-03 00:32:37', 2, '2021-06-17 23:31:52'),
(4, 'TBL-000004', 'Table 4', 5, 0, 2, '2021-06-03 00:32:41', 2, '2021-06-17 23:31:45');

-- --------------------------------------------------------

--
-- Structure de la table `testo`
--

CREATE TABLE `testo` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `testo`
--

INSERT INTO `testo` (`id`, `name`) VALUES
(21, 'D exemple de donnÃ©e okkk'),
(22, 'ON'),
(23, 'ON'),
(24, 'VEN');

-- --------------------------------------------------------

--
-- Structure de la table `transformationdetails`
--

CREATE TABLE `transformationdetails` (
  `id` int(11) NOT NULL,
  `transformation_id` int(11) DEFAULT NULL,
  `produit_a_transformer_id` int(11) DEFAULT NULL,
  `quantite_a_transformer` decimal(10,3) NOT NULL DEFAULT '0.000',
  `produit_transforme_id` int(11) DEFAULT NULL,
  `quantite_transforme` decimal(10,3) NOT NULL DEFAULT '0.000',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `done` int(11) NOT NULL DEFAULT '-1',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `transformations`
--

CREATE TABLE `transformations` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `quantite` decimal(10,3) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `statut` int(11) NOT NULL DEFAULT '-1',
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tvas`
--

CREATE TABLE `tvas` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `valeur` decimal(10,2) DEFAULT NULL,
  `achat` decimal(10,2) DEFAULT NULL,
  `vente` decimal(10,2) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tvas`
--

INSERT INTO `tvas` (`id`, `reference`, `libelle`, `valeur`, `achat`, `vente`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'TVA-000001', '0%', '0.00', NULL, NULL, 0, 1, '2021-03-09 22:45:36', NULL, NULL),
(2, 'TVA-000002', '7%', '7.00', NULL, NULL, 0, 1, '2021-03-09 22:45:47', NULL, NULL),
(3, 'TVA-000003', '10%', '10.00', NULL, NULL, 0, 1, '2021-03-09 22:45:55', NULL, NULL),
(4, 'TVA-000004', '14%', '14.00', NULL, NULL, 0, 1, '2021-03-09 22:46:41', NULL, NULL),
(5, 'TVA-000005', '20%', '20.00', '20.00', '20.00', 0, 1, '2021-03-09 22:46:49', 2, '2021-08-17 22:17:03'),
(6, 'TVA-000006', '50%', '50.00', '50.00', '50.00', 1, 2, '2021-08-17 22:17:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `typecommandes`
--

CREATE TABLE `typecommandes` (
  `id` int(11) NOT NULL,
  `libelle` varchar(250) DEFAULT NULL,
  `reference` varchar(250) DEFAULT NULL,
  `color` varchar(250) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `typecommandes`
--

INSERT INTO `typecommandes` (`id`, `libelle`, `reference`, `color`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'Take away', 'TC-000001', '#d6df46', 0, 2, '2021-06-20 13:18:41', 2, '2021-06-20 13:52:34'),
(2, 'Drivefood', 'TC-000002', '#e34c4c', 0, 2, '2021-06-20 13:18:58', 2, '2021-06-20 13:52:24'),
(3, 'Home delivery', 'TC-000003', '#25ae2f', 0, 2, '2021-06-20 13:19:12', 2, '2021-06-20 13:52:13'),
(4, 'Sur place', 'TC-000004', '#8127c9', 0, 2, '2021-06-20 13:19:23', 2, '2021-06-20 13:52:03');

-- --------------------------------------------------------

--
-- Structure de la table `typeconditionnements`
--

CREATE TABLE `typeconditionnements` (
  `id` int(11) NOT NULL,
  `code_type` varchar(255) DEFAULT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `deleted` int(11) DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime(6) DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `typeconditionnements`
--

INSERT INTO `typeconditionnements` (`id`, `code_type`, `libelle`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(4, '300', '300 G', 0, 2, '2021-11-25 14:20:10.000000', NULL, NULL),
(3, '250', '250 G', 0, 2, '2021-11-25 14:20:10.000000', NULL, NULL),
(2, '180', '180 G', 0, 2, '2021-11-25 14:20:10.000000', NULL, NULL),
(1, '150', '150 G', 0, 2, '2021-11-25 14:20:10.000000', 2, '2021-11-25 14:20:10.000000'),
(5, '330', '330 G', 0, 2, '2021-11-25 14:20:10.000000', NULL, NULL),
(6, '370', '370 G', 0, 2, '2021-11-25 14:20:10.000000', NULL, NULL),
(7, '400', '400 G', 0, 2, '2021-11-25 14:20:10.000000', NULL, NULL),
(8, '450', '450 G', 0, 2, '2021-11-25 14:20:10.000000', NULL, NULL),
(9, '500', '500 G', 0, 2, '2021-11-25 14:20:10.000000', NULL, NULL),
(10, '1000', '1 KG', 0, 2, '2021-11-25 14:20:10.000000', NULL, NULL),
(11, '1250', '1.25 KG', 0, 2, '2021-11-25 14:20:10.000000', NULL, NULL),
(12, '2000', '2 KG', 0, 2, '2021-11-25 14:20:10.000000', NULL, NULL),
(13, '2500', '2.5 KG', 0, 2, '2021-11-25 14:20:10.000000', NULL, NULL),
(14, '5000', '5 KG', 0, 2, '2021-11-25 14:20:10.000000', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `typeconditionnementtproduits`
--

CREATE TABLE `typeconditionnementtproduits` (
  `id` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `id_typeconditionnement` int(11) NOT NULL,
  `user_c` int(11) NOT NULL,
  `date_c` datetime NOT NULL,
  `user_u` int(11) NOT NULL,
  `date_u` datetime NOT NULL,
  `deleted` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `unites`
--

CREATE TABLE `unites` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `unites`
--

INSERT INTO `unites` (`id`, `libelle`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'Kg', 0, 7, '2020-10-15 23:36:50', NULL, NULL),
(3, 'MÃ©tre', 0, 7, '2020-10-15 23:37:04', NULL, NULL),
(4, 'PiÃ¨ce', 0, 7, '2020-10-15 23:37:14', 1, '2021-05-05 17:08:46');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `cne` varchar(255) DEFAULT NULL,
  `cni` varchar(255) DEFAULT NULL,
  `immatriculation` varchar(255) DEFAULT NULL,
  `fonction` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `darkmode` varchar(255) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `situation_familiale` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `pay_id` int(11) DEFAULT NULL,
  `ville_id` int(11) DEFAULT NULL,
  `nationalite` int(11) DEFAULT NULL,
  `sexe` varchar(50) DEFAULT NULL,
  `code_postal` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT '',
  `store_id` int(1) DEFAULT NULL,
  `code_bouchier` varchar(250) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL DEFAULT '1',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `email`, `username`, `password`, `tel`, `cne`, `cni`, `immatriculation`, `fonction`, `latitude`, `longitude`, `darkmode`, `role_id`, `situation_familiale`, `depot_id`, `avatar`, `code`, `date_naissance`, `pay_id`, `ville_id`, `nationalite`, `sexe`, `code_postal`, `adresse`, `store_id`, `code_bouchier`, `deleted`, `active`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'Super', 'Admin', 'y.khadraoui@lafonda.ma', 'admin', '2cec9a1d6b1179c2261391f2e709f49ff053cd50', '00000000', NULL, NULL, NULL, NULL, '33.532237', '-7.663592', 'off', 2, NULL, 1, '1-1614383536.jpg', NULL, NULL, 1, 3, NULL, 'Masculin', NULL, '', 19, '0', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-06-12 12:16:24'),
(77, 'BOUKJIJ', 'ASMAA', 'contact@lafonda.ma', 'BOUKJIJ', '10e38cb05f16c2d30f612862b0aae3a2419d1da8', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 12, '611328', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:17'),
(78, 'Bartouli', 'ayoub', 'ecom@lafonda.ma', 'Bartouli', 'f8762af34e17512bf06a228f46449805b310140d', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Masculin', NULL, '', 16, '101992', 0, 1, 2, '2022-02-14 10:32:00', 1, '2023-04-27 10:08:18'),
(76, 'ESSARQUANI', 'SANAA', 'contact@lafonda.ma', 'ESSARQUANI', '0c3948c605f59fed583bb47d3945ab74a9aa7257', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 10, '129423856', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:17'),
(75, 'ELMOUFARRIH', 'CHAIMAA', 'contact@lafonda.ma', 'ELMOUFARRIH', 'ff17bf1da5877f702c68ced2fefb9dc6ca14cc37', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 10, '875042', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:16'),
(74, 'ELFAJI', 'RABHA', 'contact@lafonda.ma', 'ELFAJI', 'c3c55318b10cfb8bd6ed8d6f0bc1d6bb01d72ed1', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 15, '420178632', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:16'),
(73, 'LAHLOU', 'AICHA', 'contact@lafonda.ma', 'LAHLOU', '358a78c3bbcf1820b6dbe4eec311d68a89a3e805', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 10, '320178742', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:15'),
(72, ' DAOUIDI ALAOUI', 'SOUKAINA', 'contact@lafonda.ma', 'DAOUDI', '90a574d0bc1218791bf49aa6f25b5d9273150376', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 17, '2900889000017', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:15'),
(71, 'BELKEDIOUI', 'ASMAA', 'contact@lafonda.ma', 'BELKEDIOUI', 'c749af46975a3bcd39d41d73e2b03ce944832ea1', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1, '720179521', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:14'),
(70, 'ELMALIKI', 'SIHAM', 'contact@lafonda.ma', 'ELMALIKI', 'e5ad29d4b7443caf3f8ea65b6f67cbd401ac511c', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 11, '2900712000016', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:14'),
(69, 'OUALI', 'HAMZA', 'yy@live.fr', 'OUALI', 'a44565127834329d8fdac613f310e00478f2b7e0', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '789123', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:13'),
(68, 'BOUCEKKOM', 'YASSINE', 'yy@live.fr', 'BOUCEKKOM', 'f43d1bf4546bc77138d2a53491b7cc1145b51ab2', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 12, '140619', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:13'),
(67, 'MANAR', 'MOUNIRA', 'yy@live.fr', 'MANAR', '849ebe66e775c3ca4d1e4310a5208a9ad469abb8', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 11, '8917', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:12'),
(66, 'AITAOUMAN', 'BRAHIM', 'yy@live.fr', 'AITAOUMAN', '0cbd12367f0218175d4a6574900d049f79553ac9', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 18, '820175642', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:12'),
(65, 'AITELMOKHTAR', 'MOHAMED', 'yy@live.fr', 'AITELMOKHTAR', 'a7ad166c733dc65bbe4078e2c5e369e19287876b', '', NULL, NULL, NULL, NULL, NULL, NULL, 'off', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 14, '820179454', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:11'),
(64, 'MOHARRAR', 'AMINE', 'yy@live.fr', 'MOHARRAR', '54b996e22a7fa89f68b21a6e8b237b56499cc3b6', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 15, '420178654', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:11'),
(63, 'ABID', 'MINA', 'yy@live.fr', 'ABID', 'b913c982c3ec691701042f0209d7aeeb91aa8b42', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 17, '620171865', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:10'),
(62, 'HASSIBA FILALI', 'ABDELMALEK', 'yy@live.fr', 'FILALI', '71d0f78a511dd07787a99538be43962fa7627c52', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '173654', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:09'),
(61, 'BYAD', 'ZINEB', 'yy@live.fr', 'BYAD', '2b1505b336e021a8dda3e2a139a3b3e1e66c5cee', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 1, '320177532', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:08'),
(60, 'RAIFAK', 'ZINEB', 'yy@live.fr', 'RAIFAK', 'dc9ec1f16c5a142dc9bd4f3cbba4b22ac21d7581', '', NULL, NULL, NULL, NULL, NULL, NULL, 'off', 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 10, '320172457', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:08'),
(59, 'AHMIDI', 'ILHAM', 'yy@live.fr', 'AHMIDI', '9897ef901b261e1b6531a2f3c016c8000b74d1f3', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 10, '720174935', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:07'),
(58, 'ELBAKRI', 'AMAL', 'yy@live.fr', 'ELBAKRI', '9b04a76869f8c551a29d157f656b1ee6b4038a6d', '5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 16, '720177986', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:06'),
(57, 'MAHMOUDI', 'YASSIR', 'yy@live.fr', 'MAHMOUDI', '383f85b9be732a114f5971df7968168d4b603b6c', '7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 16, '120176545', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:06'),
(56, 'HALOUI', 'HALIMA', 'yy@live.fr', 'HALOUI', '7e3cdcc513b41a60e3fbb39990270347c300a30a', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '120176532', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:05'),
(55, 'ELBOUHADI', 'HAMZA', 'contact@lafonda.ma', 'ELBOUHADI', 'db514fc689f8ec2784ba6830b62ad2e9', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900906000013', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:05'),
(54, 'JELLAL', 'LARBI', 'contact@lafonda.ma', 'JELLAL', 'f6e6aeda7035074e8241396178451cfb', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900904000015', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:05'),
(53, 'BOUKHASI', 'JAOUAD', 'contact@lafonda.ma', 'BOUKHASI', 'c6c6f6befb175220ee467a7a80942b8a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900296000013', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:05'),
(52, 'BOULARYA', 'ABDERRAZAK', 'contact@lafonda.ma', 'B.ABDERRAZAK', '8f6b5745d3153300ca63b6d1c4604b67', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900672300010', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:05'),
(51, 'BALLIRH', 'HAMZA V ', 'contact@lafonda.ma', 'BALLIRH', '0d3c8c6346c4b5ab2f487e92cc29cf04', '87', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 10, '2900902000017', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:05'),
(50, 'GHALOUMY', 'AYOUB ', 'contact@lafonda.ma', 'GHALOUMY', '3adafabbb6c33b5816246bd2c92bc20a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900901000018', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:05'),
(49, 'BOUSFIHA', ' YOUSSEF', 'contact@lafonda.ma', 'BOUSFIHA', 'c6fef15cf659a65550578a38067873cc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900900000019', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:05'),
(48, 'BAHRY', 'MOHAMED  ', 'contact@lafonda.ma', 'BAHRY', '83fd9832141a4a5add3c269d5144bc10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900899000014', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:05'),
(47, 'ED-DAHBY', 'AZEDDINE', 'contact@lafonda.ma', 'ED-DAHBY', '20937f2487f0a179ce0ed53dd9438250', '82', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 10, '2900897000016', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(46, 'RAFIK', 'HAMID ', 'contact@lafonda.ma', 'RAFIK', '4f06e701d4970aac6994c3556fc9d883', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900990000012', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(45, 'BELHIMER', 'HASNAE', 'contact@lafonda.ma', 'BELHIMER', '4d52a135aeaee5d63d9814e41650f143', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900891000012', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(43, 'BOULARYA', 'AYOUB ', 'contact@lafonda.ma', 'B.AYOUB', 'cec7362537c74410726b2d0c24b92503', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900711000017', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(41, 'SAADANI', 'LAKBIRA', 'contact@lafonda.ma', 'SAADANI', 'c0814318b708a0c5123e05d47ed09130', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900885000011', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(40, 'DRIBBA', 'LAIDI', 'contact@lafonda.ma', 'DRIBBA', '784dee210d9812910b85d49889c550dd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900884000012', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(39, 'ELKORAICHI', 'ABDELALI ', 'contact@lafonda.ma', 'ELKORAICHI', 'c07868c9628cf59214d907518fc2675a', '27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 10, '2900883000013', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(38, 'JAAIDAN', 'LAKBIR ', 'contact@lafonda.ma', 'JAAIDAN', 'c34322488b6bd6b94d8258709a1f352d', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900864000018', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(37, 'OULHADR', 'ABDELLAH ', 'contact@lafonda.ma', 'OULHADR', '50232da70f07d80f5c5116a3d4d33d70', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900863000019', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(36, 'ELHAJIBI', 'TAREQ', 'contact@lafonda.ma', 'ELHAJIBI', '0743e789f87e7fe583f53136ca2bd7ab', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900861000011', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(35, 'ZABDI', 'ABDELKADER ', 'contact@lafonda.ma', 'ZABDI', 'b8620fd7659f4e357fe29273b8c8ae41', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900860000012', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(34, 'AKECHTABOU', 'HAMID ', 'contact@lafonda.ma', 'AKECHTABOU', 'b8fde67fe766e6fea36b58a34ddb1d14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900858000017', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(33, 'BAKKALI', 'MOUHAMED ', 'contact@lafonda.ma', 'BAKKALI', 'c96f8edf12b14ce4fad24982c8d97707', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900857000018', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(32, 'AMZILINE', 'HAMZA ', 'contact@lafonda.ma', 'AMZILINE', '2683bf3b2f5682b764762f0ddfc8e3e8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900856000019', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(31, 'ESSANHAJI', 'MOHAMED ', 'contact@lafonda.ma', 'ESSANHAJI', '11c978021fd847da912f61cd7d743d51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900855000010', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(30, 'SHAITA', 'ABDERRAHIM ', 'contact@lafonda.ma', 'SHAITA', '5a408fc61af48024f8410384960b59e2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900853000012', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(29, 'ERROUIZAM', 'KHADIJA ', 'contact@lafonda.ma', 'ERROUIZAM', 'dbe7e5f21052cf00fc0dc095f9e638b1', '46', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 10, '2900852000013', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(28, 'SAHYANE', 'BRAHIM ', 'contact@lafonda.ma', 'SAHYANE', 'a031e0996b869d1ef82a3f56b8811aa1', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900851000014', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(27, 'NOUIRI', 'MOHAMED ', 'contact@lafonda.ma', 'NOUIRI', '99ea6e2429d07ea501febfe3d2765163', '43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 10, '2900882000014', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(26, 'BEIDOURI', 'ABDELKRIM ', 'contact@lafonda.ma', 'BEIDOURI', '8e728adb817695d0045a2913f5ff95ba', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900881000015', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(25, 'ELAZZOUZI', 'AICHA ', 'contact@lafonda.ma', 'ELAZZOUZI', '1d12863036cf558c2999a9f99f51bfc5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900880000016', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:04'),
(24, 'TOUINY', 'MOUHCINE ', 'contact@lafonda.ma', 'TOUINY', '016584d1470b5fe449b1f46d1a993710', '40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 10, '2900879000010', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:03'),
(23, 'MOUTAHID', 'MOHAMED ', 'contact@lafonda.ma', 'MOUTAHID', '3cbfe5de841412b8f1ef6cb9f64fd56f', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '290087800001', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:03'),
(22, 'KAWKABI', 'YOUSSEF ', 'contact@lafonda.ma', 'KAWKABI', '02c824a0235bbea213caa46091a27916', '38', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 10, '2900877000012', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:03'),
(21, 'HARROUCHI', 'MOHAMMED ', 'contact@lafonda.ma', 'HARROUCHI', '9cd11d484618007268c95775c0989f7a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900876000013', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:03'),
(20, 'GERANT', 'FES', 'contact@lafonda.ma', 'ELASRY', 'bc936b141544f882a6f73b236d7cf46b', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900875000014', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:03'),
(19, 'MOUJAN', 'MOHAMMED AMINE ', 'contact@lafonda.ma', 'MOUJAN', 'd6d6c871fbc4e7dddf0043a1d2a18b8d', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900874000015', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:03'),
(18, 'ELGARD', 'BRAHIM ', 'contact@lafonda.ma', 'ELGARD', '3527f460181fd9b9c3cac17b28547604', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900873000016', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:03'),
(17, 'DOUKOUK', 'MUSTAPHA ', 'contact@lafonda.ma', 'DOUKOUK', '101bdbe9b8a391e2f90b64c3497b6ce3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900872000017', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:03'),
(16, 'SMOUNI', 'SAAD ', 'contact@lafonda.ma', 'SMOUNI', 'd3307662d271579c0f645197a930dd88', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900870000019', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:03'),
(15, 'GUILLI', 'KHALIDD', 'contact@lafonda.ma', 'GUILLI', '636de5f2eb84c8fd7c56f008006d343a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900869000013', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:03'),
(14, 'BRIDI', 'HALIMA ', 'contact@lafonda.ma', 'BRIDI', '7ace94e1892540e6266531d5fc28f90a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900868000014', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:03'),
(13, 'LOUAFDI', 'SAID ', 'contact@lafonda.ma', 'LOUAFDI', '3a0348a65b1756567db65bac2f3450fa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900867000015', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:03'),
(12, 'OBIHI', 'AADIL', 'contact@lafonda.ma', 'OBIHI', 'bd9acb469c94da7f5812a228ca59dc6cdb97e85e', '26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 14, '2900865000017', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:02'),
(2, 'Khadraoui', 'Youssef', 'y.khadraoui@lafonda.ma', 'administrateur', 'ecf303464616aa0df6dd5651b30c08a8fa433f8a', '0673082858', NULL, NULL, NULL, NULL, NULL, NULL, 'off', 2, NULL, 1, '2-1614384045.png', NULL, '1990-01-01', 1, NULL, NULL, 'Masculin', NULL, '', 18, '8', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 10:08:00'),
(79, 'Benboubker', 'Taoufik', 't.benboubker@lafonda.ma', 't.benboubker', '3fcb9dab4d857b82700f2d85e62f4a2002bd7055', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Masculin', NULL, 'SAPINO', NULL, '', 0, 1, 2, '2022-02-14 13:23:00', 1, '2023-04-27 10:08:18'),
(80, 'Akroud', 'Jawad', 'info@lafonda.ma', 'Jawad Akroud', '9ac9393ffaadd54143bea439d7c707ce715039f4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Masculin', NULL, '', 16, '', 0, 1, 2, '2022-03-17 10:15:00', 1, '2023-04-27 10:08:18'),
(81, 'GHAZAOUI', 'AMINE', 'yy@live.fr', 'GHAZAOUI', '1e4a295c64f4b50f0f56b548b49c0be1645c5d14', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Masculin', NULL, '', 10, '2900445000017', 0, 1, 2, '2022-12-26 09:53:00', 1, '2023-04-27 10:08:19'),
(82, 'ALAMI', 'SOKAINA', 'yy@live.fr', 's.alami', '3293fd653c44edf6a36c3689a3212b3adc599945', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FÃ©minin', NULL, '', 16, '559252', 0, 1, 2, '2023-01-19 15:30:00', 1, '2023-04-27 10:08:19'),
(83, 'Test', 'Test', 'yy@live.fr', 'Test', '94f641556ae790cba72594cc54fad2a847eec835', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Masculin', NULL, '', 10, '', 0, 1, 2, '2023-01-25 15:16:00', 1, '2023-04-27 10:08:19'),
(84, 'EL FAHSI II', 'LOUBNAAA', 'yy@live.fr', 'l.elfahsi', '67c8665b6c64c747b56bf84132c5dfcb7354e505', '000000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'FÃ©minin', NULL, '', 12, '', 0, 1, 2, '2023-01-26 08:44:00', 1, '2023-04-27 11:03:57'),
(85, 'ESSOUSSI', 'HAMZAaa', 'yy@live.fr', 'h.essoussi', '5988ea4d2a597d2e8876970086eb481d99d67a89', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Masculin', NULL, '', 18, '2900809000011', 0, 1, 2, '2023-01-28 18:42:00', 1, '2023-04-27 10:08:20'),
(86, 'BOUAZZIZ', 'HOUSSAM', 'yy@live.fr', 'h.bouazziz', 'b6bf8529d33815dab1edc754f131e747d3d834a5', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Masculin', NULL, '', 15, '', 0, 1, 2, '2023-02-01 07:58:00', 1, '2023-04-27 10:08:21'),
(87, 'TEST001', 'TEST001', 'contact@lafonda.ma', 'LOUAFDI', '3a0348a65b1756567db65bac2f3450fa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '2900868000015', 0, 1, 1, '2023-04-14 17:24:00', 1, '2023-04-27 10:08:21');

-- --------------------------------------------------------

--
-- Structure de la table `versements`
--

CREATE TABLE `versements` (
  `id` int(11) NOT NULL,
  `reference` varchar(50) DEFAULT NULL,
  `image` longtext,
  `client_id` int(11) DEFAULT NULL,
  `agence_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `mode_paiement` int(11) DEFAULT NULL,
  `etat` int(11) DEFAULT '-1',
  `montant` decimal(10,2) DEFAULT '0.00',
  `total_verse` decimal(10,2) DEFAULT '0.00',
  `total_expenses` decimal(10,2) DEFAULT '0.00',
  `date` date DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `villes`
--

CREATE TABLE `villes` (
  `id` int(11) NOT NULL,
  `libelle` varchar(200) NOT NULL,
  `pay_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `villes`
--

INSERT INTO `villes` (`id`, `libelle`, `pay_id`, `deleted`, `user_c`, `date_c`, `user_u`, `date_u`) VALUES
(1, 'Al-Hoceima', 1, 0, NULL, NULL, NULL, NULL),
(2, 'Agadir', 1, 0, NULL, NULL, NULL, NULL),
(3, 'Asilah', 1, 0, NULL, NULL, NULL, NULL),
(4, 'Azrou', 1, 1, NULL, NULL, NULL, NULL),
(5, 'Azilal', 1, 1, NULL, NULL, NULL, NULL),
(6, 'Azemmour', 1, 1, NULL, NULL, NULL, NULL),
(7, 'Beni Mellal', 1, 1, NULL, NULL, NULL, NULL),
(8, 'Bni Bouayach', 1, 0, NULL, NULL, NULL, NULL),
(9, 'Berkane', 1, 1, NULL, NULL, NULL, NULL),
(10, 'Berrechid', 1, 0, NULL, NULL, NULL, NULL),
(11, 'Bouarfa', 1, 0, NULL, NULL, NULL, NULL),
(12, 'Casablanca', 1, 0, NULL, NULL, NULL, NULL),
(13, 'Chefchaouen', 1, 0, NULL, NULL, NULL, NULL),
(14, 'El Jadida', 1, 0, NULL, NULL, NULL, NULL),
(15, 'Er Rachidia', 1, 0, NULL, NULL, NULL, NULL),
(16, 'Essaouira', 1, 0, NULL, NULL, NULL, NULL),
(17, 'Figuig', 1, 0, NULL, NULL, NULL, NULL),
(18, 'Fes', 1, 0, NULL, NULL, NULL, NULL),
(19, 'Guelmim', 1, 0, NULL, NULL, NULL, NULL),
(21, 'Ifrane', 1, 0, NULL, NULL, NULL, NULL),
(22, 'Kenitra', 1, 0, NULL, NULL, NULL, NULL),
(23, 'Khemisset', 1, 0, NULL, NULL, NULL, NULL),
(24, 'Khenifra', 1, 0, NULL, NULL, NULL, NULL),
(25, 'Khouribga', 1, 0, NULL, NULL, NULL, NULL),
(26, 'Ksar-el-Kebir', 1, 0, NULL, NULL, NULL, NULL),
(27, 'Larache', 1, 0, NULL, NULL, NULL, NULL),
(28, 'Marrakech', 1, 0, NULL, NULL, NULL, NULL),
(29, 'Meknes', 1, 0, NULL, NULL, NULL, NULL),
(30, 'Mohammedia', 1, 0, NULL, NULL, NULL, NULL),
(31, 'Nador', 1, 0, NULL, NULL, NULL, NULL),
(32, 'Ouarzazate', 1, 0, NULL, NULL, NULL, NULL),
(33, 'Ouezzane', 1, 0, NULL, NULL, NULL, NULL),
(34, 'Oujda', 1, 0, NULL, NULL, NULL, NULL),
(35, 'Rabat', 1, 0, NULL, NULL, NULL, NULL),
(36, 'Safi', 1, 0, NULL, NULL, NULL, NULL),
(37, 'Cairo', 2, 1, NULL, NULL, NULL, NULL),
(38, 'Tunisie', 3, 1, NULL, NULL, NULL, NULL),
(39, 'Tanger', 1, 0, 1, '2019-05-28 23:29:02', NULL, NULL),
(40, 'TETOUAN', 1, 0, 1, '2019-06-18 21:31:49', NULL, NULL),
(41, 'Mohammadia', 1, 1, 1, '2019-07-20 10:33:13', NULL, NULL),
(42, 'TEMARA', 1, 0, 7, '2020-07-11 13:09:15', NULL, NULL),
(43, 'FNIDEQ', 1, 0, 7, '2020-07-13 16:27:47', NULL, NULL),
(44, 'Belyounech', 1, 0, 7, '2020-10-03 16:43:58', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `walletdetails`
--

CREATE TABLE `walletdetails` (
  `id` int(11) NOT NULL,
  `montant` float DEFAULT NULL,
  `ref_ticket` text,
  `wallet_id` int(11) NOT NULL,
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `reference` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `wallets`
--

CREATE TABLE `wallets` (
  `id` int(11) NOT NULL,
  `reference` text NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `montant` float DEFAULT NULL,
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `mode` text,
  `num_cheque` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `agences`
--
ALTER TABLE `agences`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `alerts_users`
--
ALTER TABLE `alerts_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `attentedetails`
--
ALTER TABLE `attentedetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `attentes`
--
ALTER TABLE `attentes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `avances`
--
ALTER TABLE `avances`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `avoirdetails`
--
ALTER TABLE `avoirdetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `avoirs`
--
ALTER TABLE `avoirs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bonachats`
--
ALTER TABLE `bonachats`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bonavoirdetails`
--
ALTER TABLE `bonavoirdetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bonavoirs`
--
ALTER TABLE `bonavoirs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `boncommandedetails`
--
ALTER TABLE `boncommandedetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `boncommandes`
--
ALTER TABLE `boncommandes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bonentreedetails`
--
ALTER TABLE `bonentreedetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bonentrees`
--
ALTER TABLE `bonentrees`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bonlivraisondetails`
--
ALTER TABLE `bonlivraisondetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bonlivraisons`
--
ALTER TABLE `bonlivraisons`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bonreceptiondetails`
--
ALTER TABLE `bonreceptiondetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bonreceptions`
--
ALTER TABLE `bonreceptions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bonretourachatdetails`
--
ALTER TABLE `bonretourachatdetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bonretourachats`
--
ALTER TABLE `bonretourachats`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bonretourdetails`
--
ALTER TABLE `bonretourdetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bonretours`
--
ALTER TABLE `bonretours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bontransfertdetails`
--
ALTER TABLE `bontransfertdetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bontransferts`
--
ALTER TABLE `bontransferts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `caisses`
--
ALTER TABLE `caisses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorieclients`
--
ALTER TABLE `categorieclients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categoriedepences`
--
ALTER TABLE `categoriedepences`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorieproduits`
--
ALTER TABLE `categorieproduits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chatmessages`
--
ALTER TABLE `chatmessages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chequecadeaus`
--
ALTER TABLE `chequecadeaus`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clienttypes`
--
ALTER TABLE `clienttypes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commandedetails`
--
ALTER TABLE `commandedetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commandes_glovo`
--
ALTER TABLE `commandes_glovo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `CleUnique` (`order_code`(9),`store_id`(2)) USING BTREE;

--
-- Index pour la table `commande_glovo_details`
--
ALTER TABLE `commande_glovo_details`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `compteurs`
--
ALTER TABLE `compteurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `depences`
--
ALTER TABLE `depences`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `depotproduits`
--
ALTER TABLE `depotproduits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `depots`
--
ALTER TABLE `depots`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `devidetails`
--
ALTER TABLE `devidetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `devis`
--
ALTER TABLE `devis`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `divers`
--
ALTER TABLE `divers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ecommercedetails`
--
ALTER TABLE `ecommercedetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `ecommerces`
--
ALTER TABLE `ecommerces`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `entrees`
--
ALTER TABLE `entrees`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `facturedetails`
--
ALTER TABLE `facturedetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `factures`
--
ALTER TABLE `factures`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fidelites`
--
ALTER TABLE `fidelites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fraislivraisons`
--
ALTER TABLE `fraislivraisons`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `groupes`
--
ALTER TABLE `groupes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `groupes_users`
--
ALTER TABLE `groupes_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `inventairedetails`
--
ALTER TABLE `inventairedetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `inventaires`
--
ALTER TABLE `inventaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `kitchensystems`
--
ALTER TABLE `kitchensystems`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `kitchensystems_produits`
--
ALTER TABLE `kitchensystems_produits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `lastsessions`
--
ALTER TABLE `lastsessions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `localisations`
--
ALTER TABLE `localisations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `logings`
--
ALTER TABLE `logings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages_users`
--
ALTER TABLE `messages_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `motifplanifications`
--
ALTER TABLE `motifplanifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `motifs`
--
ALTER TABLE `motifs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `motifsabandons`
--
ALTER TABLE `motifsabandons`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mouvementprincipals`
--
ALTER TABLE `mouvementprincipals`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mouvements`
--
ALTER TABLE `mouvements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications_users`
--
ALTER TABLE `notifications_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notifications_vues`
--
ALTER TABLE `notifications_vues`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `objectifclients`
--
ALTER TABLE `objectifclients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `objectifs`
--
ALTER TABLE `objectifs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `offlines`
--
ALTER TABLE `offlines`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `optionproduits`
--
ALTER TABLE `optionproduits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiement_wallets`
--
ALTER TABLE `paiement_wallets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parametrealerts`
--
ALTER TABLE `parametrealerts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parametrestes`
--
ALTER TABLE `parametrestes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pdfmodeles`
--
ALTER TABLE `pdfmodeles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `permissionpos`
--
ALTER TABLE `permissionpos`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `personalisations`
--
ALTER TABLE `personalisations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pieces`
--
ALTER TABLE `pieces`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `planifications`
--
ALTER TABLE `planifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `productiondetails`
--
ALTER TABLE `productiondetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `productions`
--
ALTER TABLE `productions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produitingredients`
--
ALTER TABLE `produitingredients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produitprices`
--
ALTER TABLE `produitprices`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `remiseclients`
--
ALTER TABLE `remiseclients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `retourdetails`
--
ALTER TABLE `retourdetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `retours`
--
ALTER TABLE `retours`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `salepointdetails`
--
ALTER TABLE `salepointdetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `salepoints`
--
ALTER TABLE `salepoints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_store` (`store`);

--
-- Index pour la table `segments`
--
ALTER TABLE `segments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sessionusers`
--
ALTER TABLE `sessionusers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `societes`
--
ALTER TABLE `societes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sortiedetails`
--
ALTER TABLE `sortiedetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_mouvement` (`id_mouvementprincipal`);

--
-- Index pour la table `souscategorieproduits`
--
ALTER TABLE `souscategorieproduits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stores_users`
--
ALTER TABLE `stores_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `synchronisations`
--
ALTER TABLE `synchronisations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `t09s`
--
ALTER TABLE `t09s`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `testo`
--
ALTER TABLE `testo`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transformationdetails`
--
ALTER TABLE `transformationdetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transformations`
--
ALTER TABLE `transformations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tvas`
--
ALTER TABLE `tvas`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `typecommandes`
--
ALTER TABLE `typecommandes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `typeconditionnements`
--
ALTER TABLE `typeconditionnements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `typeconditionnementtproduits`
--
ALTER TABLE `typeconditionnementtproduits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `unites`
--
ALTER TABLE `unites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `versements`
--
ALTER TABLE `versements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `villes`
--
ALTER TABLE `villes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `walletdetails`
--
ALTER TABLE `walletdetails`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `agences`
--
ALTER TABLE `agences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `alerts_users`
--
ALTER TABLE `alerts_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `attentedetails`
--
ALTER TABLE `attentedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `attentes`
--
ALTER TABLE `attentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `avances`
--
ALTER TABLE `avances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `avoirdetails`
--
ALTER TABLE `avoirdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `avoirs`
--
ALTER TABLE `avoirs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `backups`
--
ALTER TABLE `backups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `bonachats`
--
ALTER TABLE `bonachats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bonavoirdetails`
--
ALTER TABLE `bonavoirdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bonavoirs`
--
ALTER TABLE `bonavoirs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `boncommandedetails`
--
ALTER TABLE `boncommandedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `boncommandes`
--
ALTER TABLE `boncommandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bonentreedetails`
--
ALTER TABLE `bonentreedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bonentrees`
--
ALTER TABLE `bonentrees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bonlivraisondetails`
--
ALTER TABLE `bonlivraisondetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `bonlivraisons`
--
ALTER TABLE `bonlivraisons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `bonreceptiondetails`
--
ALTER TABLE `bonreceptiondetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `bonreceptions`
--
ALTER TABLE `bonreceptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `bonretourachatdetails`
--
ALTER TABLE `bonretourachatdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bonretourachats`
--
ALTER TABLE `bonretourachats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bonretourdetails`
--
ALTER TABLE `bonretourdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bonretours`
--
ALTER TABLE `bonretours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bontransfertdetails`
--
ALTER TABLE `bontransfertdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bontransferts`
--
ALTER TABLE `bontransferts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `caisses`
--
ALTER TABLE `caisses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `categorieclients`
--
ALTER TABLE `categorieclients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `categoriedepences`
--
ALTER TABLE `categoriedepences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `categorieproduits`
--
ALTER TABLE `categorieproduits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `chatmessages`
--
ALTER TABLE `chatmessages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `chequecadeaus`
--
ALTER TABLE `chequecadeaus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `clienttypes`
--
ALTER TABLE `clienttypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `commandedetails`
--
ALTER TABLE `commandedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commandes_glovo`
--
ALTER TABLE `commandes_glovo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `compteurs`
--
ALTER TABLE `compteurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT pour la table `configs`
--
ALTER TABLE `configs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `depences`
--
ALTER TABLE `depences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `depotproduits`
--
ALTER TABLE `depotproduits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `depots`
--
ALTER TABLE `depots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `devidetails`
--
ALTER TABLE `devidetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `devis`
--
ALTER TABLE `devis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `divers`
--
ALTER TABLE `divers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `ecommercedetails`
--
ALTER TABLE `ecommercedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ecommerces`
--
ALTER TABLE `ecommerces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `entrees`
--
ALTER TABLE `entrees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `facturedetails`
--
ALTER TABLE `facturedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `fidelites`
--
ALTER TABLE `fidelites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `fraislivraisons`
--
ALTER TABLE `fraislivraisons`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `groupes`
--
ALTER TABLE `groupes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `groupes_users`
--
ALTER TABLE `groupes_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `inventairedetails`
--
ALTER TABLE `inventairedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `inventaires`
--
ALTER TABLE `inventaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `kitchensystems`
--
ALTER TABLE `kitchensystems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `kitchensystems_produits`
--
ALTER TABLE `kitchensystems_produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `localisations`
--
ALTER TABLE `localisations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `logings`
--
ALTER TABLE `logings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages_users`
--
ALTER TABLE `messages_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=359;

--
-- AUTO_INCREMENT pour la table `motifplanifications`
--
ALTER TABLE `motifplanifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `motifs`
--
ALTER TABLE `motifs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `motifsabandons`
--
ALTER TABLE `motifsabandons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `mouvementprincipals`
--
ALTER TABLE `mouvementprincipals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `mouvements`
--
ALTER TABLE `mouvements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notifications_users`
--
ALTER TABLE `notifications_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notifications_vues`
--
ALTER TABLE `notifications_vues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `objectifclients`
--
ALTER TABLE `objectifclients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `objectifs`
--
ALTER TABLE `objectifs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `offlines`
--
ALTER TABLE `offlines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `optionproduits`
--
ALTER TABLE `optionproduits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `paiement_wallets`
--
ALTER TABLE `paiement_wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parametrealerts`
--
ALTER TABLE `parametrealerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parametrestes`
--
ALTER TABLE `parametrestes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `pays`
--
ALTER TABLE `pays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `pdfmodeles`
--
ALTER TABLE `pdfmodeles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1449;

--
-- AUTO_INCREMENT pour la table `permissionpos`
--
ALTER TABLE `permissionpos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT pour la table `personalisations`
--
ALTER TABLE `personalisations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pieces`
--
ALTER TABLE `pieces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `planifications`
--
ALTER TABLE `planifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `productiondetails`
--
ALTER TABLE `productiondetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `productions`
--
ALTER TABLE `productions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produitingredients`
--
ALTER TABLE `produitingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produitprices`
--
ALTER TABLE `produitprices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=592;

--
-- AUTO_INCREMENT pour la table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `remiseclients`
--
ALTER TABLE `remiseclients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `retourdetails`
--
ALTER TABLE `retourdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `retours`
--
ALTER TABLE `retours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `salepointdetails`
--
ALTER TABLE `salepointdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `salepoints`
--
ALTER TABLE `salepoints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `segments`
--
ALTER TABLE `segments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `sessionusers`
--
ALTER TABLE `sessionusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `societes`
--
ALTER TABLE `societes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `sortiedetails`
--
ALTER TABLE `sortiedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `souscategorieproduits`
--
ALTER TABLE `souscategorieproduits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `stores_users`
--
ALTER TABLE `stores_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT pour la table `synchronisations`
--
ALTER TABLE `synchronisations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `t09s`
--
ALTER TABLE `t09s`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `testo`
--
ALTER TABLE `testo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `transformationdetails`
--
ALTER TABLE `transformationdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `transformations`
--
ALTER TABLE `transformations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tvas`
--
ALTER TABLE `tvas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `typecommandes`
--
ALTER TABLE `typecommandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `typeconditionnements`
--
ALTER TABLE `typeconditionnements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `typeconditionnementtproduits`
--
ALTER TABLE `typeconditionnementtproduits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `unites`
--
ALTER TABLE `unites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT pour la table `versements`
--
ALTER TABLE `versements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `villes`
--
ALTER TABLE `villes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `walletdetails`
--
ALTER TABLE `walletdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
