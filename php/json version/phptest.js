// Conserver une instance de XMLHttpRequest.
var xmlHttp = createXmlHttpRequestObject();

// Créer une instance de XMLHttpRequest.
function createXmlHttpRequestObject() 
{
  // Conserver une référence à l’objet XMLHttpRequest.
  var xmlHttp;
  // Créer l’objet XMLHttpRequest.
  try
  {
    // Supposer IE7, ou plus récent, ou un autre navigateur moderne.
    xmlHttp = new XMLHttpRequest();
  }
  catch (e)
  {
    // Supposer IE6, ou plus ancien.
    try
    {
      xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    catch(e) { }
  }
  // Retourner l’objet créé ou afficher un message d’erreur.
  if (!xmlHttp)
    alert("Erreur de création de l'objet XMLHttpRequest.");
  else 
    return xmlHttp;
}

// Lire un fichier depuis le serveur.
function process()
{
  // Continuer uniquement si l'objet xmlHttp est valide.
  if (xmlHttp)
  {
    // Tenter une connexion au serveur.
    try
    {
      // Initier la lecture du fichier depuis le serveur.
      xmlHttp.open("GET", "phptest.php", true);
      xmlHttp.onreadystatechange = handleRequestStateChange;
      xmlHttp.send(null);
    }
    // En cas d'échec, afficher l'erreur.
    catch (e)
    {
      alert("Connexion au serveur impossible :\n" + e.toString());
    }
  }
}

// Fonction appelée lorsque l'état de la réponse HTTP change.
function handleRequestStateChange() 
{
  // Lorsque readyState vaut 4, lire la réponse du serveur.
  if (xmlHttp.readyState == 4) 
  {
    // Continuer uniquement si l'état HTTP est "OK".
    if (xmlHttp.status == 200) 
    {
      try
      {
        // Faire quelque chose avec la réponse du serveur.
        handleServerResponse();
      }
      catch(e)
      {
        // Afficher un message d'erreur.
        alert("Erreur de lecture de la réponse : " + e.toString());
      }
    } 
    else
    {
      // Afficher un message d'état.
      alert("Problème d'obtention des données :\n" + xmlHttp.statusText);
    }
  }
}

// Traiter la réponse reçue du serveur.
function handleServerResponse()
{
  // Lire le message du serveur.
  responseJSON = JSON.parse(xmlHttp.responseText);
  // Générer la sortie HTML.
  var html = "";  
  // Parcourir les tableaux et créer la structure HTML.
  for (var i=0; i<responseJSON.books.length; i++)
    html += responseJSON.books[i].title + 
            ", " + responseJSON.books[i].isbn + "<br/>";
  // Obtenir une référence à l'élément <div> de la page.
  myDiv = document.getElementById("myDivElement");
  // Afficher la sortie HTML.
  myDiv.innerHTML = "<p>Le serveur a répondu : </p>" + html;
}