-- --------------------------------------------------------
-- Hôte:                         localhost
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Listage de la structure de table jcollab_eng. motifsretours
CREATE TABLE IF NOT EXISTS `motifsretours` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_c` int NOT NULL,
  `date_c` datetime NOT NULL,
  `user_u` int DEFAULT NULL,
  `date_u` datetime DEFAULT NULL,
  `deleted` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Listage des données de la table jcollab_eng.motifsretours : ~6 rows (environ)
INSERT INTO `motifsretours` (`id`, `libelle`, `user_c`, `date_c`, `user_u`, `date_u`, `deleted`) VALUES
	(1, 'Motif retour 1', 2, '2021-11-10 14:33:09', 2, '2021-11-15 12:31:36', 0),
	(2, 'Motif retour 2', 2, '2021-11-10 14:37:30', 2, '2021-11-15 12:31:22', 0),
	(3, 'Motif retour 3', 2, '2021-11-15 12:31:52', NULL, NULL, 0),
	(4, 'Motif retour 4', 2, '2021-11-15 12:32:09', NULL, NULL, 0),
	(5, 'Motif retour 5', 2, '2021-11-15 12:32:21', NULL, NULL, 0),
	(6, 'Motif retour 6', 2, '2021-11-15 12:32:47', NULL, NULL, 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
