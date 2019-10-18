<?php

/** 
* fichier class.PdoGsbParam.inc.php
* contient la classe PdoGsbParam qui fournit 
* un objet pdo et des méthodes pour récupérer des données d'une BD
 */

 /** 
 * PdoGsbParam
 *
 * classe PdoGsbParam : classe d'accès aux données. 
 * Utilise les services de la classe PDO
 * pour l'application GsbParam
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 *
* @package  GsbParam\util
* @version 2019_v2
* @author M. Jouin 
*/

class PdoGsbParam {

	/**
	* type et nom du serveur de bdd
	* @var string $serveur
	*/
  	private static $serveur='mysql:host=localhost';
	/**
	* nom de la BD 
	* @var string $bdd
	*/
  	private static $bdd='dbname=elambert_gsbparam';
	/**
	* nom de l'utilisateur utilisé pour la connexion 
	* @var string $user
	*/   		
  	private static $user='visiteurSite';   
	/**
	* mdp de l'utilisateur utilisé pour la connexion 
	* @var string $mdp
	*/  		
  	private static $mdp='a5UTXhjsMreUpAJU';
	/**
	* objet pdo de la classe Pdo pour la connexion 
	* @var string $monPdo
	*/ 		
	private static $monPdo=null;
	
	private static $monPdoGsbParam = null;
	

	/**
	 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
	 * pour toutes les méthodes de la classe
	 */				
	private function __construct()
	{
		PdoGsbParam::$monPdo = new PDO(PdoGsbParam::$serveur.';'.PdoGsbParam::$bdd, PdoGsbParam::$user, PdoGsbParam::$mdp); 
		PdoGsbParam::$monPdo->query('SET CHARACTER SET utf8');
	}


	/**
    * destructeur
    */
	public function _destruct(){
		PdoGsbParam::$monPdo = null;
	}


	/**
	 * Fonction statique qui crée l'unique instance de la classe
	 *
	 * Appel : $instancePdoGsbParam = PdoGsbParam::getPdoGsbParam();
	 * @return PdoGsbParam $monPdoGsbParam l'unique objet de la classe PdoGsbParam
	 */
	public static function getPdoGsbParam()
	{
		if(PdoGsbParam::$monPdoGsbParam == null)
		{
			PdoGsbParam::$monPdoGsbParam= new PdoGsbParam();
		}
		return PdoGsbParam::$monPdoGsbParam;  
	}


	/**
	 * Retourne toutes les catégories sous forme d'un tableau associatif
	 *
	 * @return array $lesLignes le tableau associatif des catégories 
	*/
	public function getLesCategories()
	{
		$req = 'select * from categorie';
		$res = PdoGsbParam::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}


	/**
	 * Retourne toutes les informations d'une catégorie passée en paramètre
	 *
	 * @param string $idCategorie l'id de la catégorie
	 * @return array $laLigne le tableau associatif des informations de la catégorie 
	*/
	public function getLesInfosCategorie($idCategorie)
	{
		$req = 'SELECT * FROM categorie WHERE id="'.$idCategorie.'"';
		$res = PdoGsbParam::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne;
	}


	/**
	 * Retourne sous forme d'un tableau associatif tous les produits de la
	 * catégorie passée en argument
	 * 
	 * @param string $idCategorie  l'id de la catégorie dont on veut les produits
	 * @return array $lesLignes un tableau associatif  contenant les produits de la categ passée en paramètre
	*/
	public function getLesProduitsDeCategorie($idCategorie)
	{
	    $req='select * from produit where idCategorie ="'.$idCategorie.'"';
		$res = PdoGsbParam::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes; 
	}


