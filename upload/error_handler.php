<?php
// Fixer la méthode de gestion des erreurs à error_handler.
set_error_handler('error_handler', E_ALL);
// Fonction de gestion des erreurs.
function error_handler($errNo, $errStr, $errFile, $errLine)
{
  // Supprimer toute sortie déjà générée.
  if(ob_get_length()) ob_clean();
  header('Content-Type: text/plain;charset=utf-8');
  // Envoyer le message d'erreur sur la sortie.
  $error_message = 'N° d\'erreur : ' . $errNo . chr(10) .
                   'Message     : ' . $errStr . chr(10) .
                   'Emplacement : ' . $errFile . 
                   ', ligne ' . $errLine;
  echo $error_message;
  // Empêcher le traitement d'autres scripts PHP.
  exit;
}
?>