<?php
spl_autoload_register(function ($className) {
     require_once("lib/{$className}.class.php");
 });
 require("services/mesEvenements.php");
 require("views/mesEvents.php");
 ?>
