ALTER TABLE produits ADD aconserver VARCHAR(50) NOT NULL AFTER qteofeco;

ALTER TABLE productions ADD numlot INT(20) NOT NULL AFTER date;


ALTER TABLE produits ADD compositions TEXT NOT NULL AFTER aconserver;