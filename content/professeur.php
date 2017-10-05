<div class="back_admin">
    <div class="container">

        <div class="row row1">
          <div class="col-xs-12">

<!-- ======================================================= SELECT MATIERE =========================================================== -->
              <form class="" action="#" method="post">
                <span class="btn btn-info bouton1"> Matière :</span>
                <select name="matiere" class="btn btn-info select_class bouton1">
                 <?php
                    $req = displayMatiereProf($_SESSION['id'], $bdd);
                    while($rep = $req->fetch())
                    {
                        echo "<option value=".$rep['id_m'].">".$rep['nom_m']."</option>";
                    }
                 ?>
                </select>
                <input type="submit" name="sMatiere" class="btn btn-success bouton1" value="Selectionner">
                </form>
          </div>
          </div>

        <?php
        if(isset($_POST['sMatiere']))
        {
       ?>
         <div class="row row1">
           <div class="col-xs-12">

<!-- ======================================================= SELECT CLASSE =========================================================== -->
               <form class="" action="#" method="post">
                 <span  class="btn btn-info bouton_titre bouton1">Classe :</span>
                   <select name="classe" class="btn btn-info select_class bouton1">
                     <?php
                       $req1 = displayClasse($_SESSION['id'], $bdd);
                       while($rep1 = $req1->fetch())
                       {
                         echo "<option value='".$rep1['id_c']."' >".$rep1['nom_c']."</option>";
                       }
                     ?>
                   </select>
                   <input type="hidden" name="idMatiere" value=<?php echo $_POST['matiere'] ?>>
                   <input type="hidden" name="idClasse" value=<?php echo $rep1['id_c'] ?>>
                   <input type="submit" name="sClasse" class="btn btn-success bouton1" value="Selectionner">
              </form>

           </div>
        </div> <?php
       }
       ?>
<!-- ======================================================= TABLEAU =========================================================== -->
        <?php
          if(isset($_POST['sClasse']))
          { ?>
            <table>
              <tr class="row">
                <td class="col-xs-12 col-md-4 onglet_eleve text-center"><h3>Elèves</h3></td>
                <td class="col-xs-12 col-md-4 onglet_eleve text-center"><h3>Notes</h3></td>
                <td class="col-xs-12 col-md-4 onglet_eleve text-center"><h3>Appréciations</h3></td>
              </tr> <?php
// ======================================================= AFFICHER ELEVE ===========================================================
              $req2 = displayEleve($_POST['classe'], $bdd);
              while($rep2 = $req2->fetch())
              { ?>
                <tr class="row">
                  <td class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3><?php echo " ".$rep2['prenom']." ".$rep2['nom']; ?></h3></td>
                  <td class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>
                  <?php
// ======================================================= AFFICHER NOTES ===========================================================
                    $req3 = displayNote($rep2['id_e'], $_POST['idMatiere'], $bdd);
                    while($rep3 = $req3->fetch())
                    {
                      echo " ".$rep3['note']." / ";
                    }
                  ?>
                </h3></td>
                <td class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>
                <?php
// ======================================================= AFFICHER APPRECIATION ===========================================================
                  $req4 = displayAppreciation($_POST['idMatiere'], $rep2['id_e'], $bdd);
                  while($rep4 = $req4->fetch())
                  {
                    echo $rep4['appreciation'];
                  }
                ?>
                </h3></td>
              </tr>
              <?php } ?>
            </table>
<!-- ======================================================= FIN TABLEAU =========================================================== -->
            <div class="row">
            <div class="col-xs-12 col-md-12 bouton1">
<!-- ======================================================= AJOUT NOTES =========================================================== -->
            <form method="post" action="#">
              <span  class="btn btn-primary bouton_titre bouton1">Devoirs: </span>
              <select name="devoir" class="btn btn-info select_class bouton1">
               <?php
                $req5 = displayDevoir($_POST['idMatiere'], $bdd);
                while($rep5 = $req5->fetch())
                  {
                    echo"<option value=".$rep5["id_d"].">".$rep5["nom_d"]."</option>";
                  }
               ?>
             </select>
            <span class="btn btn-primary bouton_titre bouton1">Note : </span><input type="text" name="note" class="btn btn-default bouton1">
            <span  class="btn btn-primary bouton_titre bouton1">Elève: </span>
               <select class="btn btn-info select_class bouton1" name="eleve">
                <?php
                  $req2 = displayEleve($_POST['classe'], $bdd);
                  while($rep2 = $req2->fetch())
                  {
                    echo "<option value=".$rep2["id_e"].">".$rep2['nom']." ".$rep2['prenom']."</option>";
                  }
                ?>
            </select>
            <button class="btn btn-success" type="submit" name="ajouter_note"><h5><span class="glyphicon glyphicon-plus"></span>Ajouter une note</h5></button>
            </form>

            <?php

              if(isset($_POST['ajouter_note']))
              {
                  $req3 = AddNote($rep4['id_d'], $id_s, $rep2['id_e'], $note);
              }
            ?>

            </div>
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
<!-- <div class="col-xs-12">
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
                    //
                    // $req = $bdd->query("SELECT * FROM eleve");
                    //
                    // while($reponse = $req->fetch())
                    // {
                    //         echo "<option value='".$reponse['id_e']."'>".$reponse['nom']." ".$reponse['prenom']."</option>";
                    //
                    // }
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
</div> -->
