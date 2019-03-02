<?php
spl_autoload_register(function ($className) {
     require_once("lib/{$className}.class.php");
 });
session_start();
require('views/mdfmdp.php');
require('recumdp.php');
require('mmdp.php');
require('changemdp.php');

?>
