<?php
// Nom du fichier image.
$imgfile='palette.png';
// Charger le fichier image.
$img=imagecreatefrompng($imgfile);
// Obtenir les coordonnées du point où l'utilisateur a cliqué.
$offsetx=$_GET['offsetx'];
$offsety=$_GET['offsety'];
// Obtenir la couleur correspondante.
$rgb = ImageColorAt($img, $offsetx, $offsety);
$r = ($rgb >> 16) & 0xFF;
$g = ($rgb >> 8) & 0xFF;
$b = $rgb & 0xFF;
// Retourner le code de la couleur.
echo json_encode(array("color" => sprintf('#%02s%02s%02s', dechex($r), dechex($g), dechex($b))));
?>
