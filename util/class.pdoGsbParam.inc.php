<?php

/** 
* fichier class.PdoGsbParam.inc.php
* contient la classe PdoGsbParam qui fournit 
* un objet pdo et des méthodes pour récupérer des données d'une BD
 */

 /** 
 * PdoGsbParam
 
 * classe PdoGsbParam : classe d'accès aux données. 
 * Utilise les services de la classe PDO
 * pour l'application GsbParam
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 
* @package  GsbParam\util
* @version 2019_v2
* @author M. Jouin
*/

class PdoGsbParam
{   	
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
	public function getLesProduitsDuTableau($desIdProduit)
	{
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
	 * Crée une commande 
	 *
	 * Crée une commande à partir des arguments validés passés en paramètre, l'identifiant est
	 * construit à partir du maximum existant ; crée les lignes de commandes dans la table contenir à partir du
	 * tableau d'idProduit passé en paramètre
	 * @param string $nom nom du client
	 * @param string $rue rue du client
	 * @param string $cp cp du client
	 * @param string $ville ville du client
	 * @param string $mail mail du client
	 * @param array $lesIdProduit tableau associatif contenant les id des produits commandés
	 
	*/
	public function creerCommande($nom, $prenom, $rue,$cp,$ville,$mail, $lesIdProduit )
	{
		// on récupère le dernier id de commande
		$req = 'select max(id) as maxi from commande';
		$res = PdoGsbParam::$monPdo->query($req);
		$laLigne = $res->fetch();
		$maxi = $laLigne['maxi'] ;// on place le dernier id de commande dans $maxi
		$idCommande = $maxi+1; // on augmente le dernier id de commande de 1 pour avoir le nouvel idCommande
		$date = date('Y/m/d'); // récupération de la date système
		$req = "insert into commande values ('$idCommande','$date','$nom','$rue','$cp','$ville','$mail')";
		$res = PdoGsbParam::$monPdo->exec($req);
		// insertion produits commandés
		foreach($lesIdProduit as $unIdProduit)
		{
			$req = "insert into contenir values ('$idCommande','$unIdProduit')";
			$res = PdoGsbParam::$monPdo->exec($req);
		}
	}

	public function creerClient($mail,$mdp,$nom,$prenom,$rue,$cp,$ville)
	{
		$pwd = password_hash( $mdp, PASSWORD_DEFAULT );
		
		$req = "INSERT INTO client (mel,mdp,nom,prenom,rue,cp,ville) VALUES ('$mail','$pwd','$nom','$prenom','$rue','$cp','$ville')";
		$res = PdoGsbParam::$monPdo->exec($req);
	}

	public function getClient($mail)
	{
		$req = "SELECT * FROM client WHERE mail = '$mail'";
		$res = PdoGsbParam::$monPdo->exec($req);
		$leClient = $res->fetch();
		$nom = $leClient['nom']; $prenom = $leClient['prenom']; $rue = $leClient['rue']; $cp = $leClient['cp']; $ville = $leClient['ville']; $mail = $leClient['mel']; 
	}

	public function getInfoClient($mail)
	{
		$res = PdoGsbParam::$monPdo->query("SELECT * FROM client WHERE mel = '".$mail."'");
		$userInfo = $res->fetch();

		if(isset($userInfo)){
			return $userInfo;
		} else {
			return 1;
		}
	}

	public function connexionUtilisateur($mail, $mdp)
	{
		$res = PdoGsbParam::$monPdo->query("SELECT * FROM client WHERE mail='".$mail."'");
		$userInfo = $res->fetch();

		if(isset($userInfo)){
			if (password_verify($mdp,$userInfo['mdp'])){
				$lesErreurs[] = null;
			} else {
				$lesErreurs[] = 'Mot de passe incorrect !';
			}
		} else {
			$lesErreurs[] = 'Mel incorrect !';
		}
		return $lesErreurs;
	}
}
?>