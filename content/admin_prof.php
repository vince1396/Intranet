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
          
            
                
//                extract($_POST);
//                
//                $req = $bdd->prepare("INSERT into professeur(nom, prenom) VALUES (:nom, :prenom)");
//                
//                $req->bindValue(':nom', $nom_p,PDO::PARAM_STR);
//                $req->bindValue(':prenom', $prenom_p,PDO::PARAM_STR);
//                $req->execute();
//                
//                $id_p = $bdd->lastInsertId();
//                $req2 = $bdd->prepare("INSERT into enseigner(id_m, id_p) VALUES (:id_m, :id_p)");
//            
//                    
//                foreach($matiere as $k => $v){
//                    $req = $bdd->prepare("INSERT INTO enseigner (id_p, id_m) VALUES (?, ?)");
//                    $req->execute([$id_p, $v]);
//                }
//    
//               
//                while($reponse = $req->fetch())
//                {
//                    echo'<div class="row">';
//                    echo'<div class="col-xs-12 col-md-4 onglet_eleve2 text-center"><h3>'.$reponse["nom_p"].' '.$reponse["prenom_p"].'</h3></div>';
//                    echo'<div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>'.$reponse["nom_m"].'</h3></div>';
//                    echo'<div class="col-xs-12 col-md-4 onglet_eleve1 text-center"><h3>'.$reponse["nom_c"].'</h3></div>';
//                    echo'</div>';
//                }
//                
//                
//            }
            
        ?>
      
        
        <div class="row">
                
            <form method="post" action="#">
            <div class="col-xs-12 bouton1">
               <label type="text" class="btn btn-primary bouton1">Nom de la matière: <input type="text" name="nom_m" class="font_color"></label>
                <button class="btn btn-success" type="submit" name="submit_matiere">
                    <span class="glyphicon glyphicon-plus"></span><h4>Ajouter Matière</h4>
                </button>
            </div>
            </form>
            
            <?php
                
                if(isset($_POST['submit_matiere']))
                {
                    $nom_m = $_POST['nom_m'];
                    $req4 = $bdd->prepare("INSERT INTO matiere (nom_m) VALUES(:nom_m)");
                    $req4->bindValue(':nom_m', $nom_m, PDO::PARAM_STR);
                    $req4->execute();
                }
            
            ?>
            

            <div class="col-xs-12 col-md-12 bouton1">
              
               <form method="post">
                   <label type="email" class="btn btn-primary  bouton1">Email: <input type="email" name="email" class="font_color"></label>
                   <label type="text" class="btn btn-primary bouton1 ">Mdp: <input type="password" name="mdp" class="font_color"></label>
                   <label type="text" class="btn btn-primary bouton1 ">Nom: <input type="text" name="nom" class="font_color"></label>
                   <label type="text" class="btn btn-primary bouton1 ">Prénom: <input type="text" name="prenom" class="font_color"></label>
                   <label class="btn btn-primary bouton1"> <u><b>Matière:</b></u>
                            <?php
                            
                                $req6 = displayAllMatiere($bdd);
                                
                                while($rep6 = $req6->fetch())
                                {
                                    echo $rep6['nom_m']." <input type='checkbox' name='matiere' value=".$rep6['id_m']."> ";
                                }
                        
                            ?>
                    </label>
                    <br>
                   <button class="btn btn-success" name="submitaddprof" type="submit">
                       <span class="glyphicon glyphicon-plus"></span><h5>Ajouter Professeur</h5>
                   </button>
               </form>

     <?php 
                
	if(isset($_POST['submitaddprof']))
	{
			$i = 0;
            $email = $_POST["email"];
            $mdp = $_POST["mdp"];
			$nom = $_POST["nom"];
			$prenom = $_POST["prenom"];
        
        if(empty($email))
			{
				$i++;
				$message .= "Votre email est vide <br/>";
			}
        if(empty($mdp))
			{
				$i++;
				$message .= "Votre mdp est vide <br/>";
			}
			if(empty($nom))
			{
				$i++;
				$message .= "Votre nom est vide";
			}
			if (empty($prenom))
			{
				$i++;
				$message .="Votre prenom est vide <br/>";
			}
			
			if($i>0)
			{
				echo "Vous avez ".$i." erreurs<br/>";
				echo $message;
			}
			
		   $requete = $bdd->prepare("INSERT INTO prof(email,mdp,nom,prenom,lvl) VALUES(:email, :mdp, :nom, :prenom, 1)");
        
           $requete->bindValue(":email", $email, PDO::PARAM_STR);
           $requete->bindValue(":mdp", sha1($mdp), PDO::PARAM_STR);
           $requete->bindValue(":nom", $nom, PDO::PARAM_STR);
           $requete->bindValue(":prenom", $prenom, PDO::PARAM_STR);
           $requete->execute();
        
             foreach ($matiere as $key => $value)
            {
              $req1 = $bdd->prepare("INSERT INTO enseigner (id_p, id_m) VALUES (:id_p, :id_m)");
              $req1->execute([$id_p, $value]);
            }
        header('location:'.BASE_URL.'/admin_prof');
    }
            
                ?>

                
                
                
                
                
                <!--SUPPRESSION DE PROFFESSEUR -->
                
<?php
        if(isset($_POST['submitsup']))
            {
                 $recupprof = $_POST['professeur'];
                 $supprof = $bdd->query("DELETE FROM prof WHERE id_p='".$recupprof."'");
                 header('location:'.BASE_URL.'/admin_prof');
            }
        ?>
    <form method="post">
        <label class="btn btn-primary bouton1"> <u><b>Supprimer un professeur:</b></u>
            <select class="btn btn-info select_class" name="professeur">
                <?php
                        
                        $req = displayProf($bdd);
                        while($rep = $req->fetch())
                        {
                            echo"<option value=".$rep['id_p'].">".$rep['nom']." ".$rep['prenom']."</option>";
                        }
                    
                    ?>
            </select>
        </label>
        <button class="btn btn-danger" name="submitsup" type="submit">Supprimer</button>
    </form>
                
                
                
                
                
            </div>
        
    </div>

             <div class="row">
            <div class="col-xs-12">
                <a href="<?=BASE_URL;?>/admin"><button class="btn btn-primary bouton1"><span class="glyphicon glyphicon-home"></span><h4>Revenir à l'accueil</h4></button></a>
            </div>

</div>