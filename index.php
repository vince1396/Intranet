<?php

    define('WEBROOT', dirname(__FILE__));
    define('BASE_URL', dirname($_SERVER['SCRIPT_NAME']));
    define('ROOT', dirname(WEBROOT));
    define('DS', DIRECTORY_SEPARATOR);
    define('CORE',ROOT.DS.'core');

    if(!isset($_SESSION))
    {
      if(!isset($_GET['p']) || $_GET['p'] == "")
      {
          $page = 'accueil';
      }
      else
      {
          if(!file_exists("content/".$_GET['p'].".php"))
          {
              $page = '404';
          }
          else
          {
            $page = $_GET['p'];
          }
      }
    }
    else
    {
      if($_SESSION['lvl'] == 0)
      {
        $page = 'eleve';
      }
      elseif($_SESSION['lvl'] == 1)
      {
        $page = 'prof';
      }
      else
      {
        $page = 'admin';
      }
    }

    ob_start();//permet de ne plus renvoyer de contenu au navigateur
      require "functions.php";
      require "content/".$page.".php";
      $content = ob_get_contents();//permet de recuperer le contenu executer depuis ob_start
  	ob_end_clean();
  	require "layout.php";
?>
