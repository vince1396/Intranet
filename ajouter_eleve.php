<!-- Ajouter plusieurs élèves -->
                
<form method="post">
                 <div>
                     <span class="btn btn-info select_class"><h5> Classe :</h5></span>
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
                   <span class="btn btn-info select_class"><h5> Classe :</h5></span>
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
                <button class="btn btn-success select_class" type="submit" name="submit" id="duplicatebtn"><span class="glyphicon glyphicon-plus"></span> Ajouter un autre élève</button>
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
                    }
?>

<!----------------------------------------------------->
<!----------------------------------------------------->
<!----------------------------------------------------->


<!-------------Affecter un prof à une matière---------------------->


 <?php
          
            if(isset($_POST["submit"])){
                
                $message = '';
                
                if(empty($prenom_p))
			    {
                    $message .= "Votre prenom est vide <br/>";
			    }
                
                if(empty($nom_p))
			    {
                    $message .= "Votre nom est vide <br/>";
			    }
                
                extract($_POST);
                
                $req = $bdd->prepare("INSERT into professeur(nom_p, prenom_p, salaire) VALUES (:nom, :prenom, :salaire)");
                
                $req->bindValue(':nom', $nom_p,PDO::PARAM_STR);
                $req->bindValue(':prenom', $prenom_p,PDO::PARAM_STR);
                $req->bindValue(':salaire', $salaire,PDO::PARAM_STR);
                $req->execute();
                
                $id_p = $bdd->lastInsertId();
                $req2 = $bdd->prepare("INSERT into enseigner(id_m, id_p) VALUES (:id_m, :id_p)");
            
                    
                foreach($matiere as $k => $v){
                    $req = $bdd->prepare("INSERT INTO enseigner (id_p, id_m) VALUES (?, ?)");
                    $req->execute([$id_p, $v]);
                }
            }
            
        ?>
        
       <form method="post">
                   <label type="text">Prénom: <input type="text" name="prenom_p"></label>
                   <label type="text">Nom: <input type="text" name="nom_p"></label>
                   <label class="btn btn-success">Classe: 
                           Classe 1<input type="checkbox" name="classe[]">
                           Classe 2<input type="checkbox" name="classe[]">
                           Classe 3<input type="checkbox" name="classe[]">    
                   </label>
                   <label type="text">Salaire: <input type="text" name="salaire"></label>
                   <label class="btn btn-success"> Matière:
                            Math<input type="checkbox" name="matiere[]" value="1">      
                            EDM<input type="checkbox" name="matiere[]" value="4"> 
                            PPE<input type="checkbox" name="matiere[]" value="3"> 
                            Anglais<input type="checkbox" name="matiere[]" value="5">      
                            Français<input type="checkbox" name="matiere[]" value="2"> 
                            Histoire<input type="checkbox" name="matiere[]" value="6"> 
                    </label>
                    
                   <button class="btn btn-success" name="submit" type="submit">
                       <span class="glyphicon glyphicon-plus"></span><h5>Ajouter Professeur</h5>
                   </button>
               </form>