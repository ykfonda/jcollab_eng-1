ALTER TABLE mouvementprincipals ADD motifsretour_id INT(11) NULL;
ALTER TABLE mouvementprincipals ADD CONSTRAINT fk_mouvement_motifs FOREIGN KEY (motifsretour_id) REFERENCES motifsretours(id);
