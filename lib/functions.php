<!-- ====================================================================================================================================================== -->
                                                                <!-- INSCRITPTION -->
<?php
  function signIn($login, $email, $mdp, $confirm, $bdd)
  {
    if(empty($login) OR empty($email) OR empty($mdp) OR empty($confirm))
    {
      $error = "Veuillez remplir tous les champs du formulaire";
      return $error;
    }
    else
    {
      if($mdp != $confirm)
      {
        $error = "Les mots de passe ne correspondent pas";
        return $error;
      }
      else
      {
        $req = $bdd->prepare("SELECT * FROM user WHERE login = :login");
        $req->bindValue('login', $login, PDO::PARAM_STR);
        $req->execute();
        $rep = $req->fetch();

        if($rep)
        {
          $error = "Ce login est déja utilisé";
          return $error;
        }
        else
        {
          $crypt = sha1($mdp);

          $req = $bdd->prepare("INSERT INTO user (id_u, login, email, mdp, lvl) VALUES (NULL, :login, :email, :mdp, 1)");
          $req->bindValue('login', $login, PDO::PARAM_STR);
          $req->bindValue('email', $email, PDO::PARAM_STR);
          $req->bindValue('mdp', $mdp, PDO::PARAM_STR);
          $req->execute();

          $rep = $req->fetch();

          $_SESSION['id'] = $bdd->lastInsertId();
          $_SESSION['login'] = $rep['login'];
          $_SESSION['email'] = $rep['email'];
          $_SESSION['lvl'] = $rep['lvl'];

          header("Location:index.php");
        }
      }
    }
  }
?>
<!-- ====================================================================================================================================================== -->
                                                          <!-- INSCRITPTION AVEC AVATAR -->
<?php
  function signinAvatar($login, $email, $mdp, $confirm, $avatar, $bdd)
  {
      if(empty($login) OR empty($email) OR empty($mdp) OR empty($confirm))
      {
        $error = "<div class =' alert alert-warning error col-lg-3'>Veuillez remplir tous les champs du formulaire</div>";
        return $error;
      }
      else
      {
        if($mdp != $confirm)
      {
          $error = "<div class ='alert alert-warning error col-lg-3'>Vos mots de passe ne correspondent pas</div>";
          return $error;
        }
        else
        {
          $req = $bdd->prepare("SELECT * FROM user WHERE login = :login");
          $req->bindValue('login', $login, PDO::PARAM_STR);
          $req->execute();

          $resultat = $req->fetch();

          if($resultat)
          {
            $error = "<div class ='alert alert-warning error col-lg-3'>Le login est déja utilisé</div>";
            return $error;
          }
          else
          {
            if(isset($avatar['file']) AND $avatar['file']['error'] == 0)
            {
              if ($avatar['file']['size'] <= 1000000)
              {
                $infosfichier = pathinfo($avatar['file']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                  $infosfichier = pathinfo($avatar['file']['name']);
                  $extension_upload = $infosfichier['extension'];
                  $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                  if (in_array($extension_upload, $extensions_autorisees))
                  {
                    move_uploaded_file($avatar['file']['tmp_name'], 'uploads/' . basename($avatar['file']['name']));

                    $avatar = 'uploads/'.basename($avatar['file']['name']);
                    $crypt = sha1($mdp);

                    $req = $bdd->prepare('INSERT INTO user (id_u, login, email, mdp, lvl, avatar) VALUES(NULL, :login, :email, :mdp, 1, :avatar)');
                    $req->bindValue('login', $login, PDO::PARAM_STR);
                    $req->bindValue('email', $email, PDO::PARAM_STR);
                    $req->bindValue('mdp', $mdp, PDO::PARAM_STR);
                    $req->bindValue('avatar', $avatar, PDO::PARAM_STR);
                    $req->execute();

                    $_SESSION['id'] = $bdd->lastInsertId();
                    $_SESSION['login'] = $login;
                    $_SESSION['avatar'] = $avatar;
                    $_SESSION['lvl'] = 1;
                    header("Location:index.php");

                    $message = "<div class ='alert alert-success error col-lg-3'> Vous êtes maintenant inscrit</div>";
                    return $message;
                  }
                  else
                  {
                    $error = "<div class ='alert alert-warning error col-lg-3'>Format incorrect</div>";
                    return $error;
                  }
                }
                else
                {
                  $error = "<div class ='alert alert-warning error col-lg-3'>Format incorrect</div>";
                  return $error;
                }
              }
              else
              {
                $error = "<div class ='alert alert-warning error col-lg-3'>Fichier trop volumineux</div>";
                return $error;
              }
            }
            else
            {
              $error = "<div class ='alert alert alert-warning error col-lg-3'>Veuillez sélectionnez un fichier</div>";
              return $error;
            }
          }
        }
      }
  }
