<div class="back_admin">
        <div class="container">
          
           <div class="row row1 bouton_titre">
            <div class="col-xs-12">
               <span class="btn btn-primary bouton_titre"><h5>Gestion des matières</h5></span>
                <a href="<?=BASE_URL;?>/admin"><button class="btn btn-primary bouton_titre text-center"><span class="glyphicon glyphicon-home"></span> <h5>Revenir à l'accueil </h5></button></a>
            </div> 
           
            
          
        </div>
        <br>
        <table>
        
       
        <tr class="row">
            <td class="col-xs-12 col-md-12 onglet_eleve text-center"><h3>Matière</h3></td>
        </tr>
        
         <?php
          $req = displayAllMatiere($bdd);
            
          while($rep = $req->fetch())
          {
              echo "<tr class='row'>";
              echo "<td class='col-xs-12 col-md-12 onglet_eleve2'><h3>";
              echo $rep['nom_m']."</h3></td>";
          }
            
            
        ?>
        </table>
        
         <?php
                
                if(isset($_POST['submit']))
                {
                    $req = AddMatiere($_POST['nom_m'], $bdd);
                }
            
            ?>
        
         <div class="row">
             <div class="col-xs-12">
                 <div class="bouton1">
                   <form method='post'>
                        <label for="matiere" class="btn btn-primary bouton1"><b>Matière à ajouter: </b>
                              <input type="text" class="font_color" name="nom_m">
                          </label>
                          <button class="btn btn-success" type="submit" name="submit"><span class="glyphicon glyphicon-plus"></span><h5>Ajouter une matière</h5></button>
                      </form>
                 </div>
             </div>
         </div>
              
           
        
        
    </div>
    

</div>