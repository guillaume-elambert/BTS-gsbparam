<div id="inscriptionAdmin">
<form method="POST" action="?uc=administrer&action=confirmerInscriptionAdmin">
   <fieldset>
     <legend>Inscription</legend>
      <p>
         <label for="nom">Login*</label>
         <input id="nom" type="text" name="nom" value="<?php echo $nom ?>" size="30" maxlength="30" required>
      </p>
      
         <label for="mdp">Mot de passe* </label>
         <input id="mdp" type="password"  name="mdp" size ="90" maxlength="90" required>
      </p> 
      <p>
         <input type="submit" value="Valider" name="valider">
         <input type="reset" value="Annuler" name="annuler"> 
      </p>
     </fieldset>
</form>
</div>

<br/><a href="?uc=utilisateur&action=connexion">Déjà membre ? Connectez-vous ici !</a>





