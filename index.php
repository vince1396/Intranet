<?php
    
define('WEBROOT', dirname(__FILE__));
define('BASE_URL', dirname($_SERVER['SCRIPT_NAME']));
define('ROOT', dirname(WEBROOT));
define('DS', DIRECTORY_SEPARATOR);
define('CORE',ROOT.DS.'core');
    
    if(!isset($_GET['p']) || $_GET['p'] == "")
    {
        $page = 'accueil'; //Sécurise d'avantage
    }
    else
    {
        if(!file_exists("content/".$_GET['p'].".php"))
        {
            $page = '404';
        }
        else $page = $_GET['p'];
    }
    
    ob_start();//permet de ne plus renvoyer de contenu au navigateur
    require "content/".$page.".php";
    
    $content = ob_get_contents();//permet de recuperer le contenu executer depuis ob_start
	
	ob_end_clean();
	require "layout.php";
    
?>
