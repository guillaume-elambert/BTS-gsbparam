<?php
  $description = $unProduit['description'];
  $prix = $unProduit['prix'];
  $categorie = $unProduit['idCategorie'];
  $image = $unProduit['image'];
?>

<div id="modifProduit">
  <form method="POST" action="?uc=administrer&action=confirmerModif&produit=<?php echo $_REQUEST['produit'] ?>">
     <fieldset>
       <legend>Modification d'un produit</legend>
        
        <p>
           <label for="description">Description* </label>
           <input id="description" type="text"  name="description" value="<?php echo $description ?>" size ="90" maxlength="90" required>
        </p>


        <p>
           <label for="prix">Prix* </label>
           <input id="prix" type="number" name="prix" value="<?php echo $prix ?>" min="1" required>
        </p>


        <p>
          <label for="categorie">Catégorie* </label>
          <select name="categorie">
            <?php
            foreach($lesCategories as $uneCategorie){
              $laCateg = $uneCategorie['id'];
              $leLib = $uneCategorie['libelle'];
              if($laCateg==$categorie){
                echo "<option value=\"$laCateg\" selected>$leLib</option>";
              } else {
                echo "<option value=\"$laCateg\">$leLib</option>";
              }
            }
            ?>
          </select>
        </p>

        
        <p>
           <input type="submit" value="Valider" name="valider">
           <input type="reset" value="Annuler" name="annuler"> 
        </p>

       </fieldset>
  </form>
</div>