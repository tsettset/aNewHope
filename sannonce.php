<?php

require_once('init.inc.php');
require_once('fonctions.inc.php');
require_once('header.inc.php');
require_once('fannonce.fonctions.php');
require_once('navbar.php');

// debug($_SESSION);

if (!isset($_SESSION['id_membre'])){
  degage();
}
if (!isset($_GET['id_annonce'])){
  degage();
}
$annonce = getIdAnnonce(intval($_GET['id_annonce']));

if(!$annonce){
  degage();
}


global $bdd;
try{
  $req_supp = $bdd->query("DELETE FROM annonce WHERE id_annonce = $annonce");
} catch(Exception $e){
  degage();
}




?>
<div class="container">
  <div class="row text-center">
    Ok annonce Supprimee
  </div>
  <div class="row text-center">
    <a href="accueil.php" title="annonces">Chercher une annonce</a>
    <a href="fannonce.php?action=c" title="creation">Deposer une annonce</a>
  </div>
</div>
<?php
require_once('footer.php');
