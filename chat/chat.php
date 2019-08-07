<?php
// Référence au fichier qui contient la classe Chat.
require_once("chat.class.php");
// Obtenir l'opération à effectuer.
$mode = $_POST['mode'];
 
// Par défaut, l'id du dernier message est 0.
$id = 0;
// Créer une nouvelle instance de Chat.
$chat = new Chat();

// Si l'opération est SendAndRetrieve.
if($mode == 'SendAndRetrieveNew')
{
  // Obtenir les paramètres d'action pour l'ajout d'un nouveau message.
  $name = $_POST['name']; 
  $message = $_POST['message'];
  $color = $_POST['color'];
  $id = $_POST['id'];
  
  // Vérifier la validité des valeurs.
  if ($name != '' && $message != '' && $color != '') 
  {
    // Publier le message dans la base de données.
    $chat->postMessage($name, $message, $color); 
  }
}
// Si l'opération est DeleteAndRetrieve.
elseif($mode == 'DeleteAndRetrieveNew')
{
  // Supprimer tous les messages existants.
  $chat->deleteMessages();         
}
// Si l'opération est Retrieve.
elseif($mode == 'RetrieveNew')
{
  // Obtenir l'id du dernier lu par le client.
  $id = $_POST['id'];    
}

// Effacer la sortie.
if(ob_get_length()) ob_clean();
// Envoyer des en-têtes pour empêcher les navigateurs de mettre
// le contenu en cache.
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT'); 
header('Cache-Control: no-cache, must-revalidate'); 
header('Pragma: no-cache');
header('Content-Type: application/json');
// Obtenir les nouveaux messages à partir du serveur.
echo json_encode($chat->retrieveNewMessages($id));
?>
