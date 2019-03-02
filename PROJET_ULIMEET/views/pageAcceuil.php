
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <meta charset="UTF-8"/>
    <title>home</title>
    <link rel="stylesheet" href="css/acceuil.css" />
</head>
<body>
<div id="acc">
<h1>Accueil</h1>
</div>
<div id="barre">
<?php
if(isset($_SESSION['ident'])){
echo"<ul>";
echo"<li><a  href=\"creeEvent.php\" title=\"Créer un évenement\">Créer un évenement<IMG src=\"css/img/ev.png\" width=\"60\" height=\"60\" alt=\"i \"/></a></li>
<li><a  href=\"mesEv.php\" title=\"mes évenements\">mes évenements<IMG src=\"css/img/even.png\" width=\"60\" height=\"60\" alt=\"i \"/></a></li>
<li><a  href=\"#\" title=\"mes abonnements\">mes abonnements<IMG src=\"css/img/abnn.png\" width=\"60\" height=\"60\" alt=\"i \"/></a></li>
<li><a  href=\"indexlogin.php\" title=\"mon profil\">mon profil<IMG src=\"css/img/pr.png\" width=\"60\" height=\"60\" alt=\"i \"/></a></li>
<li><a  href=\"tologout.php\" title=\"déconnexion\">déconnexion<IMG src=\"css/img/out.png\" width=\"60\" height=\"60\" alt=\"i \"/></a></li>
</ul>";
}else{
echo"<div id=\"connect\" class=\"rotating\">
	
	 <div id='left'><a  href=\"indexlogin.php\" title=\"se connecté\"><IMG src=\"css/img/connect.png\" width=\"70\" height=\"70\" alt=\"i \"/>Connection </a></div>
	 <div id='center'><a ><IMG src=\"css/img/uli.jpg\" height=\"80\" alt=\"i \"/></a></div>
	 <div id='right'><a  href=\"registrer.php\" title=\"ins\">Inscription  <IMG src=\"css/img/inscription.png\" width=\"60\" height=\"60\" alt=\"i \"/></a></div>

</div>";
}
?>
</div>
<div id="menu">
<div id="ev">
<fieldset>
	<legend> recherche d'évènements </legend>
		<form id="rechinfo" method="POST" action="chercheEv.php">
		<p class="mot" >categorie
		
		<select name="categorie" >
        <option  selected="selected">choisir</option>
        <option value="sport" >sport</option>
        <option value="loisir">loisir</option>
        <option value="culture">culture</option>
        <option value="sortie">sortie</option>
		</select>
			</p>
			
			<p class="mot">
				<label for="mot">mot-clé </label>
				<input name="mot" id="mot" class="input"  type="text"/>
			</p>

			<p class="mot" >triées par
		
		<select name="triées par" >
        <option value="quand" selected="date de l'évènement">date de l'évènement</option>
       
		</select>
			</p>
			
				<center>
			    <button id="but" type="submit" name="valid">valider</button>
				</center>
		</form>
		</fieldset>
		<!--		<div id="his">
			<p>partie2</p>
			</div>-->
				</div>
		
		
		<div id="mes_ab">
			<?php
                           echo"$tabHtml";
           ?>




</div></div>
</body>
</html>
