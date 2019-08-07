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

// Effectuer une requête serveur et affecter une fonction de rappel.
function process()
{
  // Continuer uniquement si l'objet xmlHttp est valide.
  if (xmlHttp)
  {
    // Tenter une connexion au serveur.
    try
    {
      // Initier la lecture du fichier async.txt depuis le serveur.
      xmlHttp.open("GET", "async.txt", true);
      xmlHttp.onreadystatechange = handleRequestStateChange;
      xmlHttp.send(null);
      // Changer le pointeur en icône "occupé".
      document.body.style.cursor = "wait";
    }
    // En cas d'échec, afficher l'erreur.
    catch (e)
    {
      alert("Connexion au serveur impossible :\n" + e.toString());
      // Remettre le pointeur normal.
       document.body.style.cursor = "default";
    }
  }
}

// Fonction de traitement de la réponse HTTP.
function handleRequestStateChange() 
{
  // Obtenir une référence à l'élément <div> de la page.
  myDiv = document.getElementById("myDivElement"); 
  // Afficher l'état de la requête. 
  if (xmlHttp.readyState == 1)
  {
    myDiv.innerHTML += "État de la requête : 1 (en cours de chargement) <br/>";
  }
  else if (xmlHttp.readyState == 2)
  {
    myDiv.innerHTML += "État de la requête : 2 (chargée) <br/>";
  }
  else if (xmlHttp.readyState == 3)
  {
    myDiv.innerHTML += "État de la requête : 3 (interactive) <br/>";
  }
  // Lorsque readyState vaut 4, lire également la réponse du serveur.
  else if (xmlHttp.readyState == 4) 
  {
    // Remettre le pointeur normal.
    document.body.style.cursor = "default";
    // Lire la réponse si l'état HTTP est "OK".
    if (xmlHttp.status == 200) 
    {
      try
      {
        // Lire le message du serveur.
        response = xmlHttp.responseText;
        // Afficher le message.
        myDiv.innerHTML += 
            "État de la requête : 4 (terminé). Le serveur a répondu : <br/>";
        myDiv.innerHTML += response;
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
      // Remettre le pointeur normal.
      document.body.style.cursor = "default"; 
    }
  }
}
