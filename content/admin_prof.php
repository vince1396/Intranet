<div class="back_admin">

        <div class="container">
        
        <div class="row row1">
            <div class="col-xs-12">

               <span class="btn btn-primary bouton_titre bouton1">Gestion des professeurs</span>
                <span  class="btn btn-info semestre bouton1">Semestre 1 </span>
                <span  class="btn btn-info semestre bouton1"> Semestre 2</span>
            </div>   
        </div>
        <br>
         <table>
        <tr class="row">
            <td class="col-xs-12 col-md-4 onglet_eleve"><h3>Professeurs</h3></td>
            <td class="col-xs-12 col-md-4 onglet_eleve" text-center><h3>Matières</h3></td>
            <td class="col-xs-12 col-md-4 onglet_eleve" text-center><h3>Classes</h3></td>
        </tr>
        
        <?php
             
             $req1 = displayProf($bdd);
             
             while($rep1 = $req1->fetch())
             {
                 echo "<tr class='row'>";
                 echo "<td class='col-xs-12 col-md-4 onglet_eleve2 text-center'>";
                 echo "<h3>".$rep1['nom']." ".$rep1['prenom']."</h3></td>";
                 echo "<td class='col-xs-12 col-md-4 onglet_eleve1 text-center'>";
                 $req2 = displayMatiereProf($rep1['id_p'], $bdd);
                 while($rep2 = $req2->fetch())
                 {
                     echo "<h3>".$rep2['nom_m']."</h3>";
                }
                     $req3 = displayClasse($rep1['id_p'], $bdd);
                     
                     echo "<td class='col-xs-12 col-md-4 onglet_eleve1 text-center'>";
                     while($rep3 = $req3->fetch())
                     {
                         
                         echo "<h3>".$rep3['nom_c']."</h3>";
                     }
                     
                     echo "</td>";
                 
                 echo"</td>";
             }
             echo "</tr>";
        ?>
        
        </table>
        
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
    
               
                while($reponse = $requete->fetch())
                {
                    echo'<div class="row">';
                    echo'<div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3>'.$reponse["nom_p"].' '.$reponse["prenom_p"].'</h3></div>';
                    echo'<div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>'.$reponse["nom_m"].'</h3></div>';
                    echo'<div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>'.$reponse["nom_c"].'</h3></div>';
                    echo'</div>';
                }
                
                
            }
            
        ?>
      
        
        <div class="row">
            <div class="col-xs-12 bouton1"><button class="btn btn-info"><span class="glyphicon glyphicon-plus"></span><h4>Modifier Professeur</h4></button>
                <button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span><h4>Ajouter Professeur</h4></button></div>
            
            <div class="col-xs-12 bouton1"><button class="btn btn-info"><span class="glyphicon glyphicon-plus"></span><h4>Modifier Matière</h4></button> <button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span><h4>Ajouter Matière</h4></button></div>
            <div class="col-xs-12 bouton1">
               <button class="btn btn-info"><span class="glyphicon glyphicon-plus"></span><h4>Modifier Classe</h4></button>
               <form method="post">
                   <label type="text" class="btn btn-success ">Prénom: <input type="text" name="prenom_p" class="font_color"></label>
                   <label type="text" class="btn btn-success ">Nom: <input type="text" name="nom_p" class="font_color"></label>
                   <label class="btn btn-success"><u><b>Classe:</b></u>
                           Classe 1<input type="checkbox" name="classe[]">
                           Classe 2<input type="checkbox" name="classe[]">
                           Classe 3<input type="checkbox" name="classe[]">    
                   </label>
                  
                   <label class="btn btn-success"> <u><b>Matière:</b></u>
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
            </div>
        
    </div>

             <div class="row">
            <div class="col-xs-12">
                <a href="<?=BASE_URL;?>/admin"><button class="btn btn-primary bouton1"><span class="glyphicon glyphicon-home"></span><h4>Revenir à l'accueil</h4></button></a>
            </div>

</div>