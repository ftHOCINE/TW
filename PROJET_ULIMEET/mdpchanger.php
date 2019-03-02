
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>se connecter</title>
    <link rel="stylesheet" href="css/login.css" />
</head>
<body>
<?php
if($var==1){
echo"<p>Bravo!! votre message a bien etait reinitialiser :</p>";
echo"<a href=\"indexlogin.php\" title=\"connect\">se connecter</a>";
}
if($var==2){
echo"<p>Echec de reinitialisation du mot de passe :</p> ";
echo"<a href=\"modifiermdp.php\" title=\"connect\">reesayer</a>";
}
if($var==3){
echo"<p>veuillez bien confirmez votre mot de passe :</p> ";
echo"<a href=\"modifiermdp.php\" title=\"connect\">reesayer</a>";
}
if($var==4){
echo"<p>le pseudo n'existe pas </p> ";
echo"<a href=\"modifiermdp.php\" title=\"connect\">reesayer</a>";
} 
?>
</body>
</html>

