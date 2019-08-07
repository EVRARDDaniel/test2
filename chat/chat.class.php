<?php
// Charger le fichier de configuration.
require_once('config.php');
// Charger le module de gestion des erreurs.
require_once('error_handler.php');

// Classe Chat qui implémente les fonctionnalités serveur.
class Chat
{
  // Gestionnaire de base de données.
  private $mMysqli;  
  
  // Le constructeur ouvre la connexion à la base de données.
  function __construct() 
  {   
    // Se connecter à la base de données.
    $this->mMysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);      
  }
 
  // Le destructeur ferme la connexion à la base de données.
  public function __destruct() 
  {
    $this->mMysqli->close();
  }

  // Tronquer la table qui contient les messages.
  public function deleteMessages()
  { 
    // Construire la requête SQL qui supprime les messages.
    $query = 'TRUNCATE TABLE chat'; 
    // Exécuter la requête SQL.
    $result = $this->mMysqli->query($query);      
  }
  
  /*
   La méthode postMessages insère un message dans la base de données.
   - $name représente le nom de l'utilisateur qui a posté le message
   - $message est le message posté
   - $color indique la couleur choisie par l'utilisateur
  */ 
  public function postMessage($name, $message, $color)
  {  
    // Échapper les données pour les ajouter de manière sécurisée à la base de données.
    $name = $this->mMysqli->real_escape_string($name);
    $message = $this->mMysqli->real_escape_string($message);
    $color = $this->mMysqli->real_escape_string($color);
    // Construire la requête SQL qui ajoute un nouveau message au serveur.
    $query = 'INSERT INTO chat(posted_on, user_name, message, color) ' .
             'VALUES (NOW(), "' . $name . '" , "' . $message . 
             '","' . $color . '")'; 
    //  Exécuter la requête SQL.
    $result = $this->mMysqli->query($query);      
  }

  /*
   La méthode retrieveNewMessages obtient les nouveaux messages qui ont
   été postés sur le serveur.
   - $id paramètre envoyé par le client qui correspond à l'identifiant du
         dernier message reçu par ce client. Les messages plus récents que
		 $id sont pris dans la base de données et renvoyés au client au
		 format JSON.
  */
  public function retrieveNewMessages($id=0) 
  {
    // Échapper les données.
    $id = $this->mMysqli->real_escape_string($id);
    // Construire la requête SQL qui obtient les nouveaux messages.
    if($id>0)
    {
      // Obtenir les messages plus récents que $id.
      $query = 
      'SELECT chat_id, user_name, message, color, ' . 
      '       DATE_FORMAT(posted_on, "%Y-%m-%d %H:%i:%s") ' . 
      '       AS posted_on ' .
      ' FROM chat WHERE chat_id > ' . $id . 
      ' ORDER BY chat_id ASC'; 
    }
    else
    {
      // Lors du premier chargement, obtenir les 50 derniers messages 
	  // à partir du serveur.
      $query = 
      ' SELECT chat_id, user_name, message, color, posted_on FROM ' .
      '    (SELECT chat_id, user_name, message, color, ' . 
 
      '       DATE_FORMAT(posted_on, "%Y-%m-%d %H:%i:%s") AS posted_on ' .
      '     FROM chat ' .
      '     ORDER BY chat_id DESC ' .
      '      LIMIT 50) AS Last50' . 
      ' ORDER BY chat_id ASC';
    } 
    //  Exécuter la requête SQL.
    $result = $this->mMysqli->query($query);  

    // Construire la réponse JSON.
	$response = array();
    // Ajouter le fanion de disponibilité.
    $response['clear']= $this->isDatabaseCleared($id);
	$response['messages']= array();
    // Vérifier si nous avons des résultats.
    if($result->num_rows)
    {      
      // Parcourir les messages lus pour construire la réponse.
      while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
      {
		$message = array();
        $message['id'] = $row['chat_id'];
        $message['color'] = $row['color'];
        $message['name'] = $row['user_name'];
        $message['time'] = $row['posted_on'];
        $message['message'] = $row['message'];        
		array_push($response['messages'],$message);
      }
      // Fermer la connexion à la base de données dès que possible.
      $result->close();
    }
    
    // Retourner la réponse JSON.
    return $response;    
  }
  
  /*
    La méthode isDatabaseCleared vérifie que la base de données est disponible
	suite au dernier appel au serveur.
	- $id identifiant du dernier message reçu par ce client.
  */
  private function isDatabaseCleared($id)
  {
    if($id>0)
    {
      // En vérifiant le nombre de lignes dont les identifiants sont inférieurs
	  // au dernier id vu par le client, nous déterminons si une oépration de
	  // troncation a été réalisée dans l'interim.
      $check_clear = 'SELECT count(*) old FROM chat where chat_id<=' . $id;
      $result = $this->mMysqli->query($check_clear);
      $row = $result->fetch_array(MYSQLI_ASSOC);      
            
      // Si une opération de troncation a eu lieu, la fenêtre des messages doit 
	  // être effacée.
      if($row['old']==0)
        return 'true';     
	  return 'false';
    }
    return 'true';
  }
}
?>
