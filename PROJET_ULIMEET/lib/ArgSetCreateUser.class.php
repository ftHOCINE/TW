<?php
/**
Classe gérant des paramètres d'identification pour un nouveau utilisateur.
 - login : obligatoire, chaîne non vide
 - password : obligatoire, chaîne non vide
 - nom : obligatoire, chaîne non vide
 - prenom : obligatoire, chaîne non vide
*/
class ArgSetCreateUser extends AbstractArgumentSet{

  protected function definitions() {
     $this->defineNonEmptyString('login');
     $this->defineNonEmptyString('password');
     $this->defineNonEmptyString('Q_S');
     $this->defineNonEmptyString('rep_q');
  }
  
 public function isValid2(){
    $p1=$this->password;
    $p2=$this->defineNonEmptyString('2password');
    if($p1!=$p2){
    return false;
    }
    return True;
    }

}
?>
