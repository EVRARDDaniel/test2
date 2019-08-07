// Appliquer le style 1 au tableau.
function setStyle1()
{
  // Obtenir des références aux éléments HTML.
  oTable = document.getElementById("table");
  oTableHead = document.getElementById("tableHead");
  oTableFirstLine = document.getElementById("tableFirstLine");
  oTableSecondLine = document.getElementById("tableSecondLine");
  // Appliquer les styles.
  oTable.className = "Table1";
  oTableHead.className = "TableHead1";
  oTableFirstLine.className = "TableContent1";
  oTableSecondLine.className = "TableContent1";
}

// Appliquer le style 2 au tableau.
function setStyle2()
{
  // Obtenir des références aux élément HTML.
  oTable = document.getElementById("table");
  oTableHead = document.getElementById("tableHead");
  oTableFirstLine = document.getElementById("tableFirstLine");
  oTableSecondLine = document.getElementById("tableSecondLine");
  // Appliquer les styles.
  oTable.className = "Table2";
  oTableHead.className = "TableHead2";
  oTableFirstLine.className = "TableContent2";
  oTableSecondLine.className = "TableContent2";
}
