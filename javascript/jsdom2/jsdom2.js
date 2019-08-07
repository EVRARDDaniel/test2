function process()
{
  // Créer l'élément <p>.
  oP = document.createElement("p");
  // Créer le noeud texte "Salut...".
  oHelloText = document.createTextNode
    ("Salut ! Voici une proposition de couleurs :");
  // Ajouter le noeud texte en tant qu'élément enfant de <p>.
  oP.appendChild(oHelloText);

  // Créer l'élément <ul>.
  oUl = document.createElement("ul")

  // Créer le premier élément <ui> et lui ajouter un noeud texte.
  oLiBlack = document.createElement("li");
  oBlack = document.createTextNode("Noir");
  oLiBlack.appendChild(oBlack);

  // Créer le deuxièlme élément <ui>  et lui ajouter un noeud texte.
  oLiOrange = document.createElement("li");
  oOrange = document.createTextNode("Orange");
  oLiOrange.appendChild(oOrange);

  // Créer le troisième élément <ui>  et lui ajouter un noeud texte.
  oLiPink = document.createElement("li");
  oPink = document.createTextNode("Rose");
  oLiPink.appendChild(oPink);

  // Ajouter les éléments <ui> en tant qu'enfants de l'élément <ul>.
  oUl.appendChild(oLiBlack);
  oUl.appendChild(oLiOrange);
  oUl.appendChild(oLiPink);

  // Obtenir une référence à l'élément <div> de la page.
  myDiv = document.getElementById("myDivElement");

  // Ajouter le contenu à l'élément <div>.
  myDiv.appendChild(oHelloText);
  myDiv.appendChild(oUl);
}
