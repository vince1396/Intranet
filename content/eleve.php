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
        </div>
</div>
</div>
