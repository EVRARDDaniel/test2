<?php
// Indiquer que le contenu de la sortie est de type JSON.
header('Content-Type: text/json');

// Créer le tableau de la réponse.
$response = array(
 "books" => array(
  array(
"title" => "AJAX et PHP : Comment construire des applications web réactives",
"isbn" =>"978-2100506842")));

// Encoder la tableau au format JSON.
echo json_encode($response);
?>