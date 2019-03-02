
<?php

session_start();

if (!isset($_SESSION['ident'])){ 
return;
}
$args = new ArgSetCreateEvent();
if($args->isValid()){
  $id=rand(1,1000000);
  $des=$_POST['descr'];
  $login=$_SESSION['ident']->pseudo;
  $date= date('d / m / y');
  require_once('lib/initDataLayer.php');

  $add_Event = $data->createEvent($login,$id,$args->titre,$args->categorie,$des,$args->ou,$args->quand,$date);
  if($add_Event){
    return;
  }
  else{
    echo json_encode(['status'=>'error', 'message'=>'erreur de creation ']);
  }
}else{
echo "veuillez remplir tout les champs svp :";
require("views/createEventForm.php");
exit();
}


?>
