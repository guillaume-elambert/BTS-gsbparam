<?php
session_start();
include("vues/v_entete.php") ;
require_once("util/fonctions.inc.php");
require_once("util/class.pdoGsbParam.inc.php");
include("vues/v_bandeau.php");
/*unset($_SESSION['produits']);
var_dump($_SESSION['produits']);
var_dump(getLesIdProduitsDuPanier());
var_dump($_SESSION['produits']);
foreach ($_SESSION['produits'] as $unProduit) {
	$array[]=$unProduit;
}
var_dump($array);*/
if(!isset($_REQUEST['uc']))
    $uc = 'accueil'; // si $_GET['uc'] n'existe pas , $uc reçoit une valeur par défaut
else
	$uc = $_REQUEST['uc'];

$pdo = PdoGsbParam::getPdoGsbParam();	 

switch($uc)
{
	case 'accueil':
		{include("vues/v_accueil.php");break;}
	case 'voirProduits' :
		{include("controleurs/c_voirProduits.php");break;}
	case 'gererPanier' :
		{ include("controleurs/c_gestionPanier.php");break; }
	case 'administrer' :
	  { include("controleurs/c_gestionProduits.php");break;  }
	case 'utilisateur' :
	  { include("controleurs/c_gestionUtilisateurs.php");break;  }
}
include("vues/v_pied.php") ;
?>

