<?php
// Charger le fichier de configuration.
require_once('config.php');
// Démarrer une session.
session_start();

// Classe pour la manipulation de la liste des produits.
class Grid 
{      
  // Nombre de pages dans la grille.
  private $mTotalPages;
  // Nombre d'articles dans la grille.
  private $mTotalItemsCount;
  private $mItemsPerPage;
  private $mCurrentPage;
  
  private $mSortColumn;
  private $mSortDirection;
  // Gestionnaire de base de données.
  private $mMysqli;
    
  // Constructeur de la classe.
  function __construct( $currentPage =1, $itemsPerPage=5, $sortColumn='product_id', $sortDirection='asc') 
  {   
    // Créer la connexionthe MySQL.
    $this->mMysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD,
                                DB_DATABASE);
    $this->mCurrentPage = $currentPage;
	$this->mItemsPerPage = $itemsPerPage;
	$this->mSortColumn = $sortColumn;
	$this->mSortDirection = $sortDirection;
	// Appeler countAllRecords  pour obtenir le nombre d'enregistrements.
    $this->mTotalItemsCount = $this->countAllItems();
	if($this->mTotalItemsCount >0)	
		$this->mTotalPages = ceil($this->mTotalItemsCount/$this->mItemsPerPage);
	else
		$this->mTotalPages=0;	
	if($this->mCurrentPage > $this->mTotalPages)
		$this->mCurrentPage = $this->mTotalPages;
  }
  
  // Lire une page de produits et l'enregistrer dans $this->grid.
  public function getCurrentPageItems()
  {
    // Créer la requête SQL qui retourne une page de produits.
    $queryString = 'SELECT * FROM product';	
	$queryString .= ' ORDER BY '.$this->mMysqli->real_escape_string($this->mSortColumn).' '
				.$this->mMysqli->real_escape_string($this->mSortDirection);		
	$start = $this->mItemsPerPage* $this->mCurrentPage - $this->mItemsPerPage; // Ne pas mettre $limit*($page - 1).
    if ($start<0) 
		$start = 0;
	$queryString .= ' LIMIT '.$start.','.$this->mItemsPerPage;
	
    // Exécuter la requête.
    if ($result = $this->mMysqli->query($queryString)) 
    {
	  for($i = 0; $items[$i] = $result->fetch_assoc(); $i++) ;   

	  // Supprimer le dernier article vide.
	  array_pop($items);
	  
      // Fermer le flux des résultats.
      $result->close();
	  return $items;
    }       
  }
  
  public function getTotalPages()
  {
	return $this->mTotalPages;
  }
    
  // Mettre à jour un produit.
  public function updateItem($id, $on_promotion, $price, $name)
  {
    // Échapper les données pour les ajouter de manière sécurisée 
	// dans les instructions SQL.
    $id = $this->mMysqli->real_escape_string($id);
    $on_promotion = $this->mMysqli->real_escape_string($on_promotion);
    $price = $this->mMysqli->real_escape_string($price);
    $name = $this->mMysqli->real_escape_string($name);
    // Construire la requête SQL qui actualise l'enregistrement d'un produit.
    $queryString =  'UPDATE product SET name="' . $name . '", ' . 
                    'price=' . $price . ',' . 
                    'on_promotion=' . $on_promotion . 
                    ' WHERE product_id=' . $id;        
	
    // Exécuter la requête.
    $this->mMysqli->query($queryString);  
	return $this->mMysqli->affected_rows;
  }

  // Retourner le nombre total d'enregistrements pour la grille.
  private function countAllItems()
  {
      // Requête qui retourne le nombre d'enregistrements.
      $count_query = 'SELECT COUNT(*) FROM product';
      // Exécuter la requête et lire le résultat.
      if ($result = $this->mMysqli->query($count_query)) 
      {
        // Obtenir la première ligne retournée.
        $row = $result->fetch_row(); 		
        // Fermer la connexion à la base de données.
        $result->close();
		return $row[0];
      }    
	return 0;
  }         
  
  public function getTotalItemsCount()
  {
	return $this->mTotalItemsCount;
  }
} 
?>
