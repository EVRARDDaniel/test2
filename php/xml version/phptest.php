<?php
// Indiquer que le contenu de la sortie est de type XML.
header('Content-Type: text/xml');
// Créer le nouveau document XML.
$dom = new DOMDocument();

// Créer l'élément <response> racine.
$response = $dom->createElement('response');
$dom->appendChild($response);

// Créer l'élément <books> et l'ajouter comme enfant de <response>.
$books = $dom->createElement('books');
$response->appendChild($books);

// Créer l'élément <title> pour le livre.
$title = $dom->createElement('title');
$titleText = $dom->createTextNode
    ('AJAX et PHP : Comment construire des applications web réactives');
$title->appendChild($titleText);

// Créer l'élément <isbn> pour le livre.
$isbn = $dom->createElement('isbn');
$isbnText = $dom->createTextNode('978-2100506842');
$isbn->appendChild($isbnText);

// Créer l'élément <book>. 
$book = $dom->createElement('book');
$book->appendChild($title);
$book->appendChild($isbn);

// Ajouter <book> comme enfant de <books>.
$books->appendChild($book);

// Placer la structure XML dans une chaîne de caractères.
$xmlString = $dom->saveXML();
// Sortir la chaîne XML.
echo $xmlString;
?>