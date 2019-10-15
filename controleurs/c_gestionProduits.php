<?php
if(isset($_SESSION['mail'])){
	if(isset($_SESSION['admin'])){

		if ( isset( $_REQUEST['action']) ) {
			$action = $_REQUEST['action'];

			switch($action) {

				case 'voirProduits' : {
					$lesCategories = $pdo->getLesCategories();
					$lesCategories[] = array("id"=>"ajoutProd","libelle"=>"Ajouter un produit");
					include("vues/v_categories.php");
			  		$categorie = $_REQUEST['categorie'];
					$lesProduits = $pdo->getLesProduitsDeCategorie($categorie);
					include("vues/v_produitsDeCategorie.php");
					break;
				}


				case 'modifierInfos' : {
					$laCategorie = $_REQUEST['categorie'];
					$leProduit = $_REQUEST['produit'];
					$unProduit = $pdo->getUnProduit($leProduit);
					$promotion = $pdo->getPromotion($leProduit);
					$lesCategories = $pdo->getLesCategories();
					include("vues/v_modifProduit.php");
					break;
				}


				case 'confirmerModif' : {
					if($pdo->modifProduit($_REQUEST['produit'],$_REQUEST['description'],$_REQUEST['prix'],$_REQUEST['categorie'])){
						
						if($_REQUEST['dateDeb']!="" && $_REQUEST['dateFin']!="" && $_REQUEST['tauxPromo']!=0){

							switch ($pdo->modifPromo($_REQUEST['produit'],$_REQUEST['dateDeb'],$_REQUEST['dateFin'],$_REQUEST['tauxPromo'])){
								

								case 1 : {
									$msgErreurs[] = "Il existe déjà une promotion sur cette période pour ce produit...";
									include ("vues/v_erreurs.php");
									break;
								}

								case 2 : {
									$message = "Création de la promotion effectuées avec succès !";
									include("vues/v_message.php");
									break;
								}

								case 3 : {
									$message = "Modifications de la promotion effectuées avec succès !";
									include("vues/v_message.php");
									break;
								}


								case 4 : {
									$msgErreurs[] = "Erreurs lors de la création ou la modification de la promotion...";
									include ("vues/v_erreurs.php");
									break;
								}
							}

						} else {
							$message = "Modifications des informations du produit effectuées avec succès !";
							include("vues/v_message.php");
						}

					} else {
						$msgErreurs[] = "Erreurs lors de la modification des données...";
						include ("vues/v_erreurs.php");
					}
				}

			}

		} else {
			$lesCategories = $pdo->getLesCategories();
			$lesCategories[] = array("id"=>"ajoutProd","libelle"=>"Ajouter un produit");
			include("vues/v_categories.php");
			

			//Parcours de l'enssemble des catégories
			foreach ($lesCategories as $uneCategorie) {				
				$lesProduits = $pdo->getLesProduitsDeCategorie($uneCategorie['id']);
				$categorie = $uneCategorie['id'];
				include("vues/v_produitsDeCategorie.php");
			}
		}

	} else {
		$msgErreurs[] = "Vous n'avez pas les droits d'aller sur cette page !";
		include ("vues/v_erreurs.php");
	}

} else {
	$msgErreurs[] = "Vous n'êtes pas connectez !";
	include ("vues/v_erreurs.php");
}

?>