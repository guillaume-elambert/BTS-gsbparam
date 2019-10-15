<div id="bandeau">
<!-- Images En-tête -->
<img src="images/logo.jpg"	alt="GsbLogo" title="GsbLogo"/>
</div>
<!--  Menu haut-->
<ul id="menu">
	<li><a href="index.php?uc=accueil"> Accueil </a></li>
	<li><a href="index.php?uc=voirProduits&action=voirCategories"> Nos produits par catégorie </a></li>
	
	<?php 
	if(isset($_SESSION['admin'])){
		$lien = "index.php?uc=administrer";
		$title = "un test";
	} else {
		echo "<li><a href=\"index.php?uc=voirProduits&action=nosProduits\"> Nos produits </a></li>";
		$lien = "index.php?uc=gererPanier&action=voirPanier";
		$title = "Voir son panier (".nbProduitsDuPanier().")";
	}
	?>
	<li><a href=<?php echo $lien ?>> <?php echo $title ?></a></li>
	<li><a href="?uc=utilisateur&action=connexion" <?php if(isset($_SESSION['mail'])) echo 'title="'.$_SESSION['mail'].'" onclick=\'return confirm("Voulez-vous vraiment vous deconnecter ?");\'"> Se déconnecter'; else echo '> Se connecter';?> </a></li>
</ul>