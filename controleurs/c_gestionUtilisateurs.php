<?php
$action = $_REQUEST['action'];

switch($action){

	case 'connexion' : {
		
		//Entrée : l'utilisateur est déjà connecté
		if(isset($_SESSION['mail'])){
			unset($_SESSION['mail']);
			header("Location: ?uc=accueil");

		} 
		//Entrée : l'utilisateur vient d'envoyer des info de connexion via le formulaire
		else if (isset($_REQUEST['mail']) && isset($_REQUEST['mdp'])) {
			
			$resConnexion = $pdo->connexionUtilisateur($_REQUEST['mail'],$_REQUEST['mdp']);

			//Entrée : la fonction connexionUtilisateur n'a pas retournée d'erreur
			if($resConnexion == 1){
				$_SESSION['mail']=$mail;
			} else {
				$mail = $_REQUEST['mail'];
				include ("vues/v_erreurs.php");
				include("vues/v_connexion");
			}
			

		} else {
			$mail = '';
			include("vues/v_connexion.php");
		}
		break;
	}

	case 'inscription' : {
		$nom =''; $prenom='';$rue='';$ville ='';$cp='';$mail='';
		include("vues/v_inscription.php");
		break;
	}

	case 'confirmerInscription' : {
		$nom =$_REQUEST['nom']; $prenom=$_REQUEST['prenom']; $rue=$_REQUEST['rue'];$ville =$_REQUEST['ville'];$cp=$_REQUEST['cp'];$mail=$_REQUEST['mail'];
	 	$msgErreurs = getErreursSaisieCommande($nom,$prenom,$rue,$ville,$cp,$mail);
		if (count($msgErreurs)!=0)
		{
			include ("vues/v_erreurs.php");
			include ("vues/v_inscription.php");
		}
		else
		{
			$pdo->creerClient($mail,$_REQUEST['mdp'],$nom,$prenom,$rue,$cp,$ville);
			$_SESSION['mail']=$mail;
			header('Location: ?uc=gererPanier&action=passerCommande');
		}
		break;
	}

}



?>