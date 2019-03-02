<?php
/**
Classe destiné à recevoir une instance de la classe PDO
Elle posséde des méthodes afin de faire une requete SQL
*/
class DataLayer {

  //déclaration de l'attribut $connexion
  private $connexion;

  public function __construct(){
    //initialiser la connexion

    $this->connexion = new PDO(
        DB_DSN, DB_USER, DB_PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
      );
  }

  /*
   * tente d'authentifier un utilisateur, renvoie une Identite ou null
   * paramètres:
   *            $login : le login d'un utilisateur
   *            $password : son mot de passe (empreinte blowfish)
   *
   * résultat : Identite, un utilisateur
   *            ou null si l'authentification à échouer
   */
  public function authentifier($login,$password){
    $SQL = <<<EOD
    SELECT
    pseudo, password
    FROM
    users
    WHERE pseudo = :login
EOD;
    //prepare la requete
    $stmt = $this->connexion->prepare($SQL);
    $stmt->bindValue(':login',$login);
    //l'execute
    $stmt->execute();
    //initialise la variable de retour
    $res = $stmt->fetch();
    //nous devons avoir un utilisateur
    if($res && crypt($password,$res['password']) == $res['password']){
      return new Identite($res['pseudo']);
    }
    else{
      return null;
    }
  }

  /*
   * Enregistre un utilisateur $login
   * paramètres:
   *            $login : le login de l'utilisateur
   *            $password : son mot de passe (empreinte blowfish)
   *            $Q_s: question secrete
   *            $rep : reponce a la question secrete
   *
   * résultat : booléen indiquant si l'opération s'est bien passée
   */
  public function createUser($login,$password,$Q_s,$rep){
    $SQL = <<<EOD
    INSERT INTO
    users(pseudo,password,secrete,reponce)
    values (:pseudo,:password,:Q_S,:rep);
EOD;
    //prepare la requete
    $stmt = $this->connexion->prepare($SQL);
    $stmt->bindValue(':pseudo',$login);	
    $stmt->bindValue(':Q_S',$Q_s);
    $rep_q= password_hash($rep,CRYPT_BLOWFISH);
    $stmt->bindValue(':rep',$rep_q);
    //on crée l'empreinte
    $empreinte = password_hash($password,CRYPT_BLOWFISH);
    $stmt->bindValue(':password',$empreinte);
    $SQ = <<<EOD
    INSERT INTO
    profils(pseudo)
    values (:pseudo);
EOD;
    $st = $this->connexion->prepare($SQ);
    $st->bindValue(':pseudo',$login);	
    //tente de l'executer
    try{
      $stmt->execute();
      $st->execute();
      return $stmt->rowCount() == 1 &&  $st->rowCount() == 1 ;
    }
    catch (PDOException $e){
      return false;
    }
  }

  /*
   * Enregistre un avatar pour l'utilisateur $login
   * paramètre $imageSpec : un tableau associatif contenant deux clés :
   *                        'data' : flux ouvert en lecture sur les données à stocker
   *                        'mimetype' : type MIME (chaîne)
   * résultat : booléen indiquant si l'opération s'est bien passée
   */
  public function storeAvatar($imageSpec, $login){
    $SQL = <<<EOD
    UPDATE
    profils
    SET
    image = :image
    WHERE pseudo = :login;
EOD;
    //prepare la requete
    $stmt = $this->connexion->prepare($SQL);
    $stmt->bindValue(':image',$imageSpec);
    $stmt->bindValue(':login',$login);

    //tente de l'executer
    try{
      $stmt->execute();
      return $stmt->rowCount() == 1;
    }
    catch (PDOException $e){
      return false;
    }
  }

  /*
   * Récupère l'avatar de l'utilisateur $login
   * résultat : un tableau associatif contenant deux clés :
   *            'data' : flux ouvert en lecture sur les données à stocker
   *            'mimetype' : type MIME (chaîne)
   * ou FALSE en cas d'échec
   */
  public function getAvatar($login){
    $SQL = <<<EOD
    SELECT
    image
    FROM
    profils
    WHERE pseudo = :login
EOD;
    //prepare la requete
    $stmt = $this->connexion->prepare($SQL);
    $stmt->bindValue(':login',$login);
    try{
      //l'execute
      $stmt->execute();
      $result = $stmt->fetch();
      if($result){
        return $result;
      }
      else{
        return false;
      }
    }
    catch (PDOException $e){
      return false;
    }
  }

