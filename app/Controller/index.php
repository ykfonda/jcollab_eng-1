<?php
// TEST POUR LANCER LE SCRIPT DEPUIS LE PLANIFICATEUR

function syncmanuel()
{
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jcollab_4x";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Préparer la requête SQL d'insertion
$sql = "INSERT INTO testo (Name) VALUES ('VEN')";

// Exécuter la requête SQL
if ($conn->query($sql) === TRUE) {
    echo "Nouvelle ligne insérée avec succès";
} else {
    echo "Erreur d'insertion de ligne: " . $conn->error;
}

// Fermer la connexion à la base de données
$conn->close();

}


?>
