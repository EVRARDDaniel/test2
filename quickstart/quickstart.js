// Mémoriser la référence à l’objet XMLHttpRequest.
var xmlHttp = createXmlHttpRequestObject(); 

// Obtenir l’objet XMLHttpRequest.
function createXmlHttpRequestObject() 
{
  // Garder la référence à l’objet XMLHttpRequest.
  var xmlHttp;
  // Si le navigateur est Internet Explorer 6 ou plus ancien.
  if(window.ActiveXObject)
  {
    try {
      xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch (e) {
      xmlHttp = false;
    }
  }
  // Si le navigateur est Mozilla ou autres.
  else
  {
    try {
      xmlHttp = new XMLHttpRequest();
    }
    catch (e) {
      xmlHttp = false;
    }
  }
  // Retourner l’objet créé ou afficher un message d’erreur.
  if (!xmlHttp)
    alert("Erreur de création de l'objet XMLHttpRequest.");
  else 
    return xmlHttp;
}

// Effectuer une requête HTTP asynchrone en utilisant l’objet XMLHttpRequest.
function process()
{
  // Continuer uniquement si l’objet xmlHttp est disponible.
  if (xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
  {
    // Retrouver le nom saisi par l’utilisateur dans le formulaire.
    name = encodeURIComponent(document.getElementById("myName").value);
    // Exécuter la page quickstart.php depuis le serveur.
    xmlHttp.open("GET", "quickstart.php?name=" + name, true);  
    // Définir la méthode pour traiter les réponses du serveur.
    xmlHttp.onreadystatechange = handleServerResponse;
    // Faire la demande au serveur.
    xmlHttp.send(null);
  }
  else
    // Si la connexion est indisponible, tenter à nouveau après 1 seconde.
    setTimeout('process()', 1000);
}

// Fonction de rappel exécutée automatiquement lorsqu'un message est reçu 
// depuis le serveur.
function handleServerResponse() 
{
  // Continuer uniquement si la transaction est terminée.
  if (xmlHttp.readyState == 4) 
  {
    // Le code 200 indique une transaction terminée avec succès.
    if (xmlHttp.status == 200) 
    { 
      // Extraire la réponse XML reçue du serveur.
      xmlResponse = xmlHttp.responseXML;
      // Prendre l'élément "document" (l'élément racine) dans la structure XML.
      xmlDocumentElement = xmlResponse.documentElement;
      // Obtenir le texte du message, qui est dans le premier élément enfant 
	  // de l'élément document.
      helloMessage = xmlDocumentElement.firstChild.data;
      // Afficher les données reçues du serveur.
      document.getElementById("divMessage").innerHTML = 
                                            '<i>' + helloMessage + '</i>';
      // Reprendre la séquence.
      setTimeout('process()', 1000);
    } 
    // Un code HTTP différent de 200 indique une erreur.
    else 
    {
      alert("Problème d'accès au serveur : " + xmlHttp.statusText);
    }
  }
}
