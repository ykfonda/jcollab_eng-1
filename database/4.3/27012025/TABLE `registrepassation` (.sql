CREATE TABLE `registrepassation` (
    `id` INT(10) NOT NULL AUTO_INCREMENT,
    `reference` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
    `Objectif` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
    `Pilote` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
    `CoPilote` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
    `user_id` INT(10) NULL DEFAULT NULL,
    `depot_id` INT(10) NULL DEFAULT NULL,
    `date` DATE NULL DEFAULT NULL,
    `numlot` INT(10) NULL DEFAULT NULL,
    `statut` INT(10) NOT NULL DEFAULT '-1',
    `Frequence` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
    `Manager` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
    `Plage_Horaire` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
    `Responsable_Qualite` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
    `Jour` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
    `deleted` INT(10) NOT NULL DEFAULT '0',
    `user_c` INT(10) NULL DEFAULT NULL,
    `date_c` DATETIME NULL DEFAULT NULL,
    `user_u` INT(10) NULL DEFAULT NULL,
    `date_u` DATETIME NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb3_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=18;
