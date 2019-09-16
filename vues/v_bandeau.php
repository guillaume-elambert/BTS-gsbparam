<div id="bandeau">
<!-- Images En-tête -->
<img src="images/logo.jpg"	alt="GsbLogo" title="GsbLogo"/>
</div>
<!--  Menu haut-->
<ul id="menu">
	<li><a href="index.php?uc=accueil"> Accueil </a></li>
	<li><a href="index.php?uc=voirProduits&action=voirCategories"> Nos produits par catégorie </a></li>
	<li><a href="index.php?uc=voirProduits&action=nosProduits"> Nos produits </a></li>
	
	<li><a href="index.php?uc=gererPanier&action=voirPanier"> Voir son panier 
		<?php
		/*if (isset($_GET['action']) && $_GET['action']=='supprimerUnProduit'){
			echo "(".(sizeof($_SESSION['produits'])-1).")";
		}*/
		if (isset($_SESSION['produits']) && sizeof($_SESSION['produits']) > 0){
			
			if (isset($_GET['action']) && $_GET['action']!='viderPanier'){
				if($_GET['action']=='supprimerUnProduit'){
					if (sizeof($_SESSION['produits'])-1 > 0){
						echo "(".(sizeof($_SESSION['produits'])-1).")";
					}
				}
				else {
					echo "(".sizeof($_SESSION['produits']).")";
				}
			}
		} else {
			echo "(0)";
		}
		?>
	</a></li>
</ul>