	/**
	 * Retourne les produits concernés par le tableau des idProduits passée en argument
	 *
	 * @param array $desIdProduit tableau d'idProduits
	 * @return array $lesProduits un tableau associatif contenant les infos des produits dont les id ont été passé en paramètre
	*/
	public function getLesProduitsDuTableau($desIdProduit) {
		$nbProduits = count($desIdProduit);
		$lesProduits=array();
		if($nbProduits != 0)
		{
			foreach($desIdProduit as $unIdProduit)
			{
				$req = 'select * from produit where id = "'.$unIdProduit.'"';
				$res = PdoGsbParam::$monPdo->query($req);
				$unProduit = $res->fetch();
				$lesProduits[] = $unProduit;
			}
		}
		return $lesProduits;
	}


	/**
	* Retourne le produit concerné par l'id du produit passé en paramètre
	*
	* @param string $idProduit l'identifiant du produit
	* @return array $laLigne les informations du produit
	*/
	public function getUnProduit($idProduit) {
	    $req="SELECT * FROM produit WHERE id='$idProduit';";
		$res = PdoGsbParam::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne; 
	}

	/**
	 * Crée une commande 
	 *
	 * Crée une commande à partir des arguments validés passés en paramètre, l'identifiant est
	 * construit à partir du maximum existant ; crée les lignes de commandes dans la table contenir à partir du
	 * tableau d'idProduit passé en paramètre
	 *
	 * @param string $nom nom du client
	 * @param string $rue rue du client
	 * @param string $cp cp du client
	 * @param string $ville ville du client
	 * @param string $mail mail du client
	 * @param array $lesIdProduit tableau associatif contenant les id des produits commandés 
	 * @return boolan $exec le resultat de l'execution
	*/
	public function creerCommande($nom, $prenom, $rue,$cp,$ville,$mail, $lesIdProduit, $qteProduit ){
		// on récupère le dernier id de commande
		$req = 'select max(id) as maxi from commande';
		$res = PdoGsbParam::$monPdo->query($req);
		$laLigne = $res->fetch();
		$maxi = $laLigne['maxi'] ;// on place le dernier id de commande dans $maxi
		$idCommande = $maxi+1; // on augmente le dernier id de commande de 1 pour avoir le nouvel idCommande
		$date = date('Y/m/d'); // récupération de la date système
		
		$lesRequetes = "insert into commande values ('$idCommande','$date','$mail','$nom', '$prenom','$rue','$cp','$ville');";
		$parcoursIndiceArrayQte=0;
		
		// insertion produits commandés avec leur qte
		foreach($lesIdProduit as $unIdProduit)
		{
			$lesRequetes .= "insert into contenir values ('$idCommande','$unIdProduit', $qteProduit[$parcoursIndiceArrayQte]);";
			
			$parcoursIndiceArrayQte++;
		}
		$req = PdoGsbParam::$monPdo->prepare($lesRequetes);
		return $req->execute();
	}

	/**
	* Créé un client avec un mail, mot de passe, nom & prenom et une adresse (décomposée)
	*
	* @param string $mail mail du client
	* @param string $mdp mot de passe du client
	* @param string $nom nom du client
	* @param string $prenom prénom du client
	* @param string $rue rue du client
	* @param string $cp cp du client
	* @param string $ville ville du client
	* @return boolean Resultat de l'insertion
	*/
	public function creerClient($mail,$mdp,$nom,$prenom,$rue,$cp,$ville) {
		
		$pwd = password_hash( $mdp, PASSWORD_DEFAULT );
		
		$ch = "INSERT INTO client (mel,mdp,nom,prenom,rue,cp,ville) VALUES ('$mail','$pwd','$nom','$prenom','$rue','$cp','$ville')";
		$req = PdoGsbParam::$monPdo->prepare($ch);
		return $req->execute();
	}


	/**
	* Créé un client avec un mail, mot de passe, nom & prenom et une adresse (décomposée)
	*
	* @param string $nom nom du client
	* @param string $mdp mot de passe du client
	* @return boolean Resultat de l'insertion
	*/
	public function creerAdmin($nom,$mdp) {
		$pwd = password_hash( $mdp, PASSWORD_DEFAULT );
			
		$ch = "INSERT INTO administrateur (nom,mdp) VALUES ('$nom','$pwd')";
		
		$req = PdoGsbParam::$monPdo->prepare($ch);
		return $req->execute();		
	}


