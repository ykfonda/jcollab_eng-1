
/** retirer l'option d'auto-increment depuis la colonne ID **//
ALTER TABLE `produits` CHANGE `id` `id` INT(11) NOT NULL;
