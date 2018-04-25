<?php
require_once('init.inc.php');
require_once('fonctions.inc.php');


if (isset($_GET['action']) && $_GET['action']=='getvilles'){
  $retour = array();
  $retour['valide'] = 1;
  $retour['optionList']='';
  if (isset($_POST['pays']) && isset($_POST['ville'])){
    $pays_selectionne = htmlspecialchars($_POST['pays']);
    $ville_selectionnee = htmlspecialchars($_POST['ville']);
    $retour['optionList'] = getListVilleSelect($pays_selectionne, $ville_selectionnee);
    echo json_encode($retour);
  }else $retour['valide'] = 0;
}


function getListVilleSelect($pays, $selectedVille){
  global $bdd;

  $villeHTML = '<select class="form-control" name="ville" id="ville">';
  $req_ville = $bdd->prepare("SELECT * FROM ville WHERE id_pays = :pays");
  $req_ville->bindValue(':pays', $pays, PDO::PARAM_INT);
  $req_ville->execute();
  $liste_ville = $req_ville->fetchAll(PDO::FETCH_OBJ);
  foreach ($liste_ville as $value) {
    $villeHTML .='<option value="'.$value->id_ville.'"';
    if ($selectedVille == $value->id_ville) {
      $villeHTML .='selected';
    }
    $villeHTML .='>'.$value->nom.'</option>';
  }
  $villeHTML .='</select>';
  return $villeHTML;
}
