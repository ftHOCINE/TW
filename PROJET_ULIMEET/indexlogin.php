<?php
spl_autoload_register(function ($className) {
     require_once("lib/{$className}.class.php");
 });
require('services/login.php');
require('views/pageProfil.php');
?>
