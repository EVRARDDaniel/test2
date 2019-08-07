$(document).ready( function() {  
  $('#upload').click(function(){
    doUpload();
  });  
  $('#uploadprogress').hide();
});

function doUpload()
{
  // Étape 2 : créer l'objet iframe.
  var iframe;
  try {
    iframe = document.createElement('<iframe name="uploadiframe">');
  } catch (ex) {
    iframe = document.createElement('iframe');
    iframe.name='uploadiframe';
  }    
  iframe.src = 'javascript:false';  
  iframe.id = 'uploadiframe';
  iframe.className ='iframe';
  document.body.appendChild(iframe);
  // Étape 3 : rediriger le formulaire vers l'iframe.
  $('#form').attr('target','uploadiframe');
  // Étape 4 : afficher la progression.
  $('#uploadform').hide();
  $('#uploadprogress').show();
  // Étape 5 : intercepter le résultat de l'envoi.
  $('#uploadiframe').load(function () {    
    $('#uploadprogress').hide();
    $('#uploadform').show();
    // Étape 6 : informer l'utilisateur du résultat.
    var result = $('body', this.contentWindow.document).html();    
    if(result == 1)
      $('#result').html('L\'envoi du fichier s\'est bien déroulé !');    
    else    
      $('#result').html('Erreur pendant l\'envoi du fichier !');
    // Étape 7 : détruire l'iframe.
    setTimeout(function () {
      $('#uploadiframe').remove();
      }, 50);      
  });
}
