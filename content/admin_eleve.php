<div class="back_admin">
    <div class="container">
       <div class="row row1">
            <div class="col-md-12 col-xs-12"><span class="btn btn-primary bouton_titre"><h4>Gestion des élèves </h4></span>

               <form method="post">
                 <div>
                    <select class="btn btn-info select_class" name="classe">
                    <?php
                        
                        $req = displayAllClasse($bdd);
                        while($rep = $req->fetch())
                        {
                            echo"<option value=".$rep['id_c'].">".$rep['nom_c']."</option>";
                        }
                    
                    ?>
                        
                    </select>


                    <button class="btn btn-success select_class" type="submit" name="submit_classe"> Sélectionner la classe</button>
                 </div>
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

               

            </div>
        </div>
        <br>
        <table>
        <tr class="row ombrage">
            <td class="col-xs-12 btn btn-primary text-center"><h3>Elèves :</h3>
            <form method="post">
                 <select class="onglet_eleve2" name="eleve">
                   <?php
                        
                        if(isset($_POST["submit_classe"]))
                        {
                            $req2 = displayEleve($_POST['classe'], $bdd);
                            while($rep2 = $req2->fetch())
                            {
                                echo "<option value=".$rep2["id_e"].">".$rep2['nom']." ".$rep2['prenom']."</option>";
                            }
                        }
                    ?>
                </select>
                 <button class="btn btn-info" type="submit" name="eleve_submit"> Sélectionner l'élève</button>
                </form>
            </td><br><br>
            </tr>
        </table>
        <table>
        <tr class="row ombrage">
            <td class="col-xs-12 col-md-4 onglet_eleve text-center"><h3>Matières</h3></td>
            <td class="col-xs-12 col-md-4 onglet_eleve text-center"><h3>Notes</h3></td>
                <td class="col-xs-12 col-md-4 onglet_eleve text-center"><h3>Appréciations</h3></td>
        
        </tr>
        
        <?php
          
            if(isset($_POST["submit_classe"]))
            {
                $req3 = displayMatiere($_POST['classe'], $bdd);
                while($rep3 = $req3->fetch())
                {
                    echo"<tr class='row ombrage'>";
                    echo"<td class='col-xs-12 col-md-4 onglet_eleve2 text-center'>";
                    echo"<h3>".$rep3['nom_m']."</h3></td>";
                    echo"<td class='col-xs-12 col-md-4 onglet_eleve1 text-center'>";
                    echo"<h3>18</h3></td>";
                    echo"<td class='col-xs-12 col-md-4 onglet_eleve4 text-center'>";
                    echo"<h3>BRAVO</h3></td>";
                    echo"</tr>";
                }
            }
            
            
        ?>
        
        </table>

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
        
        
         <?php

                    if(isset($_POST["submit"])){

                        extract($_POST);


                        foreach($nom_e as $k => $v)
                        {
                            if($v != "")
                            {
                            $req = $bdd->prepare("INSERT INTO eleve(nom_e, prenom_e, id_c) VALUES(?, ?, ?)");
                            $req->execute(array($nom_e[$k], $prenom_e[$k], $classe[$k]));
                            }
                        }

                        echo '<div class="row ombrage">';
                        echo '<div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3></h3></div>';
                        echo '<div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3></h3></div>';
                        echo '<div class="col-xs-12 col-md-4 onglet_eleve4 text-center"><h3></h3></div>';
                        echo '</div>';
                    }


                ?>
                
        <!--- AJOUT ELEVE--->
            
            <form method="post">
                 <div>
                    <select class="btn btn-info select_class" name="classe">
                    <?php
                        
                        $req = displayAllClasse($bdd);
                        $i = 1;
                        while($rep = $req->fetch())
                        {
                            echo"<option value=".$rep['id_c'].">".$rep['nom_c']."</option>";
                            $i++;
                        }
                    
                    ?>
                        
                    </select>

                    Nom élève: <input type="text" name="nom_e[]">
                    Prénom élève: <input type="text" name="prenom_e[]">

                    <button class="btn btn-success select_class" type="submit" name="submit"><span class="glyphicon glyphicon-plus"></span> Ajouter un élève</button>
                 </div>


                 <!--Formulaire caché-->

                  <div class="hidden" id="duplicate">
                    <select class="btn btn-info select_class" name="classe[]">

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
        <!------------------>
        <div class="row">

            <div class="col-xs-12 col-md-4">
                <a href="<?=BASE_URL;?>/admin">
                    <button class="btn btn-primary bouton1"><span class="glyphicon glyphicon-home"></span><h5>Revenir à l'accueil</h5></button>
                </a>
            </div>
        </div>
    </div>
</div>
