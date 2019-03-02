<?php

class ArgSetCreateEvent extends AbstractArgumentSet{

  protected function definitions() {
     $this->defineNonEmptyString('titre');
     $this->defineNonEmptyString('categorie');
     $this->defineNonEmptyString('ou');
     $this->defineNonEmptyString('quand');
}
}
  ?>
