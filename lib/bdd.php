<?php
try
{
  $bdd = new PDO("mysql:host=localhost;dbname=intranet;charset=utf8","root","6283");
}
catch(Exception $e)
{
  die("erreur de connexion");
}
?>
