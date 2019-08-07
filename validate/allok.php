<?php
  // Effacer les données enregistrées dans la sessions
  session_start();
  session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Validation AJAX de formulaire</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="validate.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    Votre inscription a été validée !<br />
    <a href="index.php" title="Retour">&lt;&lt; Retour</a>
  </body>
</html>
