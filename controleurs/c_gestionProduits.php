<?php
if(isset($_SESSION['mail'])){
	if(isset($_SESSION['admin'])){

		if ( isset( $_REQUEST['action']) ) {
			$action = $_REQUEST['action'];

			switch($action) {

				case 'voirProduits' : {
					$lesCategories = $pdo->getLesCategories();
					$lesCategories[] = array("id"=>"ajoutProd","libelle"=>"Ajouter un produit");
					$lesCategories[] = array("id"=>"ajoutAdmin","libelle"=>"Ajouter un administrateur");
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
					if($pdo->modifProduit($_REQUEST['produit'],addslashes($_REQUEST['description']),$_REQUEST['prix'],$_REQUEST['categorie'])){
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
							
						}

					} else {
						$msgErreurs[] = "Erreurs lors de la modification des données du produit...";
						include ("vues/v_erreurs.php");
					}


						//Affichage du la page d'administration
						$lesCategories = $pdo->getLesCategories();
						$lesCategories[] = array("id"=>"ajoutProd","libelle"=>"Ajouter un produit");
						$lesCategories[] = array("id"=>"ajoutAdmin","libelle"=>"Ajouter un administrateur");
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
					$imageProduit = $pdo->getUnProduit($_REQUEST['produit'])['image'];

					if($pdo->rmProduit($_REQUEST['produit'])){
						
						$message = "Supression du produit dans la BDD efféctuée avec succès !";
						include("vues/v_message.php");
						
						if($imageProduit !== ""){
							if(file_exists($imageProduit)){
								if(unlink($imageProduit)){
									$msgErreurs[] = "Echec de suppression de l'image du produit...";
									include("vues/v_rreurs.php");
								} else {
									$message = "Supression de l'image efféctuée avec succès !";
									include("vues/v_message.php");
								}
							} else {
								$msgErreurs[] = "L'image du produit n'existe pas/plus...";
								include("vues/v_erreurs.php");
							}
						} else {
							$msgErreurs[] = "Le produit n'a pas d'image...";
							include("vues/v_erreurs.php");
						}

					} else {
						$msgErreurs[] = "Erreur lors de la suppression du produit dans la BDD...";
						include("vues/v_erreurs.php");
					}

					//Affichage du la page d'administration
					$lesCategories = $pdo->getLesCategories();
					$lesCategories[] = array("id"=>"ajoutProd","libelle"=>"Ajouter un produit");
					$lesCategories[] = array("id"=>"ajoutAdmin","libelle"=>"Ajouter un administrateur");
					include("vues/v_categories.php");
					

					//Parcours de l'enssemble des catégories
					foreach ($lesCategories as $uneCategorie) {				
						$lesProduits = $pdo->getLesProduitsDeCategorie($uneCategorie['id']);
						$categorie = $uneCategorie['id'];
						include("vues/v_produitsDeCategorie.php");
					}

					break;
				}


				case 'ajoutProduit' : {
					$id="";
					$description="";
					$prix=0;
					$lesCategories = $pdo->getLesCategories();
					
					if(isset($_REQUEST['categorie'])){
						$categorie = $_REQUEST['categorie'];
					} else {
						$categorie = $lesCategories[0]['id'];
					}

					include("vues/v_ajoutProduit.php");
					break;
				}

				case 'confirmerAjoutProduit' : {

					if(isset($_REQUEST["valider"])){
						$id=$_REQUEST['id'];
						$description=addslashes($_REQUEST['description']);
						$prix=$_REQUEST['prix'];
						$categorie=$_REQUEST['categorie'];
						$image="images/".addslashes($_FILES['image']['name']);

						if(creerImage()){
							if($pdo->creerProduit($id,$description,$prix,$categorie,$image)){
								$message = "Ajout du produit dans la base de donnée effectué avec succès !";
								include("vues/v_message.php");

								$lesCategories = $pdo->getLesCategories();
								$lesCategories[] = array("id"=>"ajoutProd","libelle"=>"Ajouter un produit");
								$lesCategories[] = array("id"=>"ajoutAdmin","libelle"=>"Ajouter un administrateur");
								
								include("vues/v_categories.php");
								

								//Parcours de l'enssemble des catégories
								foreach ($lesCategories as $uneCategorie) {				
									$lesProduits = $pdo->getLesProduitsDeCategorie($uneCategorie['id']);
									$categorie = $uneCategorie['id'];
									include("vues/v_produitsDeCategorie.php");
								}


							} else {
								$lesCategories = $pdo->getLesCategories();
								$msgErreurs[] = "Une erreur s'est produite lors de l'insertion du produit dans la base de données...";
								include("vues/v_erreurs.php");
								include("vues/v_ajoutProduit.php");
							}
						} else {
							$lesCategories = $pdo->getLesCategories();
							$msgErreurs[] = "Veuillez séléctionner un fichier valide !";
							include("vues/v_erreurs.php");
							include("vues/v_ajoutProduit.php");
						}
					}

					break;
				}

				case 'ajoutAdmin' : {
					$nom ='';
					include("vues/v_inscriptionAdmin.php");
					break;
				}

				case 'confirmerInscriptionAdmin' : {
					if( isset($_REQUEST['nom']) ) {
						$nom = $_REQUEST['nom'];
						$nom = addslashes($nom);
						
						if($pdo->getInfoClient($nom)==false && $pdo->getInfoAdmin($nom)==false){
							
							if($pdo->creerAdmin($nom,$_REQUEST['mdp'])){
								$message = "L'administrateur a été créé avec l'identifiant : ".$_REQUEST['nom']." et le mot de passe : ".$_REQUEST['mdp']." !";
								include("vues/v_message.php");
								include("vues/v_accueil.php");
							}
						} else {
							$msgErreurs[]='Ce login est déjà utilisé...';
							include ("vues/v_erreurs.php");
							include ("vues/v_inscriptionAdmin.php");
						}

					} else {
						$msgErreurs[]='Veuillez saisir un identifiant...';
						include ("vues/v_erreurs.php");
						include ("vues/v_inscription.php");
					} 

					
					break;
				}

				default : {
					header('Location:?uc=administrer');
					break;
				}
			}

		} else {
			$lesCategories = $pdo->getLesCategories();
			$lesCategories[] = array("id"=>"ajoutProd","libelle"=>"Ajouter un produit");
			$lesCategories[] = array("id"=>"ajoutAdmin","libelle"=>"Ajouter un administrateur");

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