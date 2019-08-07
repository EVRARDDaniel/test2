<?php
// Charger la configuration de la bse de données.
require_once ('config.php');

// Classe de prise en charge de la validation AJAX et PHP du formulaire web.
class Validate
{
  // Enregistrer la connexion à la base de données.
  private $mMysqli;
  
  // Le constructeur ouvre la connexion à la base de données.
  function __construct()
  {
    $this->mMysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
  }

  // Le destructeur ferme la connexion à la base de données.
  function __destruct()
  {
    $this->mMysqli->close();      
  }
    
  // Prise en charge de la validation AJAX, vérification d'une seule valeur.
  public function ValidateAJAX($inputValue, $fieldID)
  {
    // Déterminer le champ à valider et effectuer la validation.
    switch($fieldID)
    {
      // Vérifier que le pseudonyme est valide.
      case 'txtUsername':
        return $this->validateUserName($inputValue);
        break;
        
      // Vérifier que le nom est valide.
      case 'txtName':
        return $this->validateName($inputValue);
        break;
        
      // Vérifier qu'un genre a été choisi.
      case 'selGender':
        return $this->validateGender($inputValue);
        break;
        
      // Vérifier que le jour de naissance est valide.
      case 'txtBthDay':
        return $this->validateBirthDay($inputValue);
        break;
        
      // Vérifier que le mois de naissance est valide.
      case 'selBthMonth':
        return $this->validateBirthMonth($inputValue);
        break;
        
      // Vérifier que l'année de naissance est valide.
      case 'txtBthYear':
        return $this->validateBirthYear($inputValue);
        break;
        
      // Vérifier que l'adresse e-mail est valide.
      case 'txtEmail':
        return $this->validateEmail($inputValue);
        break;
        
      // Vérifier que le numéro de téléphone est valide.
      case 'txtPhone':
        return $this->validatePhone($inputValue);
        break;
      
      // Vérifier que la case "J'ai lu les conditions d'utilisation" est cochée.
      case 'chkReadTerms':
        return $this->validateReadTerms($inputValue);
        break;
    }
  }
  
  // Valider tous les champs du formulaire lors de son envoi.
  public function ValidatePHP()
  {
    // Indicateur d'erreur. Vaut 1 si des erreurs sont trouvées.
    $errorsExist = 0;
    // Effacer le fanion des erreurs dans la session.
    if (isset($_SESSION['errors']))
      unset($_SESSION['errors']);
    // Par défaut, tous les champs sont considérés valides.
    $_SESSION['errors']['txtUsername'] = 'hidden';
    $_SESSION['errors']['txtName'] = 'hidden';
    $_SESSION['errors']['selGender'] = 'hidden';
    $_SESSION['errors']['selBthMonth'] = 'hidden';
    $_SESSION['errors']['txtBthDay'] = 'hidden';
    $_SESSION['errors']['txtBthYear'] = 'hidden';
    $_SESSION['errors']['txtEmail'] = 'hidden';
    $_SESSION['errors']['txtPhone'] = 'hidden';
    $_SESSION['errors']['chkReadTerms'] = 'hidden';
    
    // Valider le pseudonyme.
    if (!$this->validateUserName($_POST['txtUsername']))
    {
      $_SESSION['errors']['txtUsername'] = 'error';
      $errorsExist = 1;
    }
    
    // Valider le nom.
    if (!$this->validateName($_POST['txtName']))
    {
      $_SESSION['errors']['txtName'] = 'error';
      $errorsExist = 1;
    }
  
    // Valider le genre.
    if (!$this->validateGender($_POST['selGender']))
    {
      $_SESSION['errors']['selGender'] = 'error';
      $errorsExist = 1;
    }
    
    // Valider le jour de naissance.
    if (!$this->validateBirthDay($_POST['txtBthDay']))
    {
      $_SESSION['errors']['txtBthDay'] = 'error';
      $errorsExist = 1;
    }
    
    // Valider le mois de naissance.
    if (!$this->validateBirthMonth($_POST['selBthMonth']))
    {
      $_SESSION['errors']['selBthMonth'] = 'error';
      $errorsExist = 1;
    }
    
    // Valider l'année et la date de naissance.
    if (!$this->validateBirthYear($_POST['selBthMonth'] . '#' . 
                                  $_POST['txtBthDay'] . '#' . 
                                  $_POST['txtBthYear']))
    {
      $_SESSION['errors']['txtBthYear'] = 'error';
      $errorsExist = 1;
    }
    
    // Valider l'adresse e-mail.
    if (!$this->validateEmail($_POST['txtEmail']))
    {
      $_SESSION['errors']['txtEmail'] = 'error';
      $errorsExist = 1;
    }
  
    // Valider le n° de téléphone.
    if (!$this->validatePhone($_POST['txtPhone']))
    {
      $_SESSION['errors']['txtPhone'] = 'error';
      $errorsExist = 1;
    }
    
    // Valider la lecture des conditions.
    if (!isset($_POST['chkReadTerms']) || 
        !$this->validateReadTerms($_POST['chkReadTerms']))
    {
      $_SESSION['errors']['chkReadTerms'] = 'error';
      $_SESSION['values']['chkReadTerms'] = '';
      $errorsExist = 1;
    }

    // En l'absence d'erreur, aller à la page de validation réussie.
    if ($errorsExist == 0)
    {
      return 'allok.php';
    }
    else
    {
      // En cas d'erreur, mémoriser les valeurs saisies par l'utilisateur.
      foreach ($_POST as $key => $value)
      {
        $_SESSION['values'][$key] = $_POST[$key];
      }
      return 'index.php';
    }
  }

