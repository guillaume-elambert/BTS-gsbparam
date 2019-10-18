<?php 
	if(isset($_REQUEST['message'])){
		$message=$_REQUEST['message'];
		include("vues/v_message.php");
	} else if ( isset($_REQUEST['erreur'])){
		$msgErreurs[] = $_REQUEST['erreur'];
		include ("vues/v_erreurs.php");
	}
?>

<div id="accueil">

	<h1 id="TitreAcc">La société GsbPara,</h1>

	<h2 id="Titre2Acc"> vous souhaite la bienvenue sur son site de vente en ligne ,</h2>

	<p id="TextAcc">de produits paramédicaux et bien-être  </p>

	<p>à destination des particuliers.</p>

	<p>Avec plus de 2000 produits paramédicaux à la vente, GsbPara vous propose à 
	un tarif compétitif un large panel de produits livrés rapidement chez vous !</p>

	<br/><br/>
	<h2>Liste des uilisateurs :</h2>
	<p>guillaume.elambert@yahoo.fr:root -> client</p>
	<p>root:root -> administrateur</p>

	<br/><br/>
	<h2>Utilisateur BDD :</h2>
	<p>visiteurSite:a5UTXhjsMreUpAJU</p>
</div>