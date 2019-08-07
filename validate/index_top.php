<?php
// Activer la session PHP.
session_start();

// Construire les balises HTML <option>.
function buildOptions($options, $selectedOption)
{
  foreach ($options as $value => $text)
  {
    if ($value == $selectedOption)
    {
      echo '<option value="' . $value . 
           '" selected="selected">' . $text . '</option>';
    }
    else
    {
      echo '<option value="' . $value . '">' . $text . '</option>';
    }
  }
}

// Initialiser le tableau des genres.
$genderOptions = array("0" => "[Choisir]",
                       "1" => "Homme",
                       "2" => "Femme");

// Initialiser le tableau des mois.
$monthOptions = array("0" => "[Choisir]",
                      "1" => "Janvier",
                      "2" => "Février",
                      "3" => "Mars",
                      "4" => "Avril",
                      "5" => "Mai",
                      "6" => "Juin",
                      "7" => "Juillet",
                      "8" => "Août",
                      "9" => "Septembrr",
                      "10" => "Octobre",
                      "11" => "Novembre",
                      "12" => "Décembre");

// Initialiser des variables de session pouré viter que PHP 
// ne se plaigne.
if (!isset($_SESSION['values']))
{
  $_SESSION['values']['txtUsername'] = '';
  $_SESSION['values']['txtName'] = '';
  $_SESSION['values']['selGender'] = '';
  $_SESSION['values']['selBthMonth'] = '';
  $_SESSION['values']['txtBthDay'] = '';
  $_SESSION['values']['txtBthYear'] = '';
  $_SESSION['values']['txtEmail'] = '';
  $_SESSION['values']['txtPhone'] = '';
  $_SESSION['values']['chkReadTerms'] = '';
}
if (!isset($_SESSION['errors']))
{
  $_SESSION['errors']['txtUsername'] = 'hidden';
  $_SESSION['errors']['txtName'] = 'hidden';
  $_SESSION['errors']['selGender'] = 'hidden';
  $_SESSION['errors']['selBthMonth'] = 'hidden';
  $_SESSION['errors']['txtBthDay'] = 'hidden';
  $_SESSION['errors']['txtBthYear'] = 'hidden';
  $_SESSION['errors']['txtEmail'] = 'hidden';
  $_SESSION['errors']['txtPhone'] = 'hidden';
  $_SESSION['errors']['chkReadTerms'] = 'hidden';
}
?>
