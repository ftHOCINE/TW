<?php
spl_autoload_register(function ($className) {
     require_once("lib/{$className}.class.php");
 });
$mot=$_POST['mot'];
$cat=$_POST['categorie'];
require_once('lib/initDataLayer.php');
$tab=$data->recherche($mot,$cat);
if($tab){
$html=$data->AllEventsToHtml($tab);
}else{
$noevent=true;
}
require("views/evenements.php");
