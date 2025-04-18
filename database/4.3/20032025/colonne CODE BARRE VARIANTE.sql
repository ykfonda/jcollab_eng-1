ALTER TABLE `produits`
	ADD COLUMN `code_barre_variante` VARCHAR(255) NULL DEFAULT NULL AFTER `code_barre`;

	ALTER TABLE `produits`
	ADD INDEX `code_barre_variante` (`code_barre_variante`);