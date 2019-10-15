<div id="produits">

<?php
// parcours du tableau contenant les produits à afficher
foreach( $lesProduits as $unProduit) 
{ 	// récupération des informations du produit
	$id = $unProduit['id'];
	$description = $unProduit['description'];
	$prix=$unProduit['prix'];
	$image = $unProduit['image'];
	// affichage d'un produit avec ses informations
	?>	
	<div class="card">
		<div class="photoCard"><img src="<?php echo $image ?>" alt=image /></div>
		<div class="descrCard"><?php echo $description ?></div>
		<div class="prixCard"><?php echo $prix."€" ?></div>
		
		<div class="imgCard">
			<?php
			if(isset($_SESSION['admin']) ) {
				echo "<a href=\"?uc=administrer&categorie=".$categorie."&produit=".$id."&action=modifierInfos\">Modifier les infos de ce produit</a>";
			} else {
				echo "<a href=\"?uc=voirProduits&categorie=".$categorie."&produit=".$id."&action=ajouterAuPanier&pact=".$_REQUEST['action']."\"><img src=\"images/mettrepanier.png\" title=\"Ajouter au panier\" alt=\"Mettre au panier\"></a>";
			}
			?>
		</div>	
	</div>
<?php			
} // fin du foreach qui parcourt les produits
?>
</div>
