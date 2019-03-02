
<?php

session_start();

if (isset($_SESSION['ident'])){  
return;
}
$args = new ArgSetCreateUser();
$val=$args->isValid2();
if($args->isValid() && $val){
  require_once('lib/initDataLayer.php');
  $add_user = $data->createUser($args->login,$args->password,$args->Q_S,$args->rep_q);
  $l=$data->storeAvatar('uploads/avatar_def.png',$args->login);
  if($add_user && $l){
	$_SESSION['ident']=$data->authentifier($args->login,$args->password); 
    return;
  }
  else{
    echo json_encode(['status'=>'error', 'message'=>'le pseudo existe deja']);
  }
}
if (!$val){
    echo json_encode(['status'=>'error', 'message'=>'confirmez bien votre mot de passe']);
  }

require("views/createuserForm.php");
exit();



?>
