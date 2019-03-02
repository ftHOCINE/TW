
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>Authentifiez-vous</title>
    <link rel="stylesheet" href="css/login.css" />
</head>
<body>
	<?php
 if (isset($_SESSION['echec']))
   echo "<p class='message'>Les login et mot de passe précédemment fournis étaient incorrects</p>";
?>
<div id="login">
<h1>ULiMeet</h1>
<form id="loginform" method="POST" action="">
			
			<p class="login-username">
				<label for="login">Pseudo </label>
				<input name="login" id="user_login" class="input"  type="text"/>
			</p>
			<p class="login-password">
				<label for="password">Mot de passe</label>
				<input name="password" id="user_pass" class="input" type="password" required="required"/>
			</p>
				<center>
			    <button id="but" type="submit" name="valid">se connecter</button>
				</center>
		</form>
<p id="nav">
	<a href="modifiermdp.php" title="Récupération de mot de passe">Mot de passe oublié?</a> 
	<a href="registrer.php" title="Créer un compte">Créer un compte</a>
</p>
</div>
</body>
</html>



	
