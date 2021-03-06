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
        if(isset($rep['id_p']))
        {
          $_SESSION['id'] = $rep['id_p'];
        }
        else
        {
          $_SESSION['id'] = $rep['id_e'];
        }
        $_SESSION['email'] = $rep['email'];
        $_SESSION['lvl'] = $rep['lvl'];
        if(isset($rep['id_c']))
        {
          $_SESSION['classe'] = $rep['id_c'];
        }

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

      $message = "La classe a bien été créée";
      return $message;
    }
  }
?>

<!-- ====================================================================================================================================================== -->
                                                             <!-- AFFICHAGE -->
<!-- Display Eleve by classe/ id_c = classe -->
<?php
  function displayEleve($id_c, $bdd)
  {
    $req = $bdd->prepare("SELECT e.nom, e.prenom, e.id_e
                          FROM eleve e
                          WHERE e.id_c = :id_c
                        ");
    $req->bindValue('id_c', $id_c, PDO::PARAM_INT);
    $req->execute();

    return $req;
  }
?>
<!-- ================================= -->
<?php
  function displayProf($bdd)
  {
    $req = $bdd->prepare("SELECT * FROM prof WHERE lvl = 1");
    $req->execute();

    return $req;
  }
?>
<!-- ================================= -->
<!-- Display classe by prof / id_p = prof -->
<?php
  function displayClasse($id_p, $bdd)
  {
    $req = $bdd->prepare("SELECT DISTINCT c.id_c, c.nom_c
                          FROM classes c, suivre s, matiere m, enseigner e
                          WHERE c.id_c = s.id_c
                          AND s.id_m = m.id_m
                          AND m.id_m = e.id_m
                          AND e.id_p = :id_p
                        ");
    $req->bindValue(':id_p', $id_p, PDO::PARAM_INT);
    $req->execute();

    return $req;
  }
?>
<!-- ================================= -->
<?php
  function displayAllClasse($bdd)
  {
    $req = $bdd->prepare("SELECT * FROM classes");
    $req->execute();

    return $req;
  }
?>
<!-- ================================= -->
<?php
  function displaySemestre($bdd)
  {
    $req = $bdd->prepare("SELECT * FROM semestre");
    $req->execute();

    return $req;
  }
?>
<!-- ================================= -->
<!-- Display matiere by prof / id_p = prof -->
<?php
function displayMatiereProf($id_p, $bdd)
{
  $req = $bdd->prepare("SELECT m.id_m, m.nom_m
                        FROM matiere m, enseigner e
                        WHERE m.id_m = e.id_m
                        AND e.id_p = :id_p
                      ");
  $req->bindValue('id_p', $id_p, PDO::PARAM_INT);
  $req->execute();

  return $req;
}
?>
<!-- ================================= -->
<!-- Display Matiere by classe / id_c = classe -->
<?php
function displayMatiere($id_c, $bdd)
{
  $req = $bdd->prepare("SELECT DISTINCT nom_m, m.id_m
                        FROM matiere m, suivre s, classes c
                        WHERE m.id_m = s.id_m
                        AND s.id_c = :id_c
                      ");
  $req->bindValue('id_c', $id_c, PDO::PARAM_INT);
  $req->execute();

  return $req;
}
?>

<!-- ================================= -->
<?php
  function displayAllMatiere($bdd)
  {
    $req = $bdd->prepare("SELECT * FROM matiere");
    $req->execute();

    return $req;
  }
?>

<!-- ================================= -->
<!-- Display note d'un eleve / id_e = eleve / id_m = matiere -->
<?php
  function displayNote($id_e, $id_m, $bdd)
  {
    $req = $bdd->prepare("SELECT DISTINCT note
                          FROM noter n, devoirs d
                          WHERE n.id_e = :id_e
                          AND n.id_d = d.id_d
                          AND d.id_m = :id_m
                        ");
    $req->bindValue('id_e', $id_e, PDO::PARAM_INT);
    $req->bindValue('id_m', $id_m, PDO::PARAM_INT);
    $req->execute();

    return $req;
  }
?>
<!-- ================================= -->
<!-- Display appréciation d'un eleve pour une matiere -->
<?php
  function displayAppreciation($id_m, $id_e, $bdd)
  {
    $req = $bdd->prepare("SELECT appreciation
                          FROM commenter
                          WHERE id_m = :id_m
                          AND id_e = :id_e");
    $req->bindValue('id_m', $id_m, PDO::PARAM_INT);
    $req->bindValue('id_e', $id_e, PDO::PARAM_INT);
    $req->execute();

    return $req;
  }

?>
<?php
function AddNote($id_d, $id_s, $id_e, $note, $bdd)
{
  $req = $bdd->prepare("INSERT INTO noter(id_d, id_s, id_e, note)
                        VALUES (:id_d, :id_s, :id_e, :note)
                      ");
  $req->bindValue('id_d', $id_d, PDO::PARAM_INT);
  $req->bindValue('id_s', $id_s, PDO::PARAM_INT);
  $req->bindValue('id_e',$id_e, PDO::PARAM_INT);
  $req->bindValue('note',$note, PDO::PARAM_INT);

  $req->execute();

  return $req;
}
function DisplayDevoir($id_m, $bdd)
{
  $req = $bdd->prepare("SELECT DISTINCT nom_d, id_d
    FROM devoirs d
    WHERE d.id_m = :id_m
    ");
    $req->bindValue('id_m', $id_m, PDO::PARAM_INT);
    $req->execute();

    return $req;
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
