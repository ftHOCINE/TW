
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>Authentifiez-vous</title>
    <link rel="stylesheet" href="css/login.css" />
</head>
<body>
	
<div id="login">
<h1>INSCRIPTION</h1>
<form  method="POST" action="">
			
			<p class="login-username">
				<label for="login">Pseudo </label>
				<input name="login" id="user_login" class="input"  type="text"/>
			</p>
			<p class="login-password">
				<label for="password">Mot de passe</label>
				<input name="password" id="user_pass" class="input" type="password" required="required"/>
			</p>
			<p class="login-password">
				<label for="2password">confirmez votre Mot de passe</label>
				<input name="2password" id="user_pass" class="input" type="password" required="required"/>
			</p>
			<p>Question secrete</p>
			<select name="Q_S">
				  <option selected>choisir--</option>
				  <option value="l'animal preferer">l'animal preferer</option>
                  <option value="la personne aimer le plus">la personne aimer le plus</option>
			</select>
			<p class="login-username">
				<label for="rep_q">reponce : </label>
				<input name="rep_q" id="user_login" class="input"  type="text"/>
			</p>			
				<center>
			    <button id="but" type="submit" name="valid">envoyer</button>
				</center>
		</form>

</p>
</div>
</body>
</html>
