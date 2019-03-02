<?php
spl_autoload_register(function ($className) {
     require_once("lib/{$className}.class.php");
 });
session_start();
if(isset($_POST['pass']) && isset($_POST['2pass']) && isset($_SESSION['pseudo'])){
$re=$_POST['pass'];
$re2=$_POST['2pass'];
$log=$_SESSION['pseudo'];
if ($re==$re2){
  require_once('lib/initDataLayer.php');
  $ch = $data->changemdp($re,$log);
if($ch){
$var=1;
session_destroy();
require('mdpchanger.php');
return;
exit();
}else{
 $var=2;
require('mdpchanger.php');
}}
else{
 $var=3;
require('mdpchanger.php');
}
}
?>
