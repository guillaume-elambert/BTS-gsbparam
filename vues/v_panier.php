<div><img src="images/panier.gif"	alt="Panier" title="panier"/></div>
<div id="produits">
<?php

foreach( $lesProduitsDuPanier as $unProduit) 
{
	// récupération des données d'un produit
	$id = $unProduit['id'];
	$description = $unProduit['description'];
	$image = $unProduit['image'];
	$prix = $unProduit['prix'];
	// affichage
	?>
	<div class="card">
			<div class="photoCard"><img src="<?php echo $image ?>" alt="image descriptive" /></div>
	<div class="descrCard"><?php echo	$description;?>	</div>
	<div class="prixCard"><?php echo $prix."€" ?></div>
	<div class="imgCard"><a href="index.php?uc=gererPanier&produit=<?php echo $id ?>&action=supprimerUnProduit" onclick="return confirm('Voulez-vous vraiment retirer cet article ?');">
	<img src="images/retirerpanier.png" title="Retirer du panier" alt="retirer du panier"></a></div>
	</div>
	<?php
}
?>
<div class="commande">
<a href="index.php?uc=gererPanier&action=passerCommande"><img src="images/commander.jpg" title="Passer commande" alt="Commander"></a>

<a href="?uc=gererPanier&action=viderPanier" onclick="return confirm('Voulez-vous vraiment vider le panier ?');"><img src="images/retirerpanier.png" style="left:200px;" title="Vider le panier" alt="Vider le panier"><p style="position: absolute; bottom: 70px;left: 240px;">Vider le panier</p></a></div>
	</div></a>
</div>
</div>
<br/>