?>

<!-- ====================================================================================================================================================== -->
                                                                <!-- CONNEXION -->
<?php
  function login($login, $mdp, $bdd)
  {
    if(empty($login) OR empty($mdp))
    {
      $error = "<div class =' alert alert-warning error col-lg-3'>Veuillez remplir tous les champs du formulaire.</div>";
      return $error;
    }
    else
    {
      $req = $bdd -> prepare("SELECT * FROM user WHERE login = :login AND mdp = :mdp");
      $req->execute(array(
        'login'=>$login,
        'mdp'=>sha1($mdp)
        ));
      $resultat = $req->fetch();

      if (!$resultat)
      {
        $error = "<div class =' alert alert-warning error col-lg-3'>Mauvais identifiant ou mot de passe !</div>";
        return $error;
      }
      else
      {
        $_SESSION['id'] = $resultat['id_u'];
        $_SESSION['login'] = $resultat['login'];
        $_SESSION['lvl'] = $resultat['lvl'];

        if(isset($resultat['avatar']))
          $_SESSION['avatar'] = $resultat['avatar'];

        header("Location:index.php");
      }
    }
  }
?>

<!-- ====================================================================================================================================================== -->
                                                            <!-- CONNEXION MUTLTIPLE -->
<?php
  function multipleLogin($email, $mdp, $admin, $bdd)
  {
    if(empty($email) OR empty($mdp))
    {
      $error = "Veuillez remplir tous les champs du formulaire";
      return $error;
    }
    else
    {
      $crypt = sha1($mdp);
      if($admin == 0)
      {
        $req = $bdd->prepare("SELECT * FROM eleve WHERE email = :email AND mdp = :mdp");
      }
      elseif($admin == 2)
      {
        $req = $bdd->prepare("SELECT * FROM prof WHERE email = :email AND mdp = :mdp AND lvl = 2");
      }
      elseif($admin == 1)
      {
        $req = $bdd->prepare("SELECT * FROM prof WHERE email = :email AND mdp = :mdp AND lvl = 1");
      }
      else
      {
        $error = "Wrong admin valor";
        return $error;
      }

      $req->bindValue('email', $email, PDO::PARAM_STR);
      $req->bindValue('mdp', $crypt, PDO::PARAM_STR);
      $req->execute();

      $rep = $req->fetch();

      if($rep)
      {
        $_SESSION['id'] = $rep['id_p'];
        $_SESSION['email'] = $rep['email'];
        $_SESSION['lvl'] = $rep['lvl'];
        header("Location:index.php");
      }
      else
      {
        $error = "Mauvais identifiants";
        return $error;
      }
    }
  }
?>
<!-- ====================================================================================================================================================== -->
                                                              <!-- MODIFIER EMAIL -->
<?php
  function updateEmail($email, $id_u, $bdd)
  {
    if(empty($email))
    {
      $error = "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Veuillez saisir une adresse email</div>";
      return $error;
    }
    else
    {
      $req = $bdd->prepare("UPDATE user set email = :email WHERE id_u = :id_u");
      $req->bindValue('email', $email, PDO::PARAM_STR);
      $req->bindValue('id_u', $id_u, PDO::PARAM_INT);
      $req->execute();

      $message = "<div class='alert alert-success col-lg-offset-4 col-lg-3'> Email modifié ! </div>";
      return $message;
    }
  }