	/**
	* Retourne les informations d'un client
	*
	* @param string $mail le mail du client souhaité
	* @return array/boolean $userInfo Les informations du client sinon false
	*/
	public function getInfoClient($mail)
	{
		$exec = false;
		$res = PdoGsbParam::$monPdo->query("SELECT * FROM client WHERE mail = '$mail'");
		$userInfo = $res->fetch();

		if(isset($userInfo)){
			$exec = $userInfo;
		}

		return $exec;
	}

	/**
	* Retourne les informations d'un administrateur
	*
	* @param string $nom l'identifiant de l'administrateur souhaité
	* @return array/boolean $userInfo Les informations de l'administrateur sinon false
	*/
	public function getInfoAdmin($nom){
		$exec = false;
		$res = PdoGsbParam::$monPdo->query("SELECT * FROM administrateur WHERE nom = '$nom'");
		$userInfo = $res->fetch();

		if(isset($userInfo)){
			$exec = $userInfo;
		}

		return $exec;
	}

	/**
	* Connecte un utilisateur au site
	*
	* @param string $mail le mail de l'utilisateur
	* @param string $mdp le mot de passe de l'utilisateur
	* @return array $lesErreurs l'ensemble des potentielles erreurs lors de la connexion
	*/
	public function connexionUtilisateur($mail, $mdp)
	{
		$req = PdoGsbParam::$monPdo->query("SELECT * FROM client WHERE mail='$mail';");
		$req2 = PdoGsbParam::$monPdo->query("SELECT * FROM administrateur WHERE nom='$mail';");
		
		if($req || $req2){

			$userInfo = $req->fetch();
			$userInfo2 = $req2->fetch();

			if($userInfo || $userInfo2){

				if($userInfo){
					$mdpBDD = $userInfo['mdp'];
				} else {
					$mdpBDD = $userInfo2['mdp'];
				}

				if (password_verify($mdp, $mdpBDD)){
					$lesErreurs[] = null;
					if($userInfo2){
						$_SESSION['admin']=true;
					}
				} else {
					$lesErreurs[] = 'Mot de passe incorrect !';
				}

			} else {
				$lesErreurs[] = 'Mel incorrect !';
			}
		} else {
			$lesErreur[] = "Erreur...";
		}
		return $lesErreurs;
	}


	/**
	* Fonction qui réplique en local le panier (stocké en ligne) du client
	*
	* @param string $mail l'adresse email du client
	*/
	public function getPanierClient($mail) {
		$res = PdoGsbParam::$monPdo->query("SELECT * FROM panier_client WHERE mailClient = '$mail'");
		if($res){
			$panier_client = $res->fetchAll();

			if(!isset($_SESSION['produits'])) {
				initPanier();
			}

			foreach ($panier_client as $uneLigne) {
				//Si l'utilisateur a mit ce produit dans son panier sans être connecté on cumule le panier stocké dans bdd et panier local
				//Sinon on initialise la panier avec les données de la bdd
				if(isset($_SESSION['produits'][$uneLigne['produit']])){
					$_SESSION['produits'][$uneLigne['produit']]+=$uneLigne['qte'];
				} else {
					$_SESSION['produits'][$uneLigne['produit']]=$uneLigne['qte'];
				}
			}
		}
	}



