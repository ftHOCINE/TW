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
<h1 id="i">EVENEMENT</h1>
</center>
</header>
<div id="bar">
<ul id="nav"><!--
	--><li><a href="index.php">Accueil</a></li><!--
	--><li><a href="indexlogin.php">se connecter</a></li><!--
	--><li><a href="registrer">inscription</a>
</ul>
</div>
<?php

if($noevent){
echo"<center>";
echo"<p> aucun evenement </p>";
echo"</center>";
}
else{
echo"<div id=\"tab\">";
echo"$html";
echo"</div>";
}

?>

</body>
</html
