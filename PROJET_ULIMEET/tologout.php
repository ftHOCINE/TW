<?php
spl_autoload_register(function ($className) {
     include("lib/{$className}.class.php");
 });
require('services/logout.php');
unset($_SESSION['ident']);
session_destroy();
require('indexlogin.php');
?>
