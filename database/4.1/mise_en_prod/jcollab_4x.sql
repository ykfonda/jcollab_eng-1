-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 24 mai 2023 à 10:11
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
  `prix_achat` decimal(10,2) DEFAULT NULL,
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
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 'JCOLLAB', '4.1', '51af9f7', 'http://localhost/JCOLLAB4X', 'http://localhost/JCOLLAB4X/pos/index/', 'https://iafsys.app/jcollab.ae', 2, 'h.sadek@jaweb.ma', '2023-04-10 00:00:00', '2023-05-23 14:20:01', 0, '102.53.11.94', 10, 17);

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
  `quantite` float DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) DEFAULT NULL,
  `date_c` datetime DEFAULT NULL,
  `user_u` int(11) DEFAULT NULL,
  `date_u` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(3, 'DP-000003', 'BELVEDERE', '', 4, 17, 1, 1, 0, 2, '2021-11-25 07:55:56', 5, '2021-12-01 15:05:14'),
(4, 'DP-000004', 'CALIFORNIE', '', 4, 16, 1, 1, 0, 2, '2021-11-25 07:56:12', 5, '2021-12-01 15:05:35'),
(5, 'DP-000005', 'FES', '', 3, 14, 1, 1, 0, 2, '2021-11-25 07:56:25', 5, '2021-12-01 15:05:46'),
(6, 'DP-000006', 'GUELIZ', '', 2, 18, 1, 1, 0, 2, '2021-11-25 07:56:39', 5, '2021-12-01 15:06:16'),
(7, 'DP-000007', ' RABAT', '', 2, 15, 1, 1, 0, 2, '2021-11-25 07:57:27', 5, '2021-12-01 15:06:53'),
(8, 'DP-000008', 'TANGER', '', 3, 12, 1, 1, 0, 2, '2021-11-25 07:57:44', 5, '2021-12-01 15:07:06'),
(9, 'DP-000009', 'MLY DRISS', '', 5, 1, 1, 1, 0, 2, '2021-11-25 07:58:33', 5, '2021-12-01 15:06:38'),
(10, 'DP-000010', 'USINE', '', 1, 19, 1, 1, 0, 2, '2021-11-26 09:06:44', 2, '2021-12-28 13:05:21'),
(11, 'DP-000003', 'BELVEDERE 2', '', 4, 17, 0, 1, 0, 2, '2021-11-25 07:55:56', 5, '2021-12-01 15:05:14');

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
  `quantite` int(11) DEFAULT NULL,
  `depot_id` int(11) DEFAULT NULL,
  `produit_id` int(11) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  `user_c` int(11) NOT NULL,
  `date_c` datetime NOT NULL,
  `type` varchar(10) NOT NULL,
  `sync` int(11) NOT NULL DEFAULT '0' COMMENT 'Etat de synchronisation'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `quantite_reel` decimal(10,3) NOT NULL DEFAULT '0.000',
  `quantite_theorique` decimal(10,3) NOT NULL DEFAULT '0.000',
  `ecart` decimal(10,3) NOT NULL DEFAULT '0.000',
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
(1, '2023-05-23 14:20:00', 'admin', -1, 0, 0, NULL, NULL, 1, '2023-05-23 14:20:33'),
(2, '2023-05-22 14:11:00', 'administrateur', -1, 0, 0, NULL, NULL, 2, '2023-05-22 14:11:29'),
(84, '2023-05-23 14:38:00', 'l.elfahsi', 1, 0, 0, NULL, NULL, 84, '2023-05-23 14:38:44');

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
(239, 'Liste des roles', 'Modification', 1, '2023-04-27 10:08:21', 0);

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
(483, 2, 117, 1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0, '2021-02-28 22:20:23', 0),
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
(1446, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2023-04-26 10:56:23', 0);

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
(5, 'PROD-000005', 'OGRAISSE S/PRODUITO', 'DE 5', 'default.jpg', '014', '2022-02-01', '20.00', '30.00', '5.00', '0.00', '0.00', 1, 2, 2, 9, NULL, 1, 0, 0, 14, 7, '', '12345', '1234', '0', 'auto', '', '', '1.000', 0, 123, NULL, 0, 1, '2022-02-01 00:00:00', 1, '2023-04-25 13:44:33', NULL, NULL, NULL, NULL),
(6, 'PROD-000006', 'FAUX FILET', 'DE 6', 'default.jpg', '109', '2022-02-01', '167.00', '169.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 21, 1, -107.184, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 1, '2023-04-25 13:44:34', NULL, NULL, NULL, NULL),
(7, 'PROD-000007', 'FILETTT', '', 'default.jpg', '110', '2022-02-01', '239.00', '239.00', '0.00', '0.00', '0.00', 1, 2, 2, 8, 21, 1, -41.308, 0, 0, 0, '', '', '', '1', 'auto', '', '', '1.000', 0, NULL, NULL, 0, 1, '2022-02-01 00:00:00', 1, '2023-04-25 13:44:34', NULL, NULL, NULL, NULL);

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
(6, 'GÃ©rants', '2021-12-27 13:13:55', 0),
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
(1, 'B1-Prov-000001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, -1, -1, -1, '0.00', '0.00', '0.00', '0.00', '0.00', NULL, '0.00', NULL, NULL, NULL, 0, '', 1, '2023-05-22 12:42:09', 0, 10, '', '', 0, '', 1, '2023-05-22 12:42:00', NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, 0),
(2, 'B1-Prov-000002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, -1, -1, -1, '0.00', '0.00', '0.00', '0.00', '0.00', NULL, '0.00', NULL, NULL, NULL, 0, '', 1, '2023-05-23 14:20:32', 0, 10, '', '', 0, '', 1, '2023-05-23 14:20:00', NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, 0),
(3, 'B1-Prov-000003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, -1, -1, -1, -1, '0.00', '0.00', '0.00', '0.00', '0.00', NULL, '0.00', NULL, NULL, NULL, 0, '', 84, '2023-05-23 14:38:44', 0, 10, '', '', 0, '', 84, '2023-05-23 14:38:00', NULL, NULL, 0, 0, NULL, 0, 0, NULL, NULL, NULL, NULL, 0, 0);

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
(101, 'Session-000005', '2022-02-16 20:38:36', '2022-05-05 11:48:42', 58, 16, 11, NULL, 0, 0),
(102, 'Session-000002', '2022-02-17 08:54:06', NULL, 2, 16, 11, NULL, NULL, 0),
(103, 'Session-000003', '2022-02-23 11:46:07', NULL, 57, 16, 11, NULL, NULL, 0),
(104, 'Session-000004', '2022-03-17 10:51:16', NULL, 60, 16, 11, NULL, NULL, 0),
(105, 'Session-000006', '2022-05-05 11:52:31', '2022-05-30 11:08:08', 58, 16, 11, NULL, 0, 0),
(106, 'Session-000007', '2022-05-30 11:08:45', '2022-06-01 14:41:37', 58, 16, 11, NULL, 0, 0),
(107, 'Session-000007', '2022-06-01 14:44:20', NULL, 58, 16, 11, NULL, NULL, 0),
(108, 'Session-000008', '2022-06-01 17:03:45', NULL, 2, 16, 12, NULL, NULL, 0),
(109, 'Session-000009', '2022-08-16 10:54:18', NULL, 60, 16, 12, NULL, NULL, 0),
(110, 'Session-000010', '2022-09-28 16:34:34', NULL, 2, 10, 2, NULL, NULL, 0),
(111, 'Session-000011', '2022-12-20 16:04:42', NULL, 2, 11, 6, NULL, NULL, 0),
(112, 'Session-000012', '2023-01-10 10:02:27', NULL, 70, 11, 6, NULL, NULL, 0),
(113, 'Session-000013', '2023-01-11 08:18:10', NULL, 60, 11, 6, NULL, NULL, 0),
(114, 'Session-000014', '2023-01-13 08:35:24', NULL, 72, 17, 10, NULL, NULL, 0),
(115, 'Session-000015', '2023-01-13 08:50:34', NULL, 61, 1, 4, NULL, NULL, 0),
(116, 'Session-000016', '2023-01-13 18:48:32', NULL, 63, 17, 10, NULL, NULL, 0),
(117, 'Session-000017', '2023-01-17 10:53:34', NULL, 73, 10, 2, NULL, NULL, 0),
(118, 'Session-000018', '2023-01-17 14:05:11', NULL, 60, 10, 2, NULL, NULL, 0),
(119, 'Session-000023', '2023-01-19 11:25:52', '2023-01-21 14:04:18', 59, 10, 2, NULL, 0, 0),
(120, 'Session-000020', '2023-01-19 15:31:50', NULL, 82, 10, 2, NULL, NULL, 0),
(121, 'Session-000021', '2023-01-19 15:40:56', NULL, 82, 16, 11, NULL, NULL, 0),
(122, 'Session-000022', '2023-01-20 09:41:57', NULL, 67, 11, 6, NULL, NULL, 0),
(123, 'Session-000023', '2023-01-21 14:14:56', NULL, 59, 10, 2, NULL, NULL, 0),
(124, 'Session-000026', '2023-01-25 08:34:30', '2023-01-25 13:45:58', 64, 15, 9, NULL, 0, 0),
(125, 'Session-000025', '2023-01-25 12:51:57', NULL, 2, 1, 4, NULL, NULL, 0),
(126, 'Session-000031', '2023-01-26 10:05:27', '2023-01-29 10:10:55', 64, 15, 9, NULL, 0, 0),
(127, 'Session-000027', '2023-01-26 13:00:04', NULL, 84, 12, 14, NULL, NULL, 0),
(128, 'Session-000028', '2023-01-26 13:16:43', NULL, 74, 15, 9, NULL, NULL, 0),
(129, 'Session-000032', '2023-01-27 11:03:03', '2023-01-31 10:49:39', 66, 18, 8, NULL, 0, 0),
(130, 'Session-000030', '2023-01-28 10:33:41', NULL, 77, 12, 14, NULL, NULL, 0),
(131, 'Session-000031', '2023-01-29 10:11:59', NULL, 64, 15, 9, NULL, NULL, 0),
(132, 'Session-000032', '2023-01-31 10:50:29', NULL, 66, 18, 8, NULL, NULL, 0),
(133, 'Session-000033', '2023-02-01 09:24:33', NULL, 86, 15, 9, NULL, NULL, 0),
(134, 'Session-000035', '2023-02-01 19:14:26', '2023-02-06 15:39:35', 65, 14, 13, NULL, 0, 0),
(135, 'Session-000035', '2023-02-06 16:43:51', NULL, 65, 14, 13, NULL, NULL, 0),
(136, 'Session-000036', '0000-00-00 00:00:00', '2023-02-06 19:59:13', 0, 0, 0, NULL, 1, 0),
(137, 'Session-000037', '2023-03-30 23:11:17', NULL, 1, 1, 4, NULL, NULL, 0),
(138, 'Session-000038', '2023-04-13 02:03:52', NULL, 1, 16, 11, NULL, NULL, 0),
(139, 'Session-000039', '2023-04-14 14:24:10', NULL, 1, 16, 2, NULL, NULL, 0),
(140, 'Session-000040', '2023-04-14 14:30:00', NULL, 1, 16, 20, NULL, NULL, 0),
(141, 'Session-000041', '2023-04-15 22:11:04', NULL, 12, 10, 2, NULL, NULL, 0),
(142, 'Session-000042', '2023-04-16 00:26:02', NULL, 1, 15, 1, NULL, NULL, 0),
(143, 'Session-000043', '2023-04-17 12:38:00', NULL, 12, 12, 1, NULL, NULL, 0),
(144, 'Session-000044', '2023-04-22 02:24:34', NULL, 1, 17, 10, NULL, NULL, 0),
(145, 'Session-000045', '2023-04-27 11:01:39', NULL, 2, 17, 10, NULL, NULL, 0),
(146, 'Session-000046', '2023-04-27 11:08:10', NULL, 84, 17, 10, NULL, NULL, 0),
(147, 'Session-000047', '2023-05-11 22:20:33', NULL, 84, 16, 5, NULL, NULL, 0),
(148, 'Session-000048', '2023-05-17 16:08:01', NULL, 1, 16, 5, NULL, NULL, 0);

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
(17, 'ST-000017', 'PV BELVEDERE', 'BD EMILE ZOLA ', NULL, 2, 4, 12, '102.53.11.94', 2, 0, 2, '2021-11-23 14:16:08', 2, '2022-02-17 13:29:25', 'CASABLANCA', 'MAROC', '06 67 02 45 95 \\ 05 22 405 969', '37946936', 'VTB'),
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
(133, 17, 1, 0, NULL, NULL, NULL, NULL),
(134, 19, 1, 0, NULL, NULL, NULL, NULL),
(135, 11, 12, 0, NULL, NULL, NULL, NULL),
(136, 10, 88, 0, NULL, NULL, NULL, NULL),
(137, 17, 88, 0, NULL, NULL, NULL, NULL),
(138, 16, 88, 0, NULL, NULL, NULL, NULL),
(139, 20, 2, 0, NULL, NULL, NULL, NULL),
(140, 17, 84, 0, NULL, NULL, NULL, NULL);

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
(1, 'Super', 'Admin', 'y.khadraoui@lafonda.ma', 'admin', '2cec9a1d6b1179c2261391f2e709f49ff053cd50', '00000000', NULL, NULL, NULL, NULL, '33.532237', '-7.663592', 'off', 1, NULL, 1, '1-1614383536.jpg', NULL, NULL, 1, 3, NULL, 'Masculin', NULL, '', 1, '0', 0, 1, 1, '2020-07-02 17:24:00', 1, '2023-04-27 11:06:12'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bonlivraisons`
--
ALTER TABLE `bonlivraisons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bonreceptiondetails`
--
ALTER TABLE `bonreceptiondetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `bonreceptions`
--
ALTER TABLE `bonreceptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `facturedetails`
--
ALTER TABLE `facturedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `mouvements`
--
ALTER TABLE `mouvements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1447;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `salepoints`
--
ALTER TABLE `salepoints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `segments`
--
ALTER TABLE `segments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `sessionusers`
--
ALTER TABLE `sessionusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT pour la table `societes`
--
ALTER TABLE `societes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `sortiedetails`
--
ALTER TABLE `sortiedetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

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
