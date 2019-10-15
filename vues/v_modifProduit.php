<?php
  $description = $unProduit['description'];
  $prix = $unProduit['prix'];
  $categorie = $unProduit['idCategorie'];
  $image = $unProduit['image'];

  if($promotion!=false){
    $tauxPromo = $promotion['tauxPromo']*100;
    $dateDeb = $promotion['dateDebut'];
    $dateFin = $promotion['dateFin'];
  } else {
    $tauxPromo = 0;
    $dateDeb = "";
    $dateFin = "";
  }
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
           <input id="prix" type="number" name="prix" value="<?php echo $prix ?>" min="1" step="any" required>
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

    </fieldset><br/><br/>

    <fieldset>


      <legend>Promotion</legend>

      <p>
        <label for="dateDeb">Date de début* </label>
        <input id="dateDeb" type="date"  name="dateDeb" min="<?php echo date("Y-m-d", time()); ?>" value="<?php echo $dateDeb ?>" size ="90" maxlength="90">
      </p>


      <p>
        <label for="dateFin">Date de fin* </label>
        <input id="dateFin" type="date"  name="dateFin" min="<?php echo date("Y-m-d", time()); ?>" value="<?php echo $dateFin ?>" size ="90" maxlength="90">
      </p>


      <p>
        <label for="tauxPromo">Pourcentage de réduction* </label>
        <input id="tauxPromo" type="number" min="0" max="100" name="tauxPromo" value="<?php echo $tauxPromo ?>" step="any">
      </p>

    </fieldset>

    <p>
       <input type="submit" value="Valider" name="valider">
       <input type="reset" value="Annuler" name="annuler"> 
    </p>

  </form>
</div>