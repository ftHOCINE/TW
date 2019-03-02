<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>recuperer mdp</title>
    <link rel="stylesheet" href="css/login.css" />
</head>
<body>
<form id="mdf" method="POST" action="changemdp.php">
						<p class="login-password">
				<label for="pass">Nouveau mot de passe</label>
				<input name="pass" id="user_pass" class="input" type="password" required="required"/>
			</p>
			<p class="login-password">
				<label for="2pass">conffirmer mot de passe</label>
				<input name="2pass" id="user_pass" class="input" type="password" required="required"/>
			</p>
			    <button id="but" type="submit" name="valid">envoyer</button>

</body>
</html>
