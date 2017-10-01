<?php
  if(isset($_POST['admin']))
  {
    extract($_POST);
    echo multipleLogin($email, $mdp, 2, $bdd);
  }
  elseif (isset($_POST['prof']))
  {
    extract($_POST);
    echo multipleLogin($email, $mdp, 1, $bdd);
  }
  elseif (isset($_POST['eleve']))
  {
    extract($_POST);
    echo multipleLogin($email, $mdp, 0, $bdd);
  }
?>

<?php
if(isset($_SESSION['lvl']))
{
    if($_SESSION['lvl'] == 0)
    {
      header("Location:".BASE_URL."/eleve");
    }
    elseif($_SESSION['lvl'] == 1)
    {
      header("Location:".BASE_URL."/professeur");
    }
    elseif($_SESSION['lvl'] == 2)
    {
      header("Location:".BASE_URL."/admin");
    }
    else
    {
      echo "Error lvl";
    }
}
else
{ ?>
<div class="corps">
  <div class="container">
    <div class="row">

        <div class="col-md-4 col-xs-12">
            <div class="case1">
                <h3  class="role"><span class="glyphicon glyphicon-king"></span> Administrateurs</h3>
                <br>
                <form class="form-horizontal" action="#" method="POST">
                    <div class="form-group">
                        <div class="col-sm-8">
                          <input type="email" name="email" class="form-control connexion" id="inputEmail3" placeholder="Email">
                        </div>
                        <div class="col-sm-8">
                          <input type="password" name="mdp" class="form-control connexion" id="inputEmail3" placeholder="Mot de passe">
                        </div>
                        <div class="col-sm-8">
                          <button type="submit" name="admin" class="btn btn-info bouton_submit">Se connecter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="case1"><h3 class="role"><span class="glyphicon glyphicon-queen"></span> Professeurs</h3><bR>
                <form class="form-horizontal" action="#" method="POST">
                    <div class="form-group">
                        <div class="col-sm-8">
                          <input type="email" name="email" class="form-control connexion" id="inputEmail3" placeholder="Email">
                        </div>
                        <div class="col-sm-8">
                          <input type="password" name="mdp" class="form-control connexion" id="inputEmail3" placeholder="Mot de passe">
                        </div>
                         <div class="col-sm-8">
                          <button type="submit" name ="prof" class="btn btn-info bouton_submit">Se connecter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-4 col-xs-12">
            <div class="case1">
                <h3  class="role"><span class="glyphicon glyphicon glyphicon-pawn"></span> Elèves</h3><BR>
                <form class="form-horizontal" action="#" method="POST">
                    <div class="form-group">
                        <div class="col-sm-8">
                            <input type="email" name="email" class="form-control connexion" id="inputEmail3" placeholder="Email">
                        </div>
                        <div class="col-sm-8">
                            <input type="password" name="mdp" class="form-control connexion" id="inputEmail3" placeholder="Mot de passe">
                        </div>
                         <div class="col-sm-8">
                           <button type="submit" name="eleve" class="btn btn-info bouton_submit">Se connecter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
  </div>
</div>
<?php } ?>