	/**
	* Fonction qui met à jour le panier de l'utilisateur
	*
	* @param string $mail adresse email du client
	* @return boolean $exec resultat de l'execution
	*/
	public function setPanierClient($mail){
		$exec = false;
		$lesProduits = getLesIdProduitsDuPanier();
		if( !empty($lesProduits) ) {
			
			$ch="DELETE FROM panier_client WHERE mailClient = '$mail'";
			$i=0;
			
			foreach (getLesIdProduitsDuPanier() as $unProduit) {
				$qte = getLesQteProduitsDuPanier()[$i];
				$ch .="INSERT INTO panier_client (mailClient, produit, qte) VALUES ('$mail', '$unProduit',$qte);";
				$i++;
			}

			$req = PdoGsbParam::$monPdo->prepare("DELETE FROM panier_client WHERE mailClient = '$mail'");
			$exec = $req->execute($ch);
		}
		return $exec;
	}



	/**
	* Fonction qui retire une unité dans le panier du client
	*
	* @param string $idProduit identifiant du produit
	* @return boolean $exec resultat de l'execution
	*/
	public function retirerDuPanier($idProduit){
		$exec = false;
		$mail = $_SESSION['mail'];
		$req = PdoGsbParam::$monPdo->query("SELECT qte FROM panier_client WHERE mailClient = '$mail' AND produit = '$idProduit';");
		
		$res = $req->fetch();
		if($res) {
			
			if($res['qte']>1){
				$ch = "UPDATE panier_client SET qte = (qte - 1) WHERE mailClient = '$mail' AND produit = '$idProduit';";
			}
			else {
				$ch = "DELETE FROM panier_client WHERE mailClient = '$mail' AND produit = '$idProduit';";
			}

			$req = PdoGsbParam::$monPdo->prepare($ch);
			$exec = $req->execute();
		}
		return $exec;
	}

	public function viderPanier(){
		$mail = $_SESSION['mail'];
		$req = PdoGsbParam::$monPdo->prepare("DELETE FROM panier_client WHERE mailClient = '$mail'");
		return $req->execute();
	}


	/**
	* Incrémente la quantité pour le produit dans un panier
	*
	* @param string $idProduit identifiant du produit
	* @return boolean $exec resultat de l'execution
	*/
	public function ajouterAuPanier($idProduit){
		$exec = false;
		$mail = $_SESSION['mail'];
		$req = PdoGsbParam::$monPdo->query("SELECT qte FROM panier_client WHERE mailClient = '$mail' AND produit = '$idProduit'");
		
		$res = $req->fetch();
		if($res) {
			$ch = "UPDATE panier_client SET qte = (qte + 1) WHERE mailClient = '$mail' AND produit = '$idProduit'";
		} else {
			$ch = "INSERT INTO panier_client (mailClient, produit, qte) VALUES ('$mail', '$idProduit',1)";
		}

		if(isset($ch)){
			$req = PdoGsbParam::$monPdo->prepare($ch);
			$exec = $req->execute();
		}

		return $exec;

	}


	/**
	* Modifier les infos d'un produit & retourne un booleen qui témoigne de la bonne execution ou non
	*
	* @param $idProduit identifiant du produit à modifier
	* @param $descProduit nouvelle description du produit
	* @param $prixProduit nouveau prix du produit
	* @param $categorieProduit nouvelle catégorie du produit
	* @return boolean resultat de l'execution
	*/
	public function modifProduit($idProduit, $descProduit, $prixProduit, $categorieProduit){

		$ch = "SELECT * FROM produit WHERE id='$idProduit';";
		$req = PdoGsbParam::$monPdo->query($ch);
		$res = $req->fetch();

		//Vérification qui permet d'éviter de retourner false (et donc d'afficher une erreur) si les infos du produit n'ont pas été modifiées
		//EX: modif uiquement de la promo
		if($idProduit==$res['id'] && $prixProduit==$res['prix'] && $descProduit==$res['description'] && $categorieProduit==$res['idCategorie']){
			$exec = true;
		} else {
			$req = PdoGsbParam::$monPdo->prepare("UPDATE produit SET description='$descProduit', prix='$prixProduit', idCategorie='$categorieProduit' WHERE id='$idProduit'");
			$exec = $req->execute();
		}

		return $exec;
	}

