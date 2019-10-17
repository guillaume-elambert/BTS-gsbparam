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
						$message = "Modifications des informations du produits effectuées avec succès !";
						include("vues/v_message.php");
						if($_REQUEST['dateDeb']!="" && $_REQUEST['dateFin']!="" && $_REQUEST['tauxPromo']!=0){

							switch ($pdo->modifPromo($_REQUEST['produit'],$_REQUEST['dateDeb'],$_REQUEST['dateFin'],$_REQUEST['tauxPromo'])){
								


								case 1 : {
									$msgErreurs[] = "La date de fin de promotion doit être supérieure ou égale à celle de début de promotion";
									include ("vues/v_erreurs.php");
									break;
								}


								case 2 : {
									$msgErreurs[] = "Il existe déjà une promotion sur une partie ou sur la totalité de cette période pour ce produit...";
									include ("vues/v_erreurs.php");
									break;
								}

								case 3 : {
									$message = "Création de la promotion effectuées avec succès !";
									include("vues/v_message.php");
									break;
								}

								case 4 : {
									$message = "Modifications de la promotion effectuées avec succès !";
									include("vues/v_message.php");
									break;
								}


								case 5 : {
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


					//Affichage du la page d'administration
					$lesCategories = $pdo->getLesCategories();
					$lesCategories[] = array("id"=>"ajoutProd","libelle"=>"Ajouter un produit");
					include("vues/v_categories.php");
					

					//Parcours de l'enssemble des catégories
					foreach ($lesCategories as $uneCategorie) {				
						$lesProduits = $pdo->getLesProduitsDeCategorie($uneCategorie['id']);
						$categorie = $uneCategorie['id'];
						include("vues/v_produitsDeCategorie.php");
					}

					break;
				}


				case 'rmProduit' : {

					if($pdo->rmProduit($_REQUEST['produit'])){
						$message = "Supression du produit efféctuée avec succès !";
						include("vues/v_message.php");
					} else {
						$msgErreurs[] = "Erreur lors de la suppression du produit...";
						include("vues/v_erreurs.php");
					}
					
					//Affichage du la page d'administration
					$lesCategories = $pdo->getLesCategories();
					$lesCategories[] = array("id"=>"ajoutProd","libelle"=>"Ajouter un produit");
					include("vues/v_categories.php");
					

					//Parcours de l'enssemble des catégories
					foreach ($lesCategories as $uneCategorie) {				
						$lesProduits = $pdo->getLesProduitsDeCategorie($uneCategorie['id']);
						$categorie = $uneCategorie['id'];
						include("vues/v_produitsDeCategorie.php");
					}

					break;
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
	$msgErreurs[] = "Vous n'êtes pas connectez... Pour cela cliquez <a href=\"?uc=utilisateur&action=connexion\">ici</a>";
	include ("vues/v_erreurs.php");
}

?>