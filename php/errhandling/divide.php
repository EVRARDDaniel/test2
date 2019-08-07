<?php
// Charger le module de gestion des erreurs.
require_once('error_handler.php');
// Indiquer que la sortie est un document XML.document
header('Content-Type: text/xml');
// Calculer le résultat.
$firstNumber = $_GET['firstNumber'];
$secondNumber = $_GET['secondNumber'];
$result = $firstNumber / $secondNumber;
// Créer un nouveau document XML.
$dom = new DOMDocument();
// Créer l'élément <response> racine et l'ajouter au document.
$response = $dom->createElement('response');
$dom->appendChild($response);
// Ajouter la valeur calculée sous forme de nœud texte enfant de <response>.
$responseText = $dom->createTextNode($result);
$response->appendChild($responseText);
// Placer la structure XML dans une chaîne de caractères.
$xmlString = $dom->saveXML();
// Envoyer la chaîne XML en sortie.
echo $xmlString;
?>
