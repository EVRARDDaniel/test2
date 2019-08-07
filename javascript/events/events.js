function process()
{
  // Créer le contenu HTML.
  var string;
  string = "<ul>"
         + "<li>Noir</li>"
         + "<li>Orange</li>"
         + "<li>Rose</li>"
         + "</ul>";
  // Obtenir une référence à l'élément <div> de la page.
  myDiv = document.getElementById("myDivElement");
  // Ajouter le contenu au <div>.
  myDiv.innerHTML = string;
}
