<?php
$action = $_REQUEST['action'];

switch($action){

	case 'connexion' : {
		
		//Entrée : l'utilisateur est déjà connecté
		if(isset($_SESSION['mail'])){
			unset($_SESSION['mail']);

			if(isset($_SESSION['admin'])){
				unset($_SESSION['admin']);
			}
			
			header("Location: ?uc=accueil");
		} 
		//Entrée : l'utilisateur vient d'envoyer des info de connexion via le formulaire
		else if (isset($_REQUEST['mail']) && isset($_REQUEST['mdp'])) {
			
			$resConnexion = $pdo->connexionUtilisateur($_REQUEST['mail'],$_REQUEST['mdp']);
			
			//Entrée : la fonction connexionUtilisateur n'a pas retournée d'erreur
			if(is_null($resConnexion[0])){
				$_SESSION['mail']=$_REQUEST['mail'];
				
				if(!isset($_SESSION['admin'])){
					//Met à jour le panier en local
					$pdo->getPanierClient($_SESSION['mail']);
					//Met à jour le panier dans la BDD
					$pdo->setPanierClient($_SESSION['mail']);
				}

				$message = "Vous êtes bien connectez !";
				include("vues/v_message.php");
				include("vues/v_accueil.php");
			}
			//Entrée : il y a eu une erreur lors de la connexion
			else {
				$msgErreurs = $resConnexion;
				$mail = $_REQUEST['mail'];
				include ("vues/v_erreurs.php");
				include("vues/v_connexion.php");
			}
			
		//Entrée : l'utilisateur viens d'arriver sur la page de connexion
		} else {
			$mail = '';
			include("vues/v_connexion.php");
		}
		break;
	}

	case 'inscription' : {
		if(isset($_SESSION['mail'])){
			$message = "Vous êtes connectez, pas besoin de vous inscrire.";
   			include ("vues/v_message.php");
   			include("vues/v_accueil.php");
		} else {
			$nom =''; $prenom='';$rue='';$ville ='';$cp='';$mail='';
			include("vues/v_inscription.php");
		}
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
			if($pdo->creerClient($mail,$_REQUEST['mdp'],$nom,$prenom,$rue,$cp,$ville)){
				$_SESSION['mail']=$mail;
				$message = "Vous êtes bien inscris et connectez. A l'avenir votre identifiant sera ".$mail." .";
				include("vues/v_message.php");
				include("vues/v_accueil.php");
			} else {
				$msgErreurs[]='Cette adresse mel est déjà utilisée...';
				include ("vues/v_erreurs.php");
				include ("vues/v_inscription.php");
			}
		}
		break;
	}

}



?>