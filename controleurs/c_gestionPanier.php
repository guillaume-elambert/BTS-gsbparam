<?php
if(isset($_SESSION['admin'])){
	header('Location: ./');
} else {
	$action = $_REQUEST['action'];
	switch($action)
	{


		case 'voirPanier':
		{
			$n= nbProduitsDuPanier();
			if($n >0)
			{
				$desIdProduit = getLesIdProduitsDuPanier();
				$lesProduitsDuPanier = $pdo->getLesProduitsDuTableau($desIdProduit);
				include("vues/v_panier.php");
			}
			else
			{
				$message = "panier vide !!";
				include ("vues/v_message.php");
			}
			break;
		}



		case 'supprimerUnProduit':
		{
			$idProduit=$_REQUEST['produit'];

			if(isset($_SESSION['mail'])){
				$pdo->retirerDuPanier($idProduit);
			}

			retirerDuPanier($idProduit);

			//S'il y au moins un produit dans le panier on affiche le panier avec les produits
			if((sizeof($_SESSION['produits'])-1) > 0){
				$desIdProduit = getLesIdProduitsDuPanier();
				$lesProduitsDuPanier = $pdo->getLesProduitsDuTableau($desIdProduit);
				include("vues/v_panier.php");
			}
			//Sinon on redirige vers le panier sans séléctionner les produits car inexistants
			else {
				header('Location: ?uc=gererPanier&action=voirPanier');
			}
			break;
		}




		case 'viderPanier' : {
			supprimerPanier();

			if(isset($_SESSION['mail'])){
				$pdo->viderPanier();
			}

			initPanier();
			$message = "Panier vidé";
			include ("vues/v_message.php");

			break;
		}



		case 'passerCommande' :
		    $n= nbProduitsDuPanier();
			if($n>0)
			{   // les variables suivantes servent à l'affectation des attributs value du formulaire
				// ici le formulaire doit être vide, quand il est erroné, le formulaire sera réaffiché pré-rempli
				if(isset($_SESSION['mail'])){
					$userInfo = $pdo->getInfoClient($_SESSION['mail']);

					if( $userInfo !=0 ){
						$nom 	= $userInfo['nom'];
						$prenom	= $userInfo['prenom'];
						$rue 	= $userInfo['rue'];
						$ville 	= $userInfo['ville'];
						$cp		= $userInfo['cp'];
						$mail = $userInfo['mail'];
					} else {
						$nom =''; $prenom='';$rue='';$ville ='';$cp='';$mail='';
					}

				} else {
					$nom =''; $prenom='';$rue='';$ville ='';$cp='';$mail='';
				}
				
				include ("vues/v_commande.php");
			}
			else
			{
				$message = "panier vide !!";
				include ("vues/v_message.php");
			}
			break;



		case 'confirmerCommande' :
		{
			$nom =$_REQUEST['nom']; $prenom=$_REQUEST['prenom']; $rue=$_REQUEST['rue'];$ville =$_REQUEST['ville'];$cp=$_REQUEST['cp'];$mail=$_REQUEST['mail'];
		 	$msgErreurs = getErreursSaisieCommande($nom,$prenom,$rue,$ville,$cp,$mail);
			if (count($msgErreurs)!=0)
			{
				include ("vues/v_erreurs.php");
				include ("vues/v_commande.php");
			}
			else
			{
				$lesIdProduit = getLesIdProduitsDuPanier();
				$qteProduit = getLesQteProduitsDuPanier();
				$pdo->creerCommande($nom, $prenom, $rue,$cp,$ville,$mail, $lesIdProduit, $qteProduit );
				$message = "Commande enregistrée";
				supprimerPanier();
				include ("vues/v_message.php");
			}
			break;
		}
	}
}

?>