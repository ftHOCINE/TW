
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>cree evenement</title>
    <link rel="stylesheet" href="css/login.css" />
</head>
<body>
	
<div id="login">
<h1>EVENEMENT</h1>
<form  method="POST" action="">
			

					<p >
				<label for="titre">Titre </label>
				<input name="titre"  class="input"  type="text"/>
			</p>
			<p>
				<label for="descr">Description</label>
                         </p>
      <textarea id="form-desc" name="descr" ></textarea>
			
      						<p >
				<label for="ou">Lieux </label>
				<input name="ou" id="user_login" class="input"  type="text"/>
			</p>
      						<p >
				<label for="quand">Date </label>
				<input name="quand"  class="input"  type="date"/>
			</p>
			<p>categorie</p>
			<select name="categorie">
				  <option selected>choisir--</option>
				  <option value="sport">Sport</option>
				  <option value="loisirs">Loisirs</option>	
				  <option value="culture">Culture</option>
				  <option value="sorties">Sorties</option>
			</select>			
				<center>
			    <button id="but" type="submit" name="valid">envoyer</button>
				</center>
		</form>

</p>
</div>
</body>
</html>