  /*
   * Récupère les info de l'utilisateur $login
   * résultat : un tableau associatif contenant 3 clés :
   *            'nbEvenement' :  nombres d'evenements
   *            'nbParticipants' : nombres de participants
   *            'nbParticipations' : nombres de participations
   * ou FALSE en cas d'échec
   */
  public function getInfo($login){
    $SQL = <<<EOD
    SELECT
    nbEvenement , nbParticipants ,nbParticipations
    FROM
    profils
    WHERE pseudo = :login
EOD;
    //prepare la requete
    $stmt = $this->connexion->prepare($SQL);
    $stmt->bindValue(':login',$login);
    try{
      //l'execute
      $stmt->execute();
      $result = $stmt->fetch();
      if($result){
        return $result;
      }
      else{
        return false;
      }
    }
    catch (PDOException $e){
      return false;
    }
  }
  /*
   * Récupère la description du de l'utilisateur $login
   * résultat : un tableau associatif contenant 1 cles :
   * 'description': la description 
   * ou FALSE en cas d'échec
   */
  public function getDes($login){
    $SQL = <<<EOD
    SELECT
    description
    FROM
    profils
    WHERE pseudo = :login
EOD;
    //prepare la requete
    $stmt = $this->connexion->prepare($SQL);
    $stmt->bindValue(':login',$login);
    try{
      //l'execute
      $stmt->execute();
      $result = $stmt->fetch();
      if($result){
        return $result;
      }
      else{
        return false;
      }
    }
    catch (PDOException $e){
      return false;
    }
  }
  /*
   * Enregistre un avatar pour l'utilisateur $login
   * paramètre $descri : description du l'utilisateur
   * résultat : booléen indiquant si l'opération s'est bien passée
   */
  public function storedescri($descri, $login){
    $SQL = <<<EOD
    UPDATE
    profils
    SET
    description = :descr
    WHERE pseudo = :login;
EOD;
    //prepare la requete
    $stmt = $this->connexion->prepare($SQL);
    $stmt->bindValue(':descr',$descri);
    $stmt->bindValue(':login',$login);

    //tente de l'executer
    try{
      $stmt->execute();
      return $stmt->rowCount() == 1;
    }
    catch (PDOException $e){
      return false;
    }
  }
   /*
   * Récupère la question secrete et sa reponce du de l'utilisateur $login
   * résultat : un tableau associatif contenant 2 cles :
   * 'secrete': la q.s
   *'reponce': la reponce 
   * ou FALSE en cas d'échec
   */
  public function getQs($login){
    $SQL = <<<EOD
    SELECT
    secrete,reponce
    FROM
    users
    WHERE pseudo = :login
EOD;
    //prepare la requete
    $stmt = $this->connexion->prepare($SQL);
    $stmt->bindValue(':login',$login);
    try{
      //l'execute
      $stmt->execute();
      $result = $stmt->fetch();
      if($result){
        return $result;
      }
      else{
        return false;
      }
    }
    catch (PDOException $e){
      return false;
    }
  }
  public function changemdp($mdp, $login){
    $SQL = <<<EOD
    UPDATE
    users
    SET
    password = :mdp
    WHERE pseudo = :login;
EOD;
    //prepare la requete
    $stmt = $this->connexion->prepare($SQL);
    $new_mdp=password_hash($mdp,CRYPT_BLOWFISH);
    $stmt->bindValue(':mdp',$new_mdp);
    $stmt->bindValue(':login',$login);

    //tente de l'executer
    try{
      $stmt->execute();
      return $stmt->rowCount() == 1;
    }
    catch (PDOException $e){
      return false;
    }
  }
  /*
   * Enregistre un avatar pour l'utilisateur $login
   * paramètres:
   *            $auteur : le login de l'utilisateur
   *            $id : id d'evenement
   *            $titre : titre d'evenement
   *            $cat : categorie d'evenement
   *            $descr : description du l'evenement
   *            $ou : lieux de l'evenement
   *            $quand : date de l'evenement 
   *
   * résultat : booléen indiquant si l'opération s'est bien passée
   */
  public function createEvent($auteur,$id,$titre,$cat,$descr,$ou,$quand,$datecreate){
    $SQL = <<<EOD
    INSERT INTO
    events(auteur,id,titre,descr,ou,categorie,quand,datecreation)
    values (:auteur,:id,:titre,:descr,:ou,:categorie,:quand,:dcreat);
EOD;
    //prepare la requete
    $stmt = $this->connexion->prepare($SQL);	
    $stmt->bindValue(':id',$id);
    $stmt->bindValue(':auteur',$auteur);
    $stmt->bindValue(':titre',$titre);
    $stmt->bindValue(':descr',$descr);
    $stmt->bindValue(':categorie',$cat);
    $stmt->bindValue(':ou',$ou);
    $stmt->bindValue(':quand',$quand);
    $stmt->bindValue(':dcreat',$datecreate);
    $SQ = <<<EOD
    UPDATE
    profils
    SET
    nbevenement = nbevenement+1
    WHERE pseudo = :login;
EOD;
    $st = $this->connexion->prepare($SQ);
    $st->bindValue(':login',$auteur);	
    //tente de l'executer
    try{
      $stmt->execute();
      return $stmt->rowCount() == 1 ;
    }
    catch (PDOException $e){
	  echo"fuuucckkk";	
      return false;
    }
  }
   /*
   * Récupère les evenements
   * ou FALSE en cas d'échec
   */
  public function getMesEvents($login){
    $SQL = <<<EOD
    SELECT
    *
    FROM
    events
    WHERE auteur = :login
    order by quand ;
EOD;
    //prepare la requete
    $stmt = $this->connexion->prepare($SQL);
    $stmt->bindValue(':login',$login);
    try{
      //l'execute
      $stmt->execute();
      $res=[];
      while($result = $stmt->fetch())
         $res[]=$result;
      if(count($res)!=0){
         return $res;
      }
      else{
        return false;
      }
    }
    catch (PDOException $e){
      return false;
    }
  }
/**
*resultat html du tableau d'info d'evenement
*/
  public function mesEventsToHtml($table){
	$res="<table><thead>";
	$res.="<tr><th>Titres</th><th>Id</th><th>Date</th><th>categorie</th></tr></thead>";
        foreach($table as $tab){
        $res.="<tr><td>".$tab['titre']."</td>";
        $res.="<td>".$tab['id']."</td>";
        $res.="<td>".$tab['quand']."</td>";
        $res.="<td>".$tab['categorie']."</td></tr>";
        }
        $res.="</table>";
        return $res; 
        }
/**
*supprime l 'evenement d'un id 
*/
  public function supprimerEv($id){
    $SQL = <<<EOD
    DELETE
    FROM
    events
    WHERE id = :id
EOD;
    //prepare la requete
    $stmt = $this->connexion->prepare($SQL);
    $stmt->bindValue(':id',$id);
    try{
      //l'execute
      $stmt->execute();
    }
    catch (PDOException $e){
      return false;
    }
   return true;
  }
/**
* decremontre le nombre d'evenements
*/
  public function decremonterNbEV($login){
    $SQ = <<<EOD
    UPDATE
    profils
    SET
    nbevenement = nbevenement-1
    WHERE pseudo = :login;
EOD;
    $st = $this->connexion->prepare($SQ);
    $st->bindValue(':login',$login);	
    //tente de l'executer
    try{
      //l'execute
      $st->execute();
    }
    catch (PDOException $e){
      return false;
    }
   return true;
  }
/**
*recuperer les evenements
*/
    public function getEvents(){
    $SQL = <<<EOD
    SELECT
    *
    FROM
    events
    order by quand ;
EOD;
    //prepare la requete
    $stmt = $this->connexion->prepare($SQL);
    try{
      //l'execute
      $stmt->execute();
      $res=[];
      while($result = $stmt->fetch())
         $res[]=$result;
      if(count($res)!=0){
         return $res;
      }
      else{
        return false;
      }
    }
    catch (PDOException $e){
      return false;
    }
  }
/**
*resultat html du tableau d'info d'evenement
*/
 public function EventsToHtml($table){
	$res="<table><thead>";
	$res.="<tr><th>Titres</th><th>Lieu</th><th>Date</th><th>categorie</th></tr></thead>";
        $i=0;
        foreach($table as $tab){
        $res.="<tr><td>".$tab['titre']."</td>";
        $res.="<td>".$tab['ou']."</td>";
        $res.="<td>".$tab['quand']."</td>";
        $res.="<td>".$tab['categorie']."</td></tr>";
        $i++;
        if ($i==6)
        break; 
        }
        $res.="</table>";
        return $res; 
        }
/**
*rechercher les evenements
*/
    public function recherche($mot,$categorie){
    $SQL = <<<EOD
    SELECT
    *
    FROM
    events
    WHERE auteur=:mot OR titre=:mot OR ou=:mot OR categorie=:cat
    order by quand ;
EOD;
    //prepare la requete
    $stmt = $this->connexion->prepare($SQL);
    $stmt->bindValue(':mot',$mot); 
    $stmt->bindValue(':cat',$categorie); 
    try{
      //l'execute
      $stmt->execute();
      $res=[];
      while($result = $stmt->fetch())
         $res[]=$result;
      if(count($res)!=0){
         return $res;
      }
      else{
        return false;
      }
    }
    catch (PDOException $e){
      return false;
    }
  }
/**
*resultat html du tableau d'info d'evenement
*/
  public function AllEventsToHtml($table){
	$res="<table><thead>";
	$res.="<tr><th>Titres</th><th>Lieu</th><th>Date</th><th>categorie</th></tr></thead>";
        foreach($table as $tab){
        $res.="<tr><td>".$tab['titre']."</td>";
        $res.="<td>".$tab['ou']."</td>";
        $res.="<td>".$tab['quand']."</td>";
        $res.="<td>".$tab['categorie']."</td></tr>"; 
        }
        $res.="</table>";
        return $res; 
        }  
}
?>
