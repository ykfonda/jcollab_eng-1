-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 22 mai 2023 à 14:25
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

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=359;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
