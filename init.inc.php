<?php
//---------------------CONNEXION BDD
try{
  global $bdd;
  $bdd = new PDO('mysql:host=localhost; dbname=troc','root', 'root', array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
}// trocster - vXsRVoa16x4ro8YM
catch (Exception $e)
{

  echo 'erreur de connexion sql !', $e->getMessage();
  die();
}
//debug($bdd);

//-------------------- SESSION
try{
session_start();
}
catch (Exception $e){
  echo 'session not start';
}



//-------------------- CHEMIN

define("RACINE_SITE", $_SERVER['DOCUMENT_ROOT']. "/projettroc/");///projettroc/
/* cette constante retourne le chemin physique du dossier boutique sur le serveur
Lors de l'enregistrement d'images / photos, nous aurons besoin du chemin complet du dossier photo pour enregistrer la photo */

define("URL", 'http://hatemdourai.pw/projettroc/');

//cette constante nous servira à enregistrer l'URL d'une photo / image dans la BDD, on ne conserve jamais la photo elle même, ce serait trop lourd pour la BDD

//---------- VARIABLE

$content = '';
define("SITENAME", 'A new hope pour votre portefeuille'); //nom du site qui sera utilise sur les pages dans le title

//---------------REDIRIGER LA PAGE

/*$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'boutique.php';*/

//------------

//require_once("fonctions.inc.php");
//test
?>
