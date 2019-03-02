  <?php 
spl_autoload_register(function ($className) {
     require_once("lib/{$className}.class.php");
 });
if (isset($_POST['pseudo'])){
session_start();
$_SESSION['pseudo']=$_POST['pseudo'];
$log=$_POST['pseudo'];
  require_once('lib/initDataLayer.php');
  $rep = $data->getQs($log);
if($rep){
 require('views/pageMdp.php');
 return;

}else{
$var=4;
require('mdpchanger.php');
exit;
}
}
?>
