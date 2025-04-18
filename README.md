#

# # Changelogs JCOLLAB [CRM POS KDS]

#

# JCOLLAB-2.X

JCOLLAB 2.X
Version initiale

# JCOLLAB-4.1

---------------------------------- POS

- Permission POS

* Fix bug dans les permissions Offert & Remise ticket => La permission d'accéder à une fonctionnalité donnée est basée sur le mot de passe d'un utilisateur ayant les autorisations requises pour cette fonctionnalité. Autrement dit, seuls les utilisateurs disposant du mot de passe approprié peuvent accéder et utiliser cette fonctionnalité.
* Fix bug des calcule

- Ventes POS (caisse => serveur)

* Synchronisation de caisse => serveur
* Vérifier statut de paiement POS, doit être payé
* Retirer le message de confirmation
* Redirection après la sync vers POS
* Redirection USER directement vers POS (user typecaissier) (etat = 2)
* Il faut pas prendre les provNOT LIKE PROV
  Api : "http://localhost:8081/JCOLLAB4X/Pos/syncmanuel"

- Synco la table avancePaiement

* BUG dans POS => récupérer le Dépot (la ou il y a ==Vente)
* Tous les utilisateurs ont le droit d'accéder au POS selon la t_Config
* Synco la table entreetrace Mouvements

- Ventes GLOVO (caisse => serveur)

* Nouvelle commande => Récupérer depuis le serveur et enregistrer dans POS
* Commandes traitées => Mise à jour de l'etat dans le serveur =2
* Commande annulée => Récupérer depuis le serveur et enregistrer dans POS
* Api : http://localhost:8081/JCOLLAB4X/Commandeglovos/insertGlovoApiPOS

