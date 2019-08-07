<?php
// Charger le module de gestion des erreurs et la classe Grid.
require_once('error_handler.php');
require_once('grid.class.php');

// Fixer l'action par défaut.
$action = 'load';
if(isset($_GET['action']))	
	$action = $_GET['action'];

// Charger la grille.	
if($action == 'load')
{
	$page = $_POST['page']; // Page demandée.
	$limit = $_POST['rows']; // Nombre de lignes dans la grille.
	$sidx = $_POST['sidx']; // Indice de ligne - clic pour un tri.
	$sord = $_POST['sord']; // Direction.
	$grid = new Grid($page,$limit,$sidx,$sord);
	$response->page = $page;
	$response->total = $grid->getTotalPages();
	$response->records = $grid->getTotalItemsCount();
	$currentPageItems = $grid->getCurrentPageItems();

	for($i=0;$i<count($currentPageItems);$i++) {
		$response->rows[$i]['id']=$currentPageItems[$i]['product_id'];
		$response->rows[$i]['cell']=array(
								$currentPageItems[$i]['product_id'],
								$currentPageItems[$i]['name'],
								$currentPageItems[$i]['price'],
								$currentPageItems[$i]['on_promotion']
							);    
	} 
	echo json_encode($response);
}

// Enregistrer la grille.
elseif ($action == 'save')
{
	$product_id = $_POST['id'];
	$name = $_POST['name'];
	$price = $_POST['price'];
	$on_promotion = ($_POST['on_promotion'] =='Yes')?1:0;
	$grid = new Grid();
	echo $grid->updateItem($product_id,$on_promotion,$price,$name);
}
?>
