<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>AJAX par la pratique : Travailler avec PHP et MySQL</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />	
  </head>
  <body>

<?php
// Charger le fichier de configuration.
require_once('error_handler.php');
require_once('config.php');
// Se connecter à la base de données.
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);      
// Requête SQL à exécuter.
$query = 'SELECT user_id, user_name FROM users'; 
// Exécuter la requête.
$result = $mysqli->query($query);  
// Parcourir les résultats.
while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
{
  // Extraire l'identifiant et le nom de l'utilisateur.
  $user_id = $row['user_id'];
  $user_name = $row['user_name'];
  // Utiliser les données (nous les affichons).
  echo 'L\'utilisateur ' . $user_id . ' se nomme ' . $user_name . '<br/>';
}

// Fermer le flux d'entrée.
$result->close();
// Fermer la connexion à la base de données.
$mysqli->close();
?>

  </body>
</html>
