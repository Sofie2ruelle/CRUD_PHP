<?php
// Création du script pour se connecter au serveur de BDD MySQL

/* Database connnexion */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'ecf');

/* connexion à la base de données */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

/* Vérifier la connection */
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>