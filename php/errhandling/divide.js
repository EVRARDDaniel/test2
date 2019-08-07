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

// Initier une requête au serveur pour envoyer les valeurs saisies par
// l'utilisateur et fixer la fonction de rappel pour la lecture de la 
// réponse du serveur.
function process()
{
  // Continuer uniquement si l'objet xmlHttp est valide.
  if (xmlHttp)
  {
    // Tenter une connexion au serveur.
    try
    {
      // Obtenir les deux valeurs saisies par l'utilisateur.
      var firstNumber = document.getElementById("firstNumber").value; 
      var secondNumber = document.getElementById("secondNumber").value;

      // Créer la chaîne des paramètres.
      var params = "firstNumber=" + firstNumber + 
                   "&secondNumber=" + secondNumber;

      // Initier la requête HTTP asynchrone.
      xmlHttp.open("GET", "divide.php?" + params, true);
      xmlHttp.onreadystatechange = handleRequestStateChange;
      xmlHttp.send(null);
    }
    //  En cas d'échec, afficher l'erreur.
    catch (e)
    {
      alert("Connexion au serveur impossible :\n" + e.toString());
    }
  }
}

// Fonction qui prend en charge la réponse HTTP.
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
        // Lire la réponse du serveur.
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
  // Obtenir la réponse du serveur sous forme d'un objet DOM XML.
  var xmlResponse = xmlHttp.responseXML;

  // Intercepter les erreurs côté serveur.
  if (!xmlResponse || !xmlResponse.documentElement)
    throw("Structure XML invalide :\n" + xmlHttp.responseText);

  // Intercepter les erreurs côté serveur (version Firefox).
  var rootNodeName = xmlResponse.documentElement.nodeName;
  if (rootNodeName == "parsererror") 
    throw("Structure XML invalide :\n" + xmlHttp.responseText);

  // Obtenir l'élément racine (l'élément document).
  xmlRoot = xmlResponse.documentElement;
  // Vérifier que nous avons réçu le document XML attendu.
  if (rootNodeName != "response" || !xmlRoot.firstChild)
    throw("Structure XML invalide :\n" + xmlHttp.responseText);

  // La valeur à afficher se trouve dans l'élément enfant de l'élément
  // racine <response>.
  responseText = xmlRoot.firstChild.data;

  // Afficher le message à l'utilisateur.
  myDiv = document.getElementById("myDivElement");
  myDiv.innerHTML = "Le serveur prétend que la réponse est : " + responseText;
}
