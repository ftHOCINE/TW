<?php
spl_autoload_register(function ($className) {
     require_once("lib/{$className}.class.php");
 });
require('services/login.php');

//création des différents attribut nécessaire à l'upload
$login = $_SESSION['ident']->pseudo;
$text=$_POST['message'];

require_once('lib/db_parms.php');
require_once('lib/DataLayer.class.php');
$data=new Datalayer();
$success = $data->storedescri($text,$login);
if($success){
return;
}
else{
  echo json_encode(['status'=>$login]);
  echo json_encode(['status'=>'error', 'message'=>'Échec de l\'upload']);
}
