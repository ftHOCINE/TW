<?php

session_start();

if (isset($_SESSION['ident']))  
  return;

$args = new ArgSetAuthent();
if($args->isValid() && $args->login != ""){
  require_once('lib/initDataLayer.php');
  $identite = $data->authentifier($args->login,$args->password);
  if($identite){
    $_SESSION['ident'] = $identite;
    unset($_SESSION['echec']);
    return;
  }
  else{
    $_SESSION['echec'] = true;
  }
}

require('views/pageLogin.php');
exit();


?>



	