  // Valider le pseudonyme (ne doit pas être vide, ni déjà connu).
  private function validateUserName($value)
  {
    // Enlever les espaces dans la valeur.
    $value = $this->mMysqli->real_escape_string(trim($value));
    // Un pseudonyme vide est invalide.
    if ($value == null) 
      return 0; // Invalide.
    // Vérifier si le pseudonyme existe déjà dans la base de données.
    $query = $this->mMysqli->query('SELECT user_name FROM users ' .
                                   'WHERE user_name="' . $value . '"');
    if ($this->mMysqli->affected_rows > 0)
      return '0'; // Invalide.
    else
      return '1'; // Valide.
  }

  // Valider le nom.
  private function validateName($value)
  {
    // Enlever les espaces dans la valeur.
    $value = trim($value);
    // Un nom vide est invalide.
    if ($value) 
      return 1; // Valide.
    else
      return 0; // Invalide
  }

  // Valider le genre.
  private function validateGender($value)
  {
    // Le genre doit être indiqué.
    return ($value == '0') ? 0 : 1;
  }  

  // Valider le jour de naissance.
  private function validateBirthDay($value)
  {
    // Le jour ne doit pas être null et dans la plage 1 à 31.
    return ($value == '' || $value > 31 || $value < 1) ? 0 : 1;
  }

  // Valider le mois de naissance.
  private function validateBirthMonth($value)
  {
    // Le mois ne doit pas être null et dans la plage 1 à 12.
    return ($value == '' || $value > 12 || $value < 1) ? 0 : 1;
  }  
  
  // Valider l'année de naissance et la date complète.
  private function validateBirthYear($value)
  {
    // L'année de naissance est entre 1900 et 2000.
    // Obtenir la date complète (mm#jj#aaaa)
    $date = explode('#', $value);
    // Date invalide en l'absence d'un jour, d'un mois ou d'une année.
    if (!$date[0]) return 0;
    if (!$date[1] || !is_numeric($date[1])) return 0;
    if (!$date[2] || !is_numeric($date[2])) return 0;
    // Vérifier la date.
    return (checkdate($date[0], $date[1], $date[2])) ? 1 : 0;
  }

  // Valider l'adresse e-mail.
  private function validateEmail($value)
  {
    // Formats valides : *@*.*, *@*.*.*, *.*@*.*, *.*@*.*.*).
    return (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i', $value)) ? 0 : 1;
  }
  
  // Valider le n° de téléphone.
  private function validatePhone($value)
  {
    // Format valide : ##-##-##-##-## 
    return (!preg_match('/^[0-9]{2}-*[0-9]{2}-*[0-9]{2}-*[0-9]{2}-*[0-9]{2}$/', $value)) ? 0 : 1;
  }

  // Vérifier que l'utilisateur a lu les conditions.
  private function validateReadTerms($value)
  {
    // Valeur valide : 'true'.
    return ($value == 'true' || $value == 'on') ? 1 : 0;
  }
}
?>
