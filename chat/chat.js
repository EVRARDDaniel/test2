/* chatURL - URL de mise à jour des messages. */
var chatURL = "chat.php";
/* colorURL - URL d'obtention de la couleur RVB choisie. */
var colorURL = "color.php";

/* Variables qui définissent la fréquence des accès au serveur. */
// Nombre de millisecondes à attendre avant de récupoérer les nouveaux messages.
var updateInterval = 2000; 
// Fixée à true, les messages d'erreur détaillés sont affichés.
var debugMode = true;
/* lastMessageID - id du message le plus récent. */
var lastMessageID = -1;

// Fonction d'affichage d'un message d'erreur.
function displayError(message) 
{
    // Afficher un message d'erreur, avec des détails techniques
	// lorsque debugMode vaut true.
    alert("Erreur d'accès au serveur ! " +
                 (debugMode ? message : ""));
}

// Fonction d'affichage d'un message d'erreur PHP.
function displayPHPError(error)
{
  displayError ("Numéro d'erreur :" + error.errno + "\r\n" +
              "Message :"+ error.text + "\r\n" +
              "Emplacement :" + error.location + "\r\n" +
              "Ligne :" + error.line + + "\r\n");
}

function retrieveNewMessages() 
{
    $.ajax({
        url: chatURL,
        type: 'POST',
        data: $.param({
            mode: 'RetrieveNew',
            id: lastMessageID
        }),
        dataType: 'json',
        error: function(xhr, textStatus, errorThrown) {
            displayError(textStatus);
        },
        success: function(data, textStatus) {
            if(data.errno != null)
              displayPHPError(data);
            else
              readMessages(data);
            // Redémarrer la séquence.
            setTimeout("retrieveNewMessages();", updateInterval);
        }
    });
}

function sendMessage() 
{
    var message = $.trim($('#messageBox').val());
    var color = $.trim($('#color').val());
    var username = $.trim($('#userName').val());

    // Si nous devons envoyer et obtenir de smessages.
    if (message != '' && color != '' & username != '') {
        var params = {
            mode: 'SendAndRetrieveNew',
            id: lastMessageID,
            color: color,
            name: username,
            message: message
        };
        $.ajax({
            url: 'chat.php',
            type: 'POST',
            data: $.param(params),
            dataType: 'json',
            error: function(xhr, textStatus, errorThrown) {
                displayError(textStatus);
            },
            success: function(data, textStatus) {
                if(data.errno != null)
                  displayPHPError(data);
                else
                  readMessages(data);
                // Redémarrer la séquence.
                setTimeout("retrieveNewMessages();", updateInterval);
            }
        });

    }
}

function deleteMessages() 
{
    $.ajax({
        url: chatURL,
        type: 'POST',
        success: function(data, textStatus) {
            if(data.errno != null)
              displayPHPError(data);
            else
              readMessages(data);
            // Redémarrer la séquence.
            setTimeout("retrieveNewMessages();", updateInterval);
        },
        data: $.param({
            mode: 'DeleteAndRetrieveNew'
        }),
        dataType: 'json',
        error: function(xhr, textStatus, errorThrown) {
            displayError(textStatus);
        }
    });
}

function readMessages(data, textStatus) 
{
    // Obtenir le fanion qui indique si la fenêtre des messages doit 
	// être effacée ou non.
    clearChat = data.clear;
    // Si le fanion est à true, effacer la fenêtre des messages.
    if (clearChat == 'true') {
        // Effacer la fenêtre et réinitialiser id.
        $('#scroll')[0].innerHTML = "";
        lastMessageID = -1;
    }
    
    if (data.messages.length > 0)
    {
      // Vérifier si le premier message a déjà été reçu et, dans
	  // l'affirmative, ignorer les messages suivants.
      if(lastMessageID > data.messages[0].id)
        return;
      // L'id du dernier message reçu est mémorisé localement.
      lastMessageID = data.messages[data.messages.length - 1].id;
    }
    // Afficher les messages obtenus à partir du serveur.
    $.each(data.messages, function(i, message) {
        // Construire le code HTML qui affiche le message.
        var htmlMessage = "";
        htmlMessage += "<div class=\"item\" style=\"color:" + message.color + "\">";
        htmlMessage += "[" + message.time + "] " + message.name + " a dit : <br/>";
        htmlMessage += message.message;
        htmlMessage += "</div>";

        // Vérifier le défilement vers le bas.
        var isScrolledDown = ($('#scroll')[0].scrollHeight - $('#scroll')[0].scrollTop <=
                    $('#scroll')[0].offsetHeight);

        // Afficher le message.
        $('#scroll')[0].innerHTML += htmlMessage;

        // Déplacer la barre de défilement vers le bas.
        $('#scroll')[0].scrollTop = isScrolledDown ? $('#scroll')[0].scrollHeight : $('#scroll')[0].scrollTop;
    });
    
}

$(document).ready(function() 
{
    // Se lier à l'événement blur.
    $('#userName').blur(
    // Fonction qui vérifie que le nom d'utilisateur n'est pas vide et, 
	// dans le cas contraire, génère un nom aléatoire.
      function(e) {
          // S'assurer que l'utilisateur a un nom aléatoire par défaut au 
		  // chargement du formulaire. 
          if (this.value == "")
              this.value = "Guest" + Math.floor(Math.random() * 1000);
      }
    );
    // Remplir le champ de nom avec la valeur par défaut.
    $('#userName').triggerHandler('blur');

    // Gérer l'événement click sur l'image.
    $('#palette').click(
      function(e) {
          // http://docs.jquery.com/Tutorials:Mouse_Position        
          // Obtenir la position relative de la souris sur l'image.
          var x = e.pageX - $('#palette').position().left;
          var y = e.pageY - $('#palette').position().top;

          // Effectuer l'appel AJAX au code RVB.
          $.ajax({
              url: colorURL,
              success: function(data, textStatus) {
                  if(data.errno != null)
                    displayPHPError(data);
                  else
                  {
                    $('#color')[0].value = data.color;
                    $('#sampleText').css('color', data.color);
                  }
              },
              data: $.param({
                  offsetx: x,
                  offsety: y
              }),
              dataType: 'json',
              error: function(xhr, textStatus, errorThrown) {
                  displayError(textStatus);
              }
          }
        );
      }
    );

    // Fixer la couleur par défaut à noir.
    $('#sampleText').css('color', 'black');

    $('#send').click(
      function(e) {
          sendMessage();
      }
    );

    $('#delete').click(
      function(e) {
          deleteMessages();
      }
    );

    // Désactiver la complétion automatique.
    $('#messageBox').attr('autocomplete', 'off');

    // Gérer les appuis sur la touche Entrée.
    $('#messageBox').keydown(
      function(e) {
          if (e.keyCode == 13) {
              sendMessage();
          }
      }
    );

    retrieveNewMessages();
});
