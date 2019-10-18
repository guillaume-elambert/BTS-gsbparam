<?php
if(isset($_SESSION['admin'])){
	header('Location: ./');
} else {
	// contrôleur qui gère l'affichage des produits
	initPanier(); // se charge de réserver un emplacement mémoire pour le panier si pas encore fait
	$action = $_REQUEST['action'];
	switch($action)
	{
		case 'voirCategories':
		{
	  		$lesCategories = $pdo->getLesCategories();
			include("vues/v_choixCategorie.php");
	  		break;
		}

		case 'voirProduits' :
		{
			$lesCategories = $pdo->getLesCategories();
			include("vues/v_categories.php");
	  		$categorie = $_REQUEST['categorie'];
			$lesProduits = $pdo->getLesProduitsDeCategorie($categorie);
			include("vues/v_produitsDeCategorie.php");
			break;
		}

		case 'nosProduits' :
		{
			$lesCategories = $pdo->getLesCategories();
			include("vues/v_categories.php");

			//Parcours de l'enssemble des catégories
			foreach ($lesCategories as $uneCategorie) {
				$lesProduits = $pdo->getLesProduitsDeCategorie($uneCategorie['id']);
				$categorie = $uneCategorie['id'];
				include("vues/v_produitsDeCategorie.php");

			}
			
			break;
		}

		case 'ajouterAuPanier' :
		{
			$idProduit=$_REQUEST['produit'];

			if(isset($_SESSION['mail'])){
				$pdo->ajouterAuPanier($idProduit);
			}
			
			$ok = ajouterAuPanier($idProduit);
			
			if(!$ok)
			{
				$message = "Cet article est déjà dans le panier !!";
				include("vues/v_message.php");
			}
			else{
			// on recharge la même page ( NosProduits si pas categorie passée dans l'url')
			if (isset($_REQUEST['categorie'])){
				$categorie = $_REQUEST['categorie'];

				//Si ancienne action = "nosProduit" redirection vers cette page
				if( isset($_REQUEST['pAct']) && $_REQUEST['pAct'] == 'nosProduits'){
					header('Location:index.php?uc=voirProduits&action='.$_REQUEST['pAct']);
				}
				//Sinon redirection vers produit par catégorie
				else {
				 	header('Location:index.php?uc=voirProduits&action='.$_REQUEST['pAct'].'&categorie='.$categorie);
				}
			}
			else 
				header('Location:index.php?uc=voirProduits&action=nosProduits');
			}
			break;
		}


		default : {
			header('Location:?uc=voirProduits&action=nosProduits');
			break;
		}
	}
}
?>