?>

<!-- ====================================================================================================================================================== -->
                                                          <!-- MODIFIER MOT DE PASSE -->
<?php
  function updateMdp($oldmdp, $mdp, $confirm, $id, $bdd)
  {
    $req = $bdd->prepare("SELECT mdp FROM user WHERE id_u = :id_u");
    $req->bindValue('id_u', $id, PDO::PARAM_INT);
    $req->execute();
    $reponse = $req->fetch();

    $current_mdp = $reponse['mdp'];

    if(empty($oldmdp) OR empty($mdp) OR empty($confirm))
    {
      echo "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Veuillez remplir tous les champs</div>";
    }
    else
    {
      if(sha1($oldmdp) != $current_mdp)
      {
        echo "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Mot de passe incorrect</div>";
      }
      else
      {
        if($mdp != $confirm)
        {
          echo "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Les mots de passe ne correspondent pas</div>";
        }
        else
        {
          $cryptmdp = sha1($mdp);
          $req = $bdd->prepare("UPDATE user set mdp = :mdp WHERE id_u = :id_u");
          $req->bindValue('mdp', $cryptmdp, PDO::PARAM_STR);
          $req->bindValue('id_u', $id, PDO::PARAM_INT);
          $req->execute();

          $message = "<div class='alert alert-success col-lg-offset-4 col-lg-3'> Mot de passe modifié !";
          return $message;
        }
      }
    }
  }
?>

<!-- ====================================================================================================================================================== -->
                                                              <!-- MODIFIER AVATAR -->
<?php
  function updateAvatar($avatar, $id, $bdd)
  {
    if (isset($avatar['file']) AND $avatar['file']['error'] == 0)
    {
      if ($avatar['file']['size'] <= 1000000)
      {
        $infosfichier = pathinfo($avatar['file']['name']);
        $extension_upload = $infosfichier['extension'];
        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
        if (in_array($extension_upload, $extensions_autorisees))
        {
          $infosfichier = pathinfo($avatar['file']['name']);
          $extension_upload = $infosfichier['extension'];
          $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
          if (in_array($extension_upload, $extensions_autorisees))
          {
            move_uploaded_file($avatar['file']['tmp_name'], 'uploads/' . basename($avatar['file']['name']));

            $avatar = 'uploads/'.basename($avatar['file']['name']);

            $req = $bdd->prepare('UPDATE user SET avatar = :avatar WHERE id_u = :id_u');
            $req->bindValue('avatar', $avatar, PDO::PARAM_STR);
            $req->bindValue('id_u', $id, PDO::PARAM_INT);
            $req->execute();

            $message = "<div class='alert alert-success col-lg-offset-4 col-lg-3'> Avatar modifié !";
            return $message;
          }
          else
          {
            $error = "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Format incorrect</div>";
            return $error;
          }
        }
        else
        {
          $error = "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Format incorrect</div>";
          return $error;
        }
      }
      else
      {
        $error = "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Fichier trop volumineux</div>";
        return $error;
      }
    }
    else
    {
      $error = "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Sélectionnez un fichier</div>";
      return $error;
    }
  }
?>

<!-- ====================================================================================================================================================== -->
                                                        <!-- AJOUT ELEVE MANUELLEMENT -->
