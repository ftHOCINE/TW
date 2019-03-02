<?php
  /*
    Utilise le contenu de $_SESSION (en particulier $_SESSION['ident'])
  */
  if ( ! isset($_SESSION['ident'])){  // si la page était protégée, on ne devrait même pas faire ce test
      require('views/pageErreur.php');
      exit();
  }
  $personne = $_SESSION['ident'];
  //la ligne d'appel du service getAvatar.php
  require("lib/initDataLayer.php");
  $ava=$data->getAvatar($personne->pseudo);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="css/style_authent.css" />
    <?php
    ?>
  </head>
<body>
<header>


<?php
echo "<img class=\"avatar\" src=\"{$ava['image']}\" />";
echo"<div id=\"ps\">";
echo"<h3>";
echo "{$personne->pseudo}";
echo"</h3>";
echo"</div>";
?>
<div id="pf">
<h1>
Profil
</h1>
</div>
</header>

<div id="bar">
<ul id="nav"><!--
	--><li><a href="index.php">Accueil</a></li><!--
	--><li><a href="mesEv.php">Evenements</a></li><!--
	--><li><a href="#">Abonnements</a></li><!--
	--><li><a href="tologout.php">se deconnecter</a></li>
</ul>
</div>
<div class="cn" id="content1">
 <p>
 Modifier ma photo de profil : 
 </p>
    <form name="upload_image" action="uplAvatar.php" method = "post" enctype="multipart/form-data">
   <fieldset>
      <legend>Nouvel avatar</legend>
      <input type="file" name="image" required="required"/>
   </fieldset>
      <button id="bt" type="submit" name="valid" value="envoyer">Changer</button>  </form>
</div>
<div class="cn" id="content2">
 <p>
 Modifier ma description : 
 </p>
    <form name="upload_pf" action="uplProfil.php" method = "post" enctype="multipart/form-data">
   <fieldset>
      <legend>description</legend>
      <label for="form-message"></label>
      <textarea id="form-message" name="message" required="required"></textarea>
   </fieldset>
      <button id="bt" type="submit" name="valid" value="envoyer">Submit</button>  </form>
</div>
<div class="cn" id="content3">

   <fieldset id="fl">
      <legend>Ma description : </legend>
      <?php
  $personne = $_SESSION['ident'];
  
  require("lib/initDataLayer.php");
$text=$data->getDes($personne->pseudo);
echo"{$text['description']}";
?>
   </fieldset>
</div>
<footer>
<div id="bar2">
<?php
  $personne = $_SESSION['ident'];
  
  require("lib/initDataLayer.php");
$info=$data->getInfo($personne->pseudo);

echo"<ul id=\"nav2\"><!--
	--><li><p>nb Evenements : {$info['nbevenement']}</p></li><!--
	--><li><p>nb participants : {$info['nbparticipants']}</p></li><!--
	--><li><p>nb participations : {$info['nbparticipations']}</p></li>";
?>
</ul>
</div>
</body>
</html>
