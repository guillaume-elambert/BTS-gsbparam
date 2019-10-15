<ul id="categories">
<?php
foreach( $lesCategories as $uneCategorie) 
{
	$idCategorie = $uneCategorie['id'];
	$libCategorie = $uneCategorie['libelle'];
	
	if(isset($_SESSION['admin'])){
		$lien = "administrer&categorie=".$idCategorie;
		if($idCategorie == "ajoutProd"){
			$lien .= "&action=ajoutProduit";
		} else {
			$lien .= "&action=voirProduits";
		}
	} else {
		$uc = "voirProduits";
		$lien = "voirProduits&categorie=".$idCategorie."&action=voirProduits";
	}
	?>
	<li>
		<a href="index.php?uc=<?php echo $lien;?>">
		<?php echo $libCategorie ?></a>
	</li>
<?php
}
?>
</ul>

