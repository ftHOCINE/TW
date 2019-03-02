

<?php

spl_autoload_register(function ($className) {
     require_once("lib/{$className}.class.php");
 });
session_start();
if(isset($_POST['rep']) && isset($_SESSION['pseudo']) ){
$re=$_POST['rep'];
$log=$_SESSION['pseudo'];
 
require_once('lib/initDataLayer.php');
  $rep = $data->getQs($log);


if($rep['reponce'] && crypt($re,$rep['reponce'])==$rep['reponce']){
require('views/modifimdp.php');
return;
}else{
    echo json_encode(['status'=>'error', 'message'=>'mauvaise reponce']);
    unset($_SESSION['pseudo']);
    require("modifiermdp.php");
    }

}
?>
