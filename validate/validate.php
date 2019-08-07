<?php
// Démarrer une session PHP.
session_start();
// Charger le script de gestion des erreurs et la classe de validation.
require_once ('error_handler.php');
require_once ('validate.class.php');
  
// Créer un nouvel objet de validation.
$validator = new Validate();

// Lire le type de validation (PHP ou AJAX ?).
$validationType = '';  
if (isset($_POST['validationType']))
{
  $validationType = $_POST['validationType'];
}

// Validation AJAX ou validation PHP ?
if ($validationType == 'php')
{
  // La validation PHP est réalisée par la méthode ValidatePHP, qui retourne
  // la page vers laquelle l'internaute doit être redirigé (la page allok.php
  // si les données sont valides, sinon la page index.php).
  header("Location:" . $validator->ValidatePHP());  
}
else
{
  // La validation AJAX est réalisée par la méthode ValidateAJAX. Les
  // résultats sont utilisés pour créer un document XML renvoyé au client.
  $response = array("result" =>  
  $validator->ValidateAJAX($_POST['inputValue'], $_POST['fieldID']),
    "fieldid" => $_POST['fieldID'] );
   
  // Générer la réponse.
  if(ob_get_length()) ob_clean();
  header('Content-Type: application/json');
  echo json_encode($response);
}
?>