	/**
	* Ajouter ou modifier la pormotion en cours pour le produit
	*
	* @param $idProduit identifiant du produit
	* @param $dateDebut date de début de la promotion
	* @param $dateFin date de fin de la promotion
	* @param $tauxPromo taux (pourcentage) de la promotion
	* @return int resultat de l'execution
	*/
	public function modifPromo($idProduit, $dateDebut, $dateFin, $tauxPromo){
		$etat = "";

		//Entrée : Mauvaise des dates
		if($dateDebut > $dateFin){
			$etat = 1;
		} else {
			//Récupère la promotion dont les dates entrée en paramètres sont comprise entre celles de la bdd 
			$ch = "SELECT * FROM promotion WHERE idProduit='$idProduit' AND ( ('$dateDebut' BETWEEN dateDebut AND dateFin) OR ('$dateFin' BETWEEN dateDebut AND dateFin)) ORDER BY dateDebut,dateFin DESC";
			$req = PdoGsbParam::$monPdo->query($ch);
			
			if($req){
				
				$laPromo = $req->fetch();

				//Entrée : Il existe déjà une promotion sur cette periode
				if(($laPromo['dateDebut']<$dateDebut && $laPromo['dateFin']<$dateDebut) || ($laPromo['dateDebut']<$dateFin && $laPromo['dateFin']<$dateFin) ){
					$etat = 2;
				}
			} else {
				$req = PdoGsbParam::$monPdo->prepare("INSERT INTO promotion (idProduit,dateDebut,dateFin,tauxPromo) VALUES ('$idProduit','$dateDebut','$dateFin',($tauxPromo/100);");

				//Entrée : Insertion pormo réussie
				if ($req->execute() ){
					$etat = 3;
				}
				//Entée : modification de la promo réussie 
				else {
					$req = PdoGsbParam::$monPdo->prepare("UPDATE promotion SET dateFin='$dateFin',tauxPromo=($tauxPromo/100) WHERE idProduit='$idProduit' AND dateDebut='$dateDebut';");
					if ($res->execute()){
						$etat = 4;
					} else {
						$etat = 5;
					}
				}
			}
		}

		return $etat;

	}


	/**
	* Fonction qui retourne la promotion active de l'article
	*
	* @param string $idProduit Identifiant du produit
	* @return array/boolean resultat de la requête
	*/
	public function getPromotion($idProduit){
		$ch = "SELECT * FROM promotion WHERE idProduit='$idProduit'AND CURRENT_TIMESTAMP BETWEEN dateDebut AND dateFin";
		$req = PdoGsbParam::$monPdo->query($ch);
		$res = false;
		
		if($req){
			$res = $req->fetch();
		}

		return $res;
	}


	/**
	* Fonction qui supprime un produit de la base de données
	* @param string $idProduit l'identifiant du produit à supprimer
	*/
	public function rmProduit($idProduit){
		$ch = "DELETE FROM panier_client WHERE produit = '$idProduit';
		DELETE FROM promotion WHERE idProduit = '$idProduit';
		DELETE FROM contenir WHERE idProduit = '$idProduit';
		DELETE FROM produit WHERE id = '$idProduit';";
		
		$req = PdoGsbParam::$monPdo->prepare($ch);
		return $req->execute();
	}


	/**
	* Fonction qui creer un nouveau produit
	*
	* @param string $id identifiant du produit
	* @param string $description description du produit
	* @param flaot $prix prix du produit
	* @param string $categorie identifiant de la catégorie du produit
	* @param string $image chemin vers de l'image du produit
	* @return boolean $exec Résultat de l'éxecution
	*/
	public function creerProduit($id,$description,$prix,$categorie,$image){
		$ch = "INSERT INTO produit (id,description,prix,idCategorie,image) VALUES ('$id','$description', $prix, '$categorie', '$image');";

		$req = PdoGsbParam::$monPdo->prepare($ch);
		return $req->execute();

	}
}
?>