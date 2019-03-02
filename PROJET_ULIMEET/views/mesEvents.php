
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>Evenement</title>
    <link rel="stylesheet" type="text/css" href="css/style_authent.css" />
</head>
<body>
	
<header>
<center>
<h1 id="i">MES EVENEMENT</h1>
</center>
</header>
<div id="bar">
<ul id="nav"><!--
	--><li><a href="index.php">Accueil</a></li><!--
	--><li><a href="indexlogin.php">Profil</a></li><!--
	--><li><a href="#">Abonnements</a></li><!--
        --><li><a href="creeEvent.php">Cree Evenement</a></li><!--
	--><li><a href="tologout.php">se deconnecter</a></li>
</ul>
</div>
<?php

if($noevent){
echo"<center>";
echo"<p> vous avez aucun evenement </p>";
echo"</center>";
}
else{
echo"<div id=\"tab\">";
echo"$tohtml";
echo"</div>";
}

?>
<div id="sup">
<form method="post" action="supprimerEv.php">
<label for='id'>-*- pour supprimer un evenement entrer l'id :</label>
<input type="text" name="id" required="required"/>

      <button id="bt" type="submit" name="valid" value="envoyer">Submit</button> </form>
</div>
</body>
</html
