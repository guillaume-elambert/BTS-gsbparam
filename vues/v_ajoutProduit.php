<div id="ajoutProduit">
  <form method="POST" action="?uc=administrer&action=confirmerAjoutProduit" enctype="multipart/form-data">
     <fieldset>
        <legend>Modification d'un produit</legend>
        

        <p>
          <label for="id">Identifiant du produit* </label>
          <input id="id" type="text"  name="id" value="<?php echo $id ?>" size ="90" maxlength="90" required>
        </p>

        <p>
          <label for="description">Description* </label>
          <input id="description" type="text"  name="description" value="<?php echo $description ?>" size ="90" maxlength="90" required>
        </p>


        <p>
          <label for="prix">Prix* </label>
          <input id="prix" type="number" name="prix" value="<?php echo $prix ?>" min="0" step="any" required>
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
          <label for="image">Image* </label>
          <input type="file" id="image" name="image" accept="image/png, image/jpg, image/jpeg, image/gif" required>
        </p>

        <p>
          <input type="submit" value="Valider" name="valider">
          <input type="reset" value="Annuler" name="annuler"> 
        </p>

      </fieldset>
  </form>
</div>