- Ventes ECOM (caisse => serveur)
  à déclancher pop-up  
  ScénarioCaisse => vers le serveur  
  Data communiqué : ECOM + ECOM Détail + Client (selon l'exsitance)
  Voir le statut à synchroniser avec Youssef
  Api : http://localhost:8081/JCOLLAB4X/Pos/syncmanuelecom

- Vérification de multi sites

* API SERVER https://iafsys.app/jcollab.ae/clients/apiGetClientsToSync
* Insération des données dans la basesen cours ..
* un conflit => il faut voir le module ECOM => créatin de client => pas d'Auto-Incr

- Chéque cadeaux
  les étapes de synchronisation des cheques cadeaux :
  // - 1 | Collecter les données des chèques-cadeaux depuis le serveur
  // - 2 | Au cas d'appel dans le POS
  => Récupérer les données de cette table en fonction de la condition liée à l'identifiant du chèque-cadeau.
  => Enregistrez-les dans la table locale.

API : /Pos/chequecadeaus

---------------------------------- AUTRES MODULES

- Nouveau ModuleConfigs d'application

* Gestion des informations technique de l'application
* Type = pour switcher entre les modes d'utisationPOS / Administration / Serveur.
* Switcher des stores => limité dans le store actual (voir la table config) => Caisse ID et Store ID

- Nouveau ModuleSynchronisation
  Permet de stocker des informations de la sync au fur et à mésure

- Connexion

* Les utilisateurs peuvenet se connecter aux :
  -> POSdepuis les machines POS type_app = 1
  -> Administrationau niveau local type_app = 2
  -> Serveurau niveau local type_app = 3
* Les deux type_app 1 & 2 se connecte à la base de store et caisse de la t_Configs
* Le type_app 3 se connecte à la base de store de la t_User et t_Stores_users

- HEADER de l'application (default.ctp)

* Procéder à une réorganisation de la liste des stores
* Ajuster le design et la position des compteurs pour chaque utilisateur.
* Obtenir le store associé à l'utilisateur connecté en utilisant son adresse IP publique.

- Fonctionnalité FILTRE PAR IP PUBLIC

* Un utilisateur sans privilèges administrateur peut uniquement accéder à son propre magasin.
* En revanche, un administrateur peut consulter tous les magasins, indépendamment de leur adresse IP publique.
* Chaque magasin est associé à l'adresse IP publique de la machine cliente qui y est connectée.
* BUG de IP PUBLIC : affectation dans un $\_SESSION (variable superG)

- Sync Client (server => caisse)
  Syncronisation de la liste produit depuis le serveur vers la caisse

- Sync Produits (server => caisse) \*\*\*

* API SERVERhttps://iafsys.app/jcollab.ae/ingredients/apiGetProduitsToSync
* Il est nécessaire de désactiver l'auto-incrémentation pour la colonne "ID" afin que le programme puisse ajouter des éléments ayant le même identifiant que ceux du serveur.
* Le programme ne pas être pas exécuter pour mettre à jour les données sauf que :
  $date_update_api > $date_update_db
* Lien de l'api dynamique (lié à la table: Config)
* Le déclencheur de la synchronisation de la liste des produits se trouve dans le POS.

- Sync USERS + permissions (server => caisse) \*\*\*

* API SERVER : https://iafsys.app/jcollab.ae/users/apiGetUsersToSync

- MISC TASKS

* Si le client a reçu une offre gratuite, le mode de paiement par défaut doit également être défini sur "Offert".
* Verifier les images / icons des mode de paiement

#

# # VIDAGE DE LA BASE DES DONNEES

#

Pour les nouvelles instances :

- Vidage des tables de la base de données

TRUNCATE TABLE `commande_glovo_details`;
TRUNCATE TABLE `commandes_glovo`;
TRUNCATE TABLE `salepoints`;
TRUNCATE TABLE `salepointdetails`;
TRUNCATE TABLE `entrees`;
TRUNCATE TABLE `commandedetails`;
TRUNCATE TABLE `depotproduits`;
TRUNCATE TABLE `devis`;
TRUNCATE TABLE `commandes`;
TRUNCATE TABLE `ecommercedetails`;
TRUNCATE TABLE `ecommerces`;
TRUNCATE TABLE `attentedetails`;
TRUNCATE TABLE `attentes`;
TRUNCATE TABLE `avances`;
TRUNCATE TABLE `fidelites`;
TRUNCATE TABLE `fraislivraisons`;
TRUNCATE TABLE `fraislivraisons`;
TRUNCATE TABLE `mouvements`;
TRUNCATE TABLE `paiement_wallets`;
TRUNCATE TABLE `synchronisations`;
TRUNCATE TABLE `walletdetails`;
TRUNCATE TABLE `wallets`;
TRUNCATE TABLE `inventaires`;
TRUNCATE TABLE `inventairedetails`;
TRUNCATE TABLE `bonentrees`;
TRUNCATE TABLE `bonentreedetails`;
TRUNCATE TABLE `sortiedetails`;
TRUNCATE TABLE `sessionusers`;
TRUNCATE TABLE `mouvements`;
TRUNCATE TABLE `mouvementprincipals`;
TRUNCATE TABLE `bonlivraisondetails`;
TRUNCATE TABLE `bonlivraisons`;
TRUNCATE TABLE `bonreceptions`;
TRUNCATE TABLE `bonreceptiondetails`;
TRUNCATE TABLE `sortiedetails`;
TRUNCATE TABLE `mouvementprincipals`;

#

# # ETAPE D'INSTALLATION

#

1 - Mise en place d'un environnement comprenant un serveur web et une base de données.
2 - Configuration du logiciel de gestion de versions (Git).
3 - Récupération de la dernière version disponible à partir du serveur de gestion de versions.
4 - Vérification et validation des informations de connexion saisies dans le fichier database.php.
5 - Actualisation des informations de configuration de l'application dans /setup.

#

# # TABLE POS

#

// Table POS avec un ID sans auto-incr

#

# # PRE-REQUIS

#

- CLIENT (POS)

* Planificateur de tâches
* XAMP Serveur
* CA Bundle

- SERVEUR (CPANEL)

* MySQL distant®

- CLIENT & SERVEUR

* PHP 5.6
* bcmath
* bz2
* calendar
* core
* ctype
* curl
* date
* dom
* ereg
* exif
* fileinfo
* filter
* ftp
* gd
* gettext
* gmp
* zlib
* hash
* iconv
* imap
* intl
* ioncube_loader
* json
* libxml
* mbstring
* mcrypt
* mhash
* mysql
* mysqli
* mysqlnd
* odbc
* openssl
* pcntl
* pcre
* pdo
* pdo_mysql
* pdo_odbc
* pdo_sqlite
* phar
* posix
* readline
* reflection
* session
* shmop
* simplexml
* soap
* sockets
* spl
* sqlite3
* standard
* tokenizer
* wddx
* xml
* xmlreader
* xmlwriter
* xsl
* zip

* Synchronisation des données : JCOLLAB <=> CSB :

|| BL ||

Etape 1 : Scanner et importer les données depuis fichier
http://localhost/JCOLLAB/JCOLLAB4X_server/sortie/importblcsb
"http://137.135.188.139/jcollab/sortie/importblcsb"

Etape 2 : Valider les données document CSB
http://localhost/JCOLLAB/JCOLLAB4X_server/sortie/validerimportblcsb
"http://137.135.188.139/jcollab/sortie/validerimportblcsb"

|| RT ||

Lors de la validation d'une expédition de type retour, JCOLLAB crée un fichier .csv contenant les données de retour.
Ce fichier est initialement stocké dans le dossier local /bon_retour. Pour assurer une sauvegarde, une copie de ce fichier est ensuite transférée vers le serveur à l'aide de la connexion FTP.

Reste à faire :

Gestion des stocks => module Inventaire
Stock : Utilisation d'un séparateur décimal
Historique des mouvements : Utilisation d'un séparateur décimal
Dans le module Sortie de stock : Ajout de la liste des magasins dans le filtre.
Vente par article : Filtrage par magasin et date
Détail du ticket
Vente POS : Modes 1 et 2
Indexation des tables :

- Tables d'expédition
  Synchronisation instantanée des ventes
  Meta :
- Ajouter les tableaux nécessaire
- Bug de génération de A4 : création de compte client à chaque fois de génération, voila partie administration
- Module Statistiques
- Faire une relation unité et Type Conditionnement



NEXA API
- Mot de passe te body config puor l'api de PRODUIT


API ORDER => dans la base des donées JCOLLAB il faut ajouté weight_ordered




Journal des modifications (CHANGELOG) :
03/03/2025 : Récupération des données
            Confirmation de l'API après l'enregistrement


- Nouvelle api => NEXA
- ECOM : Les new API