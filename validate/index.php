<?php
  require_once ('index_top.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Validation AJAX de formulaire avec PHP et MySQL</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="validate.css" rel="stylesheet" type="text/css" />  
  </head>
  
  <body onload="setFocus();">
  <script type="text/javascript" src="json2.js"></script>
  <script type="text/javascript" src="xhr.js"></script>
  <script type="text/javascript" src="validate.js"></script>
  <fieldset>
    <legend class="txtFormLegend">Formulaire d'inscription d'un nouvel utilisateur</legend>
    <br />
    <form name="frmRegistration" method="post" action="validate.php">
      <input type="hidden" name="validationType" value="php"/>
        <!-- Pseudonyme -->
        <label for="txtUsername">Pseudonyme souhaité :</label>
        <input id="txtUsername" name="txtUsername" type="text" 
               onblur="validate(this.value, this.id)" 
               value="<?php echo $_SESSION['values']['txtUsername'] ?>" />
        <span id="txtUsernameFailed"
              class="<?php echo $_SESSION['errors']['txtUsername'] ?>">
          Ce pseudonyme existe déjà ou le champ est vide.
        </span>
        <br />
  
        <!-- Nom -->
        <label for="txtName">Nom :</label>
        <input id="txtName" name="txtName" type="text" 
               onblur="validate(this.value, this.id)" 
               value="<?php echo $_SESSION['values']['txtName'] ?>" />
        <span id="txtNameFailed"
              class="<?php echo $_SESSION['errors']['txtName'] ?>">
          Veuillez indiquer votre nom. 
        </span>
        <br />
          
        <!-- Genre -->
        <label for="selGender">Genre :</label>
        <select name="selGender" id="selGender" 
                onblur="validate(this.value, this.id)">
          <?php buildOptions($genderOptions, 
                             $_SESSION['values']['selGender']); ?>
        </select>
        <span id="selGenderFailed"
              class="<?php echo $_SESSION['errors']['selGender'] ?>">
          Veuillez indiquer votre genre. 
        </span>
        <br />
          
        <!-- Date de naissance -->
        <label for="selBthMonth">Date de naissance :</label>
        
        <!-- Jour -->
        <input type="text" name="txtBthDay" id="txtBthDay" maxlength="2" 
               size="2" 
               onblur="validate(this.value, this.id)" 
               value="<?php echo $_SESSION['values']['txtBthDay'] ?>" />
        &nbsp;-&nbsp;
        <!-- Mois -->
        <select name="selBthMonth" id="selBthMonth" 
                onblur="validate(this.value, this.id)">
          <?php buildOptions($monthOptions, 
                             $_SESSION['values']['selBthMonth']); ?>
        </select>
        &nbsp;-&nbsp;        
        <!-- Année -->
        <input type="text" name="txtBthYear" id="txtBthYear" maxlength="4" 
               size="2" onblur="validate(document.getElementById('selBthMonth').options[document.getElementById('selBthMonth').selectedIndex].value + '#' + document.getElementById('txtBthDay').value + '#' + this.value, this.id)" 
               value="<?php echo $_SESSION['values']['txtBthYear'] ?>" />
        
        <!-- Validation Jour, Mois, Année -->
        <span id="txtBthDayFailed"
              class="<?php echo $_SESSION['errors']['txtBthDay'] ?>">
          Veuillez indiquer le jour de naissance. 
        </span>
        <span id="selBthMonthFailed"
              class="<?php echo $_SESSION['errors']['selBthMonth'] ?>">
          Veuillez indiquer le mois de naissance. 
        </span>
        <span id="txtBthYearFailed"
              class="<?php echo $_SESSION['errors']['txtBthYear'] ?>">
          Veuillez indiquer une date valide. 
        </span>
        <br />
        
        <!-- Adresse électronique -->
        <label for="txtEmail">E-mail :</label>
        <input id="txtEmail" name="txtEmail" type="text" 
               onblur="validate(this.value, this.id)" 
               value="<?php echo $_SESSION['values']['txtEmail'] ?>" />
        <span id="txtEmailFailed"
              class="<?php echo $_SESSION['errors']['txtEmail'] ?>">
          L'adresse e-mail est invalide.
        </span>
        <br />
          
        <!-- Numéro de téléphone -->
        <label for="txtPhone">N° de téléphone :</label>
        <input id="txtPhone" name="txtPhone" type="text" 
               onblur="validate(this.value, this.id)" 
               value="<?php echo $_SESSION['values']['txtPhone'] ?>" />
        <span id="txtPhoneFailed"
              class="<?php echo $_SESSION['errors']['txtPhone'] ?>">
          Veuillez indiquer un numéro valide au format xx-xx-xx-xx-xx. 
        </span>
        <br />
          
        <!-- Case des conditions d'utilisation -->
        <input type="checkbox" id="chkReadTerms" name="chkReadTerms" 
               class="left" 
               onblur="validate(this.checked, this.id)" 
               <?php if ($_SESSION['values']['chkReadTerms'] == 'on') 
                     echo 'checked="checked"' ?> /> 
        J'ai lu les conditions d'utilisation
        <span id="chkReadTermsFailed"
              class="<?php echo $_SESSION['errors']['chkReadTerms'] ?>">
          N'oubliez pas de lire les conditions d'utilisation. 
        </span>
        
        <!-- Fin du formulaire -->
        <hr />
        <span class="txtSmall">Note : tous les champs sont obligatoires.</span>
        <br /><br />
        <input type="submit" name="submitbutton" value="Valider" 
               class="left button" />
      </form>
    </fieldset>
  </body>
</html>
