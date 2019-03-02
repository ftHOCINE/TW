<?php
spl_autoload_register(function ($className) {
     require_once("lib/{$className}.class.php");
 });
require_once('lib/initDataLayer.php');
$tab=$data->getEvents();
if($tab){
$tabHtml=$data->EventsToHtml($tab);
}
session_start();
require("views/pageAcceuil.php");
?>
