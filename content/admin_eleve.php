<div class="back_admin">
    <div class="container">
       <div class="row row1">
            <div class="col-md-12 col-xs-12"><span class="btn btn-primary bouton_titre"><h4>Gestion des élèves </h4></span>

               <form method="post">
                 <div>
                    <select class="btn btn-info select_class" name="classe">

                        <h5><option value="1">Classe 1</option>
                        <option value="2">Classe 2</option>
                        <option value="3">Classe 3</option>
                        <option value="4">Classe 4</option>
                        <option value="5">Classe 5</option>
                        <option value="6">Classe 6</option>
                    </h5>
                    </select>

                    Nom élève: <input type="text" name="nom_e[]">
                    Prénom élève: <input type="text" name="prenom_e[]">

                    <button class="btn btn-success select_class" type="submit" name="submit"><span class="glyphicon glyphicon-plus"></span> Ajouter un élève</button>
                 </div>


                 <!--Formulaire caché-->

                  <div class="hidden" id="duplicate">
                    <select class="btn btn-info select_class" name="classe">

                        <h5><option value="1">Classe 1</option>
                        <option value="2">Classe 2</option>
                        <option value="3">Classe 3</option>
                        <option value="4">Classe 4</option>
                        <option value="5">Classe 5</option>
                        <option value="6">Classe 6</option>
                    </h5>
                    </select>

                    Nom élève: <input type="text" name="nom_e[]">
                    Prénom élève: <input type="text" name="prenom_e[]">

                    
                   </div>

                   <button class="btn btn-success select_class" type="submit" name="submit" id="duplicatebtn"><span class="glyphicon glyphicon-plus"></span> Ajouter un autre élève</button>
                </form>
                <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
                <script>
                    (function ($){
                        $('#duplicatebtn').click(function (e) {
                            e.preventDefault();
                            var clone = $('#duplicate').clone().attr('id','').removeClass('hidden');
                            $('#duplicate').before(clone);
                        })
                    })(jQuery);
                </script>

                <?php

                    if(isset($_POST["submit"])){

                        extract($_POST);


                        foreach($nom_e as $k => $v)
                        {
                            if($v != "")
                            {
                            $req = $bdd->prepare("INSERT INTO eleve(nom_e, prenom_e, id_c) VALUES(?, ?, ?)");
                            $req->execute(array($nom_e[$k], $prenom_e[$k], $classe));
                            }
                        }

                        echo '<div class="row ombrage">';
                        echo '<div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3></h3></div>';
                        echo '<div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3></h3></div>';
                        echo '<div class="col-xs-12 col-md-4 onglet_eleve4 text-center"><h3></h3></div>';
                        echo '</div>';
                    }


                ?>

            </div>
        </div>
        <br>
        <div class="row ombrage">
            <div class="col-xs-12 btn btn-primary text-center"><h3>Elèves :
             <select class="onglet_eleve2">
                    <option value="1">John Doe</option>
                    <option value="2">James Dozé</option>
                    <option value="3">John Doe</option>
                    <option value="4">John Doe</option>
                    <option value="5">John Doe</option>
                </select>
                 <button class="btn btn-info"><span class="glyphicon glyphicon-pencil"></span>   Modifier les élèves</button></h3>
                 </div><br><br>
            <div class="col-xs-12 col-md-4 onglet_eleve text-center"><h3>Matières</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve text-center"><h3>Notes</h3></div>
                <div class="col-xs-12 col-md-4 onglet_eleve text-center"><h3>Appréciations</h3></div>
        </div>
        <div class="row ombrage">

            <div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3>Math</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>18</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve4 text-center"><h3>Bien joué !</h3></div>
            </div>
        <div class="row ombrage">

            <div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3>Français</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>18</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve4 text-center"><h3>Bien joué !</h3></div>
            </div>
         <div class="row ombrage">

            <div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3>Histoire</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>18</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve4 text-center"><h3>Bien joué !</h3></div>
            </div>
          <div class="row ombrage">

            <div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3>Physique</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>18</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve4 text-center"><h3>Bien joué !</h3></div>
            </div>
         <div class="row ombrage">

            <div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3>Economie</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>18</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve4 text-center"><h3>Bien joué !</h3></div>
            </div>
         <div class="row ombrage">

            <div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3>Droit</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>18</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve4 text-center"><h3>Bien joué !</h3></div>
            </div>
          <div class="row ombrage">

            <div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3>Anglais</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>18</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve4 text-center"><h3>Bien joué !</h3></div>
            </div>

          <div class="row ombrage">

            <div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3>Géographie</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>18</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve4 text-center"><h3>Bien joué !</h3></div>
            </div>

        <div class="row ombrage">

            <div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3>Math</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>18</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve4 text-center"><h3>Bien joué !</h3></div>
        </div>

          <div class="row ombrage">

            <div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3>Math</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>18</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve4 text-center"><h3>Bien joué !</h3></div>
            </div>

          <div class="row ombrage">

            <div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3>Math</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>18</h3></div>
            <div class="col-xs-12 col-md-4 onglet_eleve4 text-center"><h3>Bien joué !</h3></div>
            </div>

        <div class="row">

            <div class="col-xs-12 col-md-4 bouton1">
                <button class="btn btn-info"><h5><span class="glyphicon glyphicon-pencil"></span> Modifier les matières</h5></button>
            </div>
            <div class="col-xs-12 col-md-3 bouton1">
                <button class="btn btn-info"><h5><span class="glyphicon glyphicon-pencil"></span> Modifier les notes</h5></button>
            </div>
            <div class="col-xs-12 col-md-4 bouton1">
                <button class="btn btn-info"><h5><span class="glyphicon glyphicon-pencil"></span> Modifier les appréciations</h5></button>
            </div>

        </div>
        <br>
        <div class="row">

            <div class="col-xs-12 col-md-4">
                <button class="btn btn-info bouton1"><H5> <span class="glyphicon glyphicon-plus"></span> Modifier le bulletin</H5> </button>
            </div>
        </div>
        <br>
        <div class="row">

            <div class="col-xs-12 col-md-4">
                <a href="<?=BASE_URL;?>/admin">
                    <button class="btn btn-primary bouton1"><span class="glyphicon glyphicon-home"></span><h5>Revenir à l'accueil</h5></button>
                </a>
            </div>
        </div>
    </div>
</div>
