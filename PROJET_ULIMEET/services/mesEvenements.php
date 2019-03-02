<?php

session_start();

if (!isset($_SESSION['ident'])){  
return;
}

require_once('lib/initDataLayer.php');
$login=$_SESSION['ident']->pseudo;
$ev=$data->getMesEvents($login);
if ($ev){
$tohtml=$data->mesEventsToHtml($ev);
return;
}else{
$noevent=true;
return;
}
?>