<?php
  function addEleve($email, $nom, $prenom, $classe, $bdd)
  {
    if(empty($email) OR empty($mdp) OR empty($prneom))
    {
      $error = "Veuillez remplir tous les champs du formulaire";
      return $error;
    }
    else
    {
      $req = $bdd->prepare("SELECT * FROM eleve, prof WHERE email = :email");
      $req->bindValue('email', $email, PDO::PARAM_STR);
      $req->execute();

      $rep = $req->fetch();

      if($rep)
      {
        $error = "Email déja utilisé";
        return $error;
      }
      else
      {
        $mdp = randomMdp();
        $crypt = sha1($mdp);
        $ip = $_SERVER['REMOTE_ADDR'];

        $req = $bdd->prepare("INSERT INTO eleve VALUES (NULL, :email, :mdp, :nom, :prenom, :ip, NULL, :classe)");
        $req->bindValue('email', $email, PDO::PARAM_STR);
        $req->bindValue('mdp', $mdp, PDO::PARAM_STR);
        $req->bindValue('nom', $nom, PDO::PARAM_STR);
        $req->bindValue('prenom', $prenom, PDO::PARAM_STR);
        $req->bindValue('ip', $ip, PDO::PARAM_STR);
        $req->bindValue('classe', $classe, PDO::PARAM_INT);
        $req->execute();

        sendMail($email, $mdp);

        $message = "Elève ajouté";
        return $message;
      }
    }
  }
?>

<!-- ====================================================================================================================================================== -->
                                                        <!-- AJOUT PROF MANUELLEMENT -->
<?php
  function addProf($email, $nom, $prenom, $matiere, $bdd)
  {
    if(empty($email) OR empty($mdp) OR empty($prenom))
    {
      $error = "Veuillez remplir tous les champs du formulaire";
      return $error;
    }
    else
    {
      $req = $bdd->prepare("SELECT * FROM eleve, prof WHERE email = :email");
      $req->bindValue('email', $email, PDO::PARAM_STR);
      $req->execute();

      $rep = $req->fetch();

      if($rep)
      {
        $error = "Email déja utilisé";
        return $error;
      }
      else
      {
        $mdp = randomMdp();
        $crypt = sha1($mdp);
        $ip = $_SERVER['REMOTE_ADDR'];

        $req = $bdd->prepare("INSERT INTO prof VALUES (NULL, :email, :mdp, :nom, :prenom, :ip, NULL)");
        $req->bindValue('email', $email, PDO::PARAM_STR);
        $req->bindValue('mdp', $mdp, PDO::PARAM_STR);
        $req->bindValue('nom', $nom, PDO::PARAM_STR);
        $req->bindValue('prenom', $prenom, PDO::PARAM_STR);
        $req->bindValue('ip', $ip, PDO::PARAM_STR);
        $req->execute();

        sendMail($email, $mdp);
        $id_p = $bdd->lastInsertId;

        foreach ($matiere as $key => $value)
        {
          $req1 = $bdd->prepare("INSERT INTO enseigner (id_p, id_m) VALUES (?, ?)");
          $req1->execute([$id_p, $value]);
        }

        $message = "Professeur ajouté";
        return $message;
      }
    }
  }
?>

<!-- ====================================================================================================================================================== -->
                                                             <!-- RANDOM PASSWORD -->
<?php
  function randomMdp()
  {
    $mdp = "";
    $chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for($i = 0; $i < 8; $i++)
    {
      $mdp .= $chaine[rand(0,51)];
    }

    $mdp = str_shuffle($mdp);

    return $mdp;
  }
?>

<!-- ====================================================================================================================================================== -->
                                                             <!-- ENVOYER EMAIL -->
<?php
  function sendMail($mail, $mdp)
  {
    if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
    {
      $passage_ligne = "\r\n";
    }
    else
    {
      $passage_ligne = "\n";
    }

    $message_txt = "Votre mot de passe d'accès à l'intranet : ";
    $message_html = "<html><head></head><body>Votre mot de passe d'accès à l'intranet : </body></html>";

    $boundary = "-----=".md5(rand());

    $sujet = "Identifiant connexion intranet";

    $header = "From: \"Vincent Cotini\"<vincent.cotini96@gmail.com>".$passage_ligne;
    $header .= "Reply-to: \"Vincent Cotini\" <vincent.cotini96@gmail.com>".$passage_ligne;
    $header .= "MIME-Version: 1.0".$passage_ligne;
    $header .= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;

    //=============

    //=====Création du message.
    $message = $passage_ligne."--".$boundary.$passage_ligne;
    //=====Ajout du message au format texte.
    $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
    $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
    $message.= $passage_ligne.$message_txt.$passage_ligne;
    //==========
    $message.= $passage_ligne."--".$boundary.$passage_ligne;
    //=====Ajout du message au format HTML
    $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
    $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
    $message.= $passage_ligne.$message_html.$passage_ligne;
    //==========
    $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
    $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
    //==========

    //=====Envoi de l'e-mail.
    mail($mail,$sujet,$message,$header);
    //==========
  }
