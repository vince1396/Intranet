<?php
    require "lib/fonction.php";
session_start();

    $pdo connexion();

    $userIp = $_SERVER['REMOTE_ADDR'];
    $limite = $pdo->query("SELECT * FROM ban WHERE ip = '$userIp'");

    if($limite){
        $limite = $limite->fetch(PDO::FETCH_ASSOC)['limite'];
    }

    $isStillBanned = strtotime($limite) > strtotime(time() - 60*5);
    if(!isStillBanned){
        unset($_SESSION['nbFailedAuth']);
        $pdo->query("DELETE FROM ban WHERE ip = '$userIp'");
    }else{
        die('Vous êtes banni');
    }

    if($_POST){
        
        $login = htmlentities($_POST['login']);
        $password = sha1($_POST['password']);
        
        $req = $pdo->prepare("SELECT COUNT(*) as nb FROM eleve WHERE email_e = ? AND password = ?");
        $req->execute([$login, $password]);
        $has = $req->fetch(PDO::FETCH_ASSOC)['nb'];
        if($has){
            header('Location: accueil.php');
            die();
        }else{
            
            if(!isset($_SESSION['nbFailedAuth'])){
                $_SESSION['nbFailedAuth'] = 1;
            }else{
                $_SESSION['nbFailedAuth'] += 1;
            }
            
            if($_SESSION['nbFailedAuth'] > 3)
            {
                $pdo->query("INSERT INTO ban (ip) VALUES('$userIp')");
            }
        }
    }

    

?>


    <form action="">
        
        <?= input('Login :' ,'text', 'login', '[required]' => 'required') ?>
        <?= input('Mdp :','password', 'password') ?>
        <?= submit('submit', 'submit') ?>
        <?= select('role', )?>
        
    </form>