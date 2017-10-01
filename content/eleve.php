<div class="back_admin">
    <div class="container">

           <div class="row row1">
            <div class="col-xs-12">

              <?php
                $req = displaySemestre($bdd);
                while($rep = $req->fetch())
                { ?>
                  <span  class="bouton1 btn btn-info semestre">Semestre <?php echo $rep['id_s']; ?>  </span> <?php
                }
              ?>

            </div>


        </div>
        <br>
        <div class="row">
            <div class="col-xs-12 col-md-4 onglet_eleve"><h3>Matière</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve"><h3>Notes</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve"><h3>Appréciations</h3></div>
        </div>

        <?php
          $req1 = displayMatiere($_SESSION['classe'], $bdd);
          while($rep1 = $req1->fetch())
          { ?>
          <div class="row">
              <div class="col-xs-12 col-md-4 onglet_eleve2"><h3><?php echo $rep1['nom_m']; ?></h3></div>
              <div class="col-xs-12 col-md-4 onglet_eleve1"><h3>
              <?php
                $req2 = displayNote($rep1['id_m'], $bdd);
                while($rep2 = $req2->fetch())
                {
                  echo " ".$rep2['note']." / ";
                }
              ?>
              </h3></div>
              <div class="col-xs-12 col-md-4 onglet_eleve4">
                <?php
                  $req3 = displayAppreciation($rep1['id_m'], $_SESSION['id'], $bdd);
                  while($rep3 = $req3->fetch())
                  {
                    echo $rep3['appreciation'];
                  }
                ?>
              </div>
          </div>
        <?php } ?>
        <br />
        <br />
         <div class="row">
            <div class="col-xs-12">
                <a href="index.php"><button class="btn btn-primary bouton1"><span class="glyphicon glyphicon-home"></span> <h4>Revenir à l'accueil</h4></button></a>
            </div>
<<<<<<< HEAD
        </div>
</div>
=======



    </div>
    
    <?php
    if(isset($_POST['submit']))
    {
        extract($_POST);
        
        $requete = $bdd->prepare("SELECT id_p FROM prof WHERE id_p = :dest");
        $requete->bindValue(':dest',$destinataire,PDO::PARAM_STR);
        $requete->execute();
        if($reponse = $requete->fetch())
        {
            $requete = $bdd->prepare("INSERT INTO message(titre,contenu,id_dest,id_exp)
            VALUES(:titre,:contenu,:dest,:exp)");
            $requete->bindValue(':titre',$titre,PDO::PARAM_STR);
            $requete->bindValue(':contenu',$contenu,PDO::PARAM_STR);
            $requete->bindValue(':dest',$reponse['id_p'],PDO::PARAM_INT);
            $requete->bindValue(':exp',$_SESSION['id'],PDO::PARAM_INT);
            $requete->execute();
            
            echo"<center><h4>message envoyé</h4></center>";
        }
        else
        {
            echo"<center><h4>Destinataire inconnu</h4></center>";
        }
    }

?>
   


    <header>
        <h2>Envoyer un message</h2>
    </header>
    
    <form method="post" action="#">
       
       <div class="form-group">
           <label for="exampleInputEmail1" class="text-size">Destinataire</label>
            <select class="form-control" name="destinataire">
                <?php
                
                    $req = $bdd->query("SELECT * FROM prof");
                    $i = 1;
                 
                    while($reponse = $req->fetch())
                    {
                        if($reponse['lvl'] < 2)
                        {
                            echo "<option value='".$i."'>".$reponse['nom']." ".$reponse['prenom']."</option>";
                            $i++;
                        }
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
>>>>>>> 49184bcb4ad22098646ad6e84eeddbd48c13d77d
</div>
