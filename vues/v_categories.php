<ul id="categories">
<?php
foreach( $lesCategories as $uneCategorie) 
{
	$idCategorie = $uneCategorie['id'];
	$libCategorie = $uneCategorie['libelle'];
	
	if(isset($_SESSION['admin'])){
		$lien = "administrer";

		switch ($idCategorie){
			
			case 'ajoutProd' : {
				
				//Si user sur la page d'une categorie, permet de séléctionner, par défaut,
				// la catégorie en question dans le formulaire de création du produit
				if(isset($_REQUEST['categorie'])){
					$lien .= "&categorie=".$_REQUEST['categorie'];
				}

				$lien .= "&action=ajoutProduit";

				break;
			} 

			case 'ajoutAdmin' : {
				$lien .= "&action=ajoutAdmin";
				break;
			}

			default : {
				$lien .= "&categorie=".$idCategorie."&action=voirProduits";
				break;
			}
		}
	} else {
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

