<div id="creationCommande">
<form method="POST" action="?uc=utilisateur&action=connexion">
   <fieldset>
     <legend>Inscription</legend>
      <p>
         <label for="mail">mail* </label>
         <input id="mail" type="text"  name="mail" value="<?php echo $mail ?>" size ="90" maxlength="90" required>
      </p>
      <p>
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





