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
          $req = displayMatiere($_SESSION['classe'], $bdd);
          while($rep = $req->fetch())
          { ?>
          <div class="row">
              <div class="col-xs-12 col-md-4 onglet_eleve2"><h3><?php echo $rep['nom_m']; ?></h3></div>
              <div class="col-xs-12 col-md-4 onglet_eleve1"><h3>18 / 19 / 20</h3></div>
              <div class="col-xs-12 col-md-4 onglet_eleve4"><h3>Bien joué !</h3></div>
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
