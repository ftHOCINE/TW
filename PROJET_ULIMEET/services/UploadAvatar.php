<?php
spl_autoload_register(function ($className) {
     require_once("lib/{$className}.class.php");
 });
require('services/login.php');
//création des différents attribut nécessaire à l'upload
$login = $_SESSION['ident']->pseudo;
$tmp_name = $_FILES['image']['tmp_name'];
$name= $_FILES['image']['name'];
$destFile ="uploads/$name";

if(move_uploaded_file ($_FILES['image']['tmp_name'],$destFile)){

//upload
require_once('lib/db_parms.php');
require_once('lib/DataLayer.class.php');
$data=new Datalayer();
$img="uploads/$name";
$success = $data->storeAvatar($img,$login);
if($success){
return;
}
else{
  echo json_encode(['status'=>$login]);
  echo json_encode(['status'=>'error', 'message'=>'Échec de l\'upload']);
}
}else{
return;}


?>