?>

<!-- ====================================================================================================================================================== -->
                                                             <!-- CREER CLASSE -->
<?php
  function creerClasse ($nom, $bdd)
  {
    if(empty($nom))
    {
      $error = "Veuillez donner un nom à la classe à créer";
      return $error;
    }
    else
    {
      $req = $bdd->prepare("INSERT INTO classes (id_c, nom_c) VALUES (NULL, :nom)");
      $req->bindValue('nom', $nom, PDO::PARAM_STR);
      $req->execute();

      $message = "La clase a bien été créée";
      return $message;
    }
  }
?>

<!-- ====================================================================================================================================================== -->
                                                             <!-- AFFICHAGE -->
<?php
  function displayEleve()
  {
    $req = $bdd->prepare("SELECT * FROM eleve");
    $req->execute();

    $rep = $req->fetch();

    return $rep;
  }
?>
<!-- ================================= -->
<?php
  function displayProf()
  {
    $req = $bdd->prepare("SELECT * FROM prof WHERE lvl = 1");
    $req->execute();

    $rep = $req->fetch();

    return $rep;
  }
?>
<!-- ================================= -->
<?php
  function displayClasse()
  {
    $req = $bdd->prepare("SELECT * FROM classes");
    $req->execute();

    $rep = $req->fetch();

    return $rep;
  }
?>
<!-- ================================= -->
<?php
  function displayMatiere()
  {
    $req = $bdd->prepare("SELECT * FROM matiere");
    $req->execute();

    $rep = $req->fetch();

    return $rep;
  }
?>










<!-- ====================================================================================================================================================== -->
                                                          <!-- GENERATEUR SELECT FORM -->
<?php /*
  function select($name, $values){
    $html = "<select class = 'form-control' name='$name' id='$name'>";
    foreach($values as $value){
      $html .="<option value='$value'>$value</option>";
    }
    $html .="</select>";

    return $html;
  } */
?>

<!-- =============================================================================================================================== -->

<?php /*
  session_start();
  $pdo = dbConnect();

  $userIp = $_SERVER['REMOTE_ADDR'];
  $limite = $pdo->query("SELECT * ban WHERE ip = '$userip'")->fetch(PDO::FETCH_ASSOC)['limite'];

  $isStillBanned = strtotime($limite) > strtotime(time()- 60*5);
  if(isStillBanned){
    unset($_SESSION['nbFailedAuth']);
    $pdo->query("DELETE FROM ban WHERE ip = '$userIp' ");
  }else{
    die('Vous êtes ban !');
  }

  if($_POST){

    $login = htmlentities($_POST['login']);
    $mdp = sha1($_POST['mdp'])

    $req = $pdo->prepare("SELECT COUNT(*) as nb FROM user WHERE login = :login AND mdp = :mdp");
    $req->execute([$login, $mdp]);
    $has = $req->fecth(PDO::FETCH_ASSOC)['nb'];
    if($has){
      header('Location: profil.php');
      die();
    }
    else{
      if(!isset($_SESSION['nbFailedAuth'])){
        $_SESSION['nbFailedAuth'] = 1;
      }
      else{
        $_SESSION['nbFailedAuth'] += 1;
      }

      if($_SESSION['nbFailedAuth'] > 3)
      {
        $pdo->query("INSERT INTO ban (ip) VALUES ('userIP')");
      }
    }
  } */
?>
