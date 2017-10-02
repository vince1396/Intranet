<div class="back_admin">
    <div class="container">

        <div class="row row1">
            <div class="col-xs-12">

                <span  class="btn btn-info bouton_titre bouton1">Classe :</span>

                <form class="" action="#" method="post">

                  <select name="classe" class="btn btn-info select_class bouton1">
                    <?php
                      $req = displayClasse($_SESSION['id'], $bdd);
                      while($rep = $req->fetch())
                      {
                        echo "<option value='".$rep['id_c']."' >".$rep['nom_c']."</option>";
                      }
                    ?>
                  </select>
                  <input type="submit" name="submit" value="Selectionner">
                </form>

                <?php
                  $req1 = displayMatiereProf($_SESSION['id'], $bdd);
                  $rep1 = $req1->fetch();
                ?>
                <span class="btn btn-info bouton1"> Matière : <?php echo $rep1['nom_m']; ?></span>

            
            </div>


        </div>
        <br>
         <table>
        <tr class="row">
            <td class="col-xs-12 col-md-4 onglet_eleve text-center"><h3>Elèves</h3></td>
            <td class="col-xs-12 col-md-4 onglet_eleve text-center"><h3>Notes</h3></td>
            <td class="col-xs-12 col-md-4 onglet_eleve text-center"><h3>Appréciations</h3></td>
        </tr>

        <?php
          if(isset($_POST['submit']))
          {
            $req2 = displayEleve($_POST['classe'], $bdd);
            while($rep2 = $req2->fetch())
            {
            ?>
            <tr class="row">
            <td class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3><?php echo " ".$rep2['prenom']." ".$rep2['nom']; ?></h3></td>
            <td class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>
              <?php
                $req3 = displayNote($rep2['id_e'], $_POST['classe'], $bdd);
                while($rep3 = $req3->fetch())
                {
                    echo " ".$rep3['note']." / ";
                }
              ?>
            </h3></td>
            <td class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>Bien joué !</h3></td>
            </tr>
            <?php } ?>
            
        </table>
           
            <div class="row">
            <div class="col-xs-12 col-md-4 bouton1"><button class="btn btn-info"><h5><span class="glyphicon glyphicon-pencil"></span> Modifier les élèves</h5></button></div><div class="col-xs-12 col-md-4 bouton1"><button class="btn btn-info"><h5><span class="glyphicon glyphicon-pencil"></span> Modifier les notes</h5></button></div>
          </div> <?php
          }
        ?>


         <?php
    // if(isset($_POST['submit']))
    // {
    //     extract($_POST);
    //
    //     $requete = $bdd->prepare("SELECT id_e FROM eleve WHERE id_e = :dest");
    //     $requete->bindValue(':dest',$destinataire,PDO::PARAM_STR);
    //     $requete->execute();
    //     if($reponse = $requete->fetch())
    //     {
    //         $requete = $bdd->prepare("INSERT INTO message(titre,contenu,id_dest,id_exp)
    //         VALUES(:titre,:contenu,:dest,:exp)");
    //         $requete->bindValue(':titre',$titre,PDO::PARAM_STR);
    //         $requete->bindValue(':contenu',$contenu,PDO::PARAM_STR);
    //         $requete->bindValue(':dest',$reponse['id_e'],PDO::PARAM_INT);
    //         $requete->bindValue(':exp',$_SESSION['id'],PDO::PARAM_INT);
    //         $requete->execute();
    //
    //         echo"<center><h4>message envoyé</h4></center>";
    //     }
    //     else
    //     {
    //         echo"<center><h4>Destinataire inconnu</h4></center>";
    //     }
    // }

?>
<div class="col-xs-12">
               <a href="index.php"><button class="btn btn-primary bouton1"><span class="glyphicon glyphicon-home"></span> Revenir à l'accueil</button></a>
            </div>
    <div class="row">

    <header>
        <h2>Envoyer un message</h2>
    </header>

    <form method="post" action="#">

       <div class="form-group">
           <label for="exampleInputEmail1" class="text-size">Destinataire</label>
            <select class="form-control" name="destinataire">
                <?php

                    $req = $bdd->query("SELECT * FROM eleve");
                    $i = 1;

                    while($reponse = $req->fetch())
                    {
                            echo "<option value='".$i."'>".$reponse['nom']." ".$reponse['prenom']."</option>";
                            $i++;

                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1" class="text-size">Titre du message</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Titre" name="titre"> </div>
        <div class="form-group">
            <label for="exampleInputPassword1" class="text-size">Contenu du message</label>
            <textarea type="password" class="form-control" id="exampleInputPassword1" name="contenu" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-default" name="submit">Envoyer</button>
    </form>
  </div>
    </div>
</div>
