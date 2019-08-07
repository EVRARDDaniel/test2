<?php
// Nous générons une sortie XML.
header('Content-Type: text/xml');
// Créer l’en-tête XML.
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
// Créer l'élément <response>.
echo '<response>';
// Obtenir le nom de l'utilisateur.
$name = $_GET['name'];
// Générer une sortie qui dépend du nom d’utilisateur reçu du client.
$userNames = array('YODA', 'AUDRA', 'BOGDAN', 'CRISTIAN');
if (in_array(strtoupper($name), $userNames))
  echo 'Bonjour maître ' . htmlentities($name) . ' !';
else if (trim($name) == '')
  echo 'Étranger, daigne donner ton nom !';
else
  echo htmlentities($name) . ', je ne vous connais pas !';
// Fermer l'élément <response>.
echo '</response>';
?>
