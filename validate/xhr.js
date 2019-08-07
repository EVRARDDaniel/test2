// Le constructeur de XmlHttp reçoit les paramètres de la requête :
// url - l'URL du serveur
// contentType - le type de contenu de la requête
// type - le type de requête (par défaut GET)
// data - des paramètres de requêtes optionnels
// async - indicateur de requête asynchrone (par défaut true)
// showErrors - affichage des erreurs
// complete - la fonction de rappel invoquée lorsque la requête est terminée
function XmlHttp(settings)
{  
  // Enregistrer l'objet settings dans une propriété de classe.
  this.settings = settings;
  
  // Écraser les paramètres par défaut à partir de ceux reçus en
  // argument. L'URL par défaut pointe sur la page courante.
  var url = location.href;  
  if (settings.url) 
    url = settings.url;

  // Le type de contenu par défaut est celui réservé aux formulaires.
  var contentType = "application/x-www-form-urlencoded";
  if (settings.contentType) 
    contentType = settings.contentType;
  
  // La requête se fait par défaut avec GET.
  var type = "GET";
  if(settings.type)
    type = settings.type;
  
  // Par défaut, aucun paramètre à envoyer.
  var data = null;
  if(settings.data)
  {
    data = settings.data;
    // Si nous passons par GET, ajuster l'URL.
    if(type == "GET")
      url = url + "?" + data;
  }
  
  // Le rappel est par défaut asynchrone.
  var async = true;
  if(settings.async)
    async = settings.async;
  
  // Par défaut, les erreurs sont affichées.
  var showErrors = true;
  if(settings.showErrors)
    showErrors = settings.showErrors;
  
  // Créer l'objet XmlHttpRequest.
  var xhr = XmlHttp.create();
  
  // Définir les propriétés de renvoi.
  xhr.open(type, url, async);  
  xhr.onreadystatechange = onreadystatechange;
  xhr.setRequestHeader("Content-Type", contentType);
  xhr.send(data);

  // Fonction d'afffichage des erreurs.
  function displayError(message)
  {
    // Ignorer les erreurs si showErrors vaut false.
    if (showErrors)
    {      
      // Afficher un message d'erreur.
      alert("Une erreur s'est produite : \n" + message);      
    }
  }

  // Fonction de lecture de la réponse du serveur.
  function readResponse()
  {
    try 
    {    
      // Obtenir le type de contenu de la réponse.
      var contentType = xhr.getResponseHeader("Content-Type");
      // Construire l'objet JSON si la réponse est de ce type.
      if (contentType == "application/json") 
      {
        response = JSON.parse(xhr.responseText);
      }
      // Obtenir l'élement du DOM si la réponse est de type XML.
      else if (contentType == "text/xml") 
      {
        response = xhr.responseXml;
      }
      // Par défaut, la réponse contient du texte.
      else 
      {
        response = xhr.responseText;
      }  
      // Invoquer la fonction de rappel éventuellement définie.
      if (settings.complete)
        settings.complete (xhr, response, xhr.status);
    }
    catch (e) 
    {
      displayError(e.toString());
    }
  }

  // Fonction appelée lorsque l'état de la réponse HTTP change.
  function onreadystatechange()
  {
    // Lorsque readyState vaut 4, lire la réponse du serveur.
    if (xhr.readyState == 4) 
    {
      // Continuer uniquement si l'état HTTP est "OK".
      if (xhr.status == 200) 
      {
        try
        {
          // Lire la réponse du serveur.
          readResponse();
        }
        catch(e)    
        {
          // Afficher un message d'erreur.
          displayError(e.toString());
        }
      }
      else
      {
        // Afficher un message d'erreur.
        displayError(xhr.statusText);
      }  
    }
  }
}

// Méthode statique qui retourne un nouvel objet XMLHttpRequest.
XmlHttp.create = function()
{
  // Conserver une référence à l’objet XMLHttpRequest.
  var xmlHttp;
  // Créer l’objet XMLHttpRequest.
  try
  {
    // Supposer IE7, ou plus récent, ou un autre navigateur moderne.
    xmlHttp = new XMLHttpRequest();
  }
  catch(e)
  {
    // Supposer IE6, ou plus ancien.
    try
    {
      xmlHttp = new ActiveXObject("Microsoft.XMLHttp");
    }
    catch(e) { }
  }
  // Retourner l’objet créé ou afficher un message d’erreur.
  if (!xmlHttp)
    alert("Erreur de création de l'objet XMLHttpRequest.");
  else 
    return xmlHttp;
}