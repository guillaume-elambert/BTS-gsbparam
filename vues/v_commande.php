<?php /*if(!isset($_SESSION['mail'])){
   header('Location: ?uc=utilisateur&action=inscription');
} else {*/?>

<div id="creationCommande">
<form method="POST" action="index.php?uc=gererPanier&action=confirmerCommande">
   <fieldset>
     <legend>Passer Commande</legend>
		<p>
			<label for="nom">Nom*</label>
			<input id="nom" type="text" name="nom" value="<?php echo $nom ?>" size="30" maxlength="30">
		</p>
      <p>
         <label for="prenom">Prénom*</label>
         <input id="prenom" type="text" name="prenom" value="<?php echo $prenom ?>" size="30" maxlength="30">
      </p>
		<p>
			<label for="rue">rue*</label>
			 <input id="rue" type="text" name="rue" value="<?php echo $rue ?>" size="30" maxlength="60">
		</p>
		<p>
         <label for="cp">code postal* </label>
         <input id="cp" type="text" name="cp" value="<?php echo $cp ?>" size="5" maxlength="5">
      </p>
      <p>
         <label for="ville">ville* </label>
         <input id="ville" type="text" name="ville"  value="<?php echo $ville ?>" size="5" maxlength="5">
      </p>
      <p>
         <label for="mail">mail* </label>
         <input id="mail" type="text"  name="mail" value="<?php echo $mail ?>" size ="25" maxlength="90">
      </p> 
	  	<p>
         <input type="submit" value="Valider" name="valider">
         <input type="reset" value="Annuler" name="annuler"> 
      </p>
	  </fieldset>
</form>
</div>
<?php //} ?>





