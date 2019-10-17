<?php
/**
* fichier qui contient les fonctions qui ne font pas accès aux données de la BD
*
* regroupe les fonctions pour gérer le panier, et les erreurs de saisie dans le formulaire de commande
*
* @package  GsbParam\util
* @version 2019_v2
*
*/


/**
 * Initialise le panier
 *
 * Crée un tableau associatif $_SESSION['produits']en session dans le cas
 * où il n'existe pas déjà
*/
function initPanier(){
	if(!isset($_SESSION['produits']))
	{
		$_SESSION['produits'] = array();
	}
}


/**
 * Supprime le panier
 *
 * Supprime le tableau associatif $_SESSION['produits']
 */
function supprimerPanier(){
	unset($_SESSION['produits']);
}


/**
 * Ajoute un produit au panier
 *
 * Teste si l'identifiant du produit est déjà dans la variable session 
 * ajoute l'identifiant à la variable de type session dans le cas où
 * où l'identifiant du produit n'a pas été trouvé
 *
 * @param string $idProduit identifiant de produit
 * @return boolean $ok vrai si le produit n'était pas dans la variable, faux sinon 
*/
function ajouterAuPanier($idProduit){
	$ok = true;
	if(isset($_SESSION['produits'][$idProduit]))/*in_array($idProduit,$_SESSION['produits'])*/
	{
		$_SESSION['produits'][$idProduit]++;
	}
	else
	{
		$_SESSION['produits'][$idProduit]=1;
	}

	return $ok;
}


/**
 * Retourne le tableau des identifiants de produit
 * @return array $_SESSION['produits'] le tableau des id produits du panier 
*/
function getLesIdProduitsDuPanier(){
	return array_keys($_SESSION['produits']);

}

/**
 * Retourne la quantité des produits du panier
 *
 * @return array $_SESSION['produits'] le tableau des id produits du panier 
*/
function getLesQteProduitsDuPanier(){
	$array;
	foreach ($_SESSION['produits'] as $unProduit) {
		$array[]=$unProduit;
	}
	return $array;

}



/**
 * Retourne le nombre de produits du panier
 *
 * Teste si la variable de session existe
 * et retourne le nombre d'éléments de la variable session
 * 
 * @return int $n le nombre de produits dans le panier
*/
function nbProduitsDuPanier(){
	$totProduits = 0;
	if (isset($_SESSION['produits']) && sizeof($_SESSION['produits']) > 0){
		
		/*Somme des quantités des produits*/
		foreach ($_SESSION['produits'] as $unProduit) {
			$totProduits += $unProduit;
		}

		if(isset($_GET['action'])) {
			/*Si l'utilisateur vient de supprimer un produit de son panier*/
			if ( $_GET['action']!='viderPanier'){
				if($_GET['action']=='supprimerUnProduit'){
					if ($totProduits-1 > 0){
						$totProduits-=1;
					}
				}
			} else {
				$totProduits=0;
			}
		}
	}
	
	return $totProduits;
	
}


/**
 * Retire un de produits du panier
 *
 * Recherche l'index de l'idProduit dans la variable session
 * et détruit la valeur à ce rang
 *
 * @param string $idProduit identifiant de produit
*/
function retirerDuPanier($idProduit){
	if($_SESSION['produits'][$idProduit]>1){
		$_SESSION['produits'][$idProduit]--;
	}
	else {
		unset($_SESSION['produits'][$idProduit]);
	}
}


/**
 * teste si une chaîne a un format de code postal
 *
 * Teste le nombre de caractères de la chaîne et le type entier (composé de chiffres)
 *
 * @param string $codePostal  la chaîne testée
 * @return boolean $ok vrai ou faux
*/
function estUnCp($codePostal){
   return strlen($codePostal)== 5 && estEntier($codePostal);
}


/**
 * teste si une chaîne est un entier
 *
 * Teste si la chaîne ne contient que des chiffres
 *
 * @param string $valeur la chaîne testée
 * @return boolean $ok vrai ou faux
*/
function estEntier($valeur) {
	return preg_match("/[^0-9]/", $valeur) == 0;
}


/**
 * Teste si une chaîne a le format d'un mail
 *
 * Utilise les expressions régulières
 *
 * @param string $mail la chaîne testée
 * @return boolean $ok vrai ou faux
*/
function estUnMail($mail){
	return  preg_match ('#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#', $mail);
}


/**
 * Retourne un tableau d'erreurs de saisie pour une commande
 *
 * @param string $nom  chaîne testée
 * @param  string $rue chaîne
 * @param string $ville chaîne
 * @param string $cp chaîne
 * @param string $mail  chaîne 
 * @return array $lesErreurs un tableau de chaînes d'erreurs
*/
function getErreursSaisieCommande($nom,$prenom,$rue,$ville,$cp,$mail){
	$lesErreurs = array();
	if($nom=="")
	{
		$lesErreurs[]="Il faut saisir le champ nom";
	}
	if($prenom=="")
	{
		$lesErreurs[]="Il faut saisir le champ prénom";
	}
	if($rue=="")
	{
	$lesErreurs[]="Il faut saisir le champ rue";
	}
	if($ville=="")
	{
		$lesErreurs[]="Il faut saisir le champ ville";
	}
	if($cp=="")
	{
		$lesErreurs[]="Il faut saisir le champ Code postal";
	}
	else
	{
		if(!estUnCp($cp))
		{
			$lesErreurs[]= "erreur de code postal";
		}
	}
	if($mail=="")
	{
		$lesErreurs[]="Il faut saisir le champ mail";
	}
	else
	{
		if(!estUnMail($mail))
		{
			$lesErreurs[]= "erreur de mail";
		}
	}
	return $lesErreurs;
}

/**
* Fonction qui creer une image dans le fichier images/
*
* @return boolean $exec Résultat de l'execution
*/
function creerImage(){
	
	$exec = false;

	$fichier = $_FILES['image'];
	$emplacementFichier = "images/" . basename($fichier["name"]);
	$extensionFichier = strtolower(pathinfo($fichier["name"],PATHINFO_EXTENSION));
	
	$listeExtAccpetees = array('png','jpg','jpeg','gif');
	
	//Vérifie si le fichier est une image
    if(in_array($extensionFichier, $listeExtAccpetees)){
    	if(getimagesize($fichier["tmp_name"])) {
			if(move_uploaded_file($fichier["tmp_name"], $emplacementFichier)){
				$exec = true;
			}
	    }
	}

    return $exec;
}
?>
