<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>recuperer mdp</title>
    <link rel="stylesheet" href="css/login.css" />
</head>
<body>
	<?php
 if (isset($_SESSION['echec'])){
   echo "<p class='message'>vous etes deja connecter</p>";}
echo"<p>repondez a :</p>";
echo"<P>{$rep['secrete']}</p>";
?>
<form id="recu" method="POST" action="mmdp.php">
			<p class="r">
				<label for="rep">reponce : </label>
<input name="rep" id="user_login" class="input"  type="text"/>
			</p>
			    <button id="but" type="submit" name="valid">envoyer</button>
</form>
</body>
</html>
