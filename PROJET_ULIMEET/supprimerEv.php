<?php
spl_autoload_register(function ($className) {
     require_once("lib/{$className}.class.php");
 });
session_start();
require_once('lib/initDataLayer.php');
if($data->supprimerEv($_POST['id'])){
$log=$_SESSION['ident']->pseudo;
$data->decremonterNbEV($log);
require("mesEv.php");
}else{
echo"mauvais id";

require("mesEv.php");

}
?>
