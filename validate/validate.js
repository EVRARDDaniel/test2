// Conserver l'adresse su serveur distant.
var serverAddress = "validate.php";
// Fixé à true, les messages d'erreur détaillés sont affichés.
var showErrors = true;

// Fonction de validation d'un champ du formulaire.
function validate(inputValue, fieldID)
{
  // Les données à envoyer au serveur via POST.
  var data = "validationType=ajax&inputValue=" + inputValue + 
             "&fieldID=" + fieldID;
    
  // Construire l'objet settings pour l'objet XmlHttp.
  var settings = 
  {
    url: serverAddress, 
    type: "POST",
    async: true,
    complete: function (xhr, response, status)
    {
      if (xhr.responseText.indexOf("N° d'erreur") >= 0 
          || xhr.responseText.indexOf("error:") >= 0
          || xhr.responseText.length == 0)
      {
        alert(xhr.responseText.length == 0 ? 
          "Erreur du serveur." : response);
      }                   
      result = response.result;
      fieldID = response.fieldid;
      // Chercher l'élément HTML qui affiche l'erreur.
      message = document.getElementById(fieldID + "Failed");
      // Afficher ou masquer l'erreur.
      message.className = (result == "0") ? "error" : "hidden";
    },
    data: data,
    showErrors: showErrors
  };
  
  // Effectuer une requête au serveur pour valider les données saisies.
  var xmlHttp = new XmlHttp(settings);
}

// Placer le focus sur le premier champ du formulaire.
function setFocus()    
{
  document.getElementById("txtUsername").focus();
}
