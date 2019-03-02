<?php
/**
Classe gérant les paramètres d'identification.
 - login : optionnel, chaîne vide par défaut
 - password : obligatoire si login n'est pas vide
*/
class ArgSetAuthent extends AbstractArgumentSet{

  protected function definitions() {
     $this->defineString('login');
     if($this->login != ''){
       $this->defineNonEmptyString('password');
     }
  }

}
?>
