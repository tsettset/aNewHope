<?php
require_once('init.inc.php');
require_once('fonctions.inc.php');


if (isset($_GET['action'])){
  if ($_GET['action']=='getvilles'){
    $retour = array();
    $retour['valide'] = 1;
    $retour['optionList']='';
    if (isset($_POST['pays']) && isset($_POST['ville'])){
      $pays_selectionne = htmlspecialchars($_POST['pays'], ENT_QUOTES);
      $ville_selectionnee = htmlspecialchars($_POST['ville'], ENT_QUOTES);
      $retour['optionList'] = getListVilleSelect($pays_selectionne, $ville_selectionnee);
      echo json_encode($retour);
    }else $retour['valide'] = 0;
  }
  if ($_GET['action']=='photosupp'){
    // $req_string = 'UPDATE photo SET .'$_POST['photo']'. = NULL WHERE id_photo = '.$_POST['photo_id'];
    // $req_suppr_photo = $bdd->query($req_string);
    $req_string = "SELECT ".$_POST['photo']." FROM photo WHERE id_photo = ".$_POST['photo_id'];
    $req_photo_url = $bdd->query($req_string);
    $result = $req_photo_url->fetch(PDO::FETCH_ASSOC);
    $nom_fichier = explode('/', $result[$_POST['photo']]);
    $nom_photo = $nom_fichier[count($nom_fichier)-1];
    $photo_dossier = RACINE_SITE . "photo/$nom_photo";
    $tab = array();
    $tab['suppFichier'] = (unlink($photo_dossier)) ? 1 : 0 ;

    $req_string = "UPDATE photo SET ".$_POST['photo']."= NULL WHERE id_photo = ".$_POST['photo_id'];
    $req_photo_url = $bdd->query($req_string);
    $tab['suppBdd'] = $req_photo_url;

    echo json_encode($tab);
  }
}


function getListVilleSelect($pays, $selectedVille){
  global $bdd;

  $villeHTML = '<select class="form-control" name="ville" id="ville">';
  $req_ville = $bdd->prepare("SELECT * FROM ville WHERE pays_id = :pays");
  $req_ville->bindValue(':pays', $pays, PDO::PARAM_INT);
  $req_ville->execute();
  $liste_ville = $req_ville->fetchAll(PDO::FETCH_OBJ);
  foreach ($liste_ville as $value) {
    $villeHTML .='<option value="'.$value->id_ville.'"';
    if ($selectedVille == $value->id_ville) {
      $villeHTML .='selected';
    }
    $villeHTML .='>'.$value->nom_ville.'</option>';
  }
  $villeHTML .='</select>';
  return $villeHTML;
}
