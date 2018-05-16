<?php
require_once('init.inc.php');

function initRecherche(){
  $_SESSION['recherche']['orderby'] = 'date_enregistrement';
  $_SESSION['recherche']['sens'] = 'DESC';
  $_SESSION['recherche']['categorie_id'] = '';
  $_SESSION['recherche']['pays_id'] = '';
  $_SESSION['recherche']['ville'] = '';
  $_SESSION['recherche']['prixMini'] = 0;
  $_SESSION['recherche']['prixMax'] = 999999;
}

function makeSearch(){
  //lance la recherche avec les parametres actuels de session[recherche]
  //retourne la liste des id d'annonces , 0 sinon
  global $bdd;
  $and = false;
  $requete = 'SELECT id_annonce FROM annonce WHERE ';

  if (!empty($_SESSION['recherche']['categorie_id'])) {
    $requete .= 'categorie_id = '.$_SESSION['recherche']['categorie_id'].' ';
    $and = true;
  }

  if (!empty($_SESSION['recherche']['pays_id'])) {
    if ($and) $requete .= ' AND ';
    $requete .= 'pays = '.$_SESSION['recherche']['pays_id'].' ';
    $and = true;
  }

  if (!empty($_SESSION['recherche']['ville'])) {
    if ($and) $requete .= ' AND ';
    $requete .= 'ville = '.$_SESSION['recherche']['ville'].' ';
    $and = true;
  }

  if ($and) $requete .= ' AND ';
  $requete .= 'prix > '.$_SESSION['recherche']['prixMini'].' ';
  $requete .= ' AND ';
  $requete .= 'prix < '.$_SESSION['recherche']['prixMax'].' ';
  $and = true;

  $requete .= ' ORDER BY '.$_SESSION['recherche']['orderby'].' ';
  $requete .= $_SESSION['recherche']['sens'];

  $req_annonces = $bdd->query($requete);
  $annonces = $req_annonces->fetchAll(PDO::FETCH_ASSOC);

  // $annonces[count($annonces)]['id_annonce'] = $requete;

  if ($annonces && !empty($annonces)){
    return $annonces;
  }
  else return 0;

}

function laveRecherchePost($post){
  //lave un tableau de recherche de la page d'accueil et le retourne
  $array_retour = array();

  if(isset($post['categorie_id']) && $post['categorie_id'] !== 'na' && !empty($post['categorie_id'])){
    $array_retour['categorie_id'] = intval($post['categorie_id']);
  } else {
    $array_retour['categorie_id'] = NULL;
  }

  if(isset($post['pays']) && $post['pays'] !== 'na' && $post['pays'] !== 0 && !empty($post['pays'])){
    $array_retour['pays'] = intval($post['pays']);
  } else {
    $array_retour['pays'] = NULL;
  }

  if(isset($post['ville']) && $post['ville'] !== 'na' && $post['ville'] !== 0 && !empty($post['ville'])){
    $array_retour['ville'] = intval($post['ville']);
  } else {
    $array_retour['ville'] = NULL;
  }

  if(isset($post['titre']) && !empty($post['titre'])){
    $array_retour['titre'] = htmlspecialchars($post['titre'], ENT_QUOTES);
  } else {
    $array_retour['titre'] = NULL;
  }

  return $array_retour;
}

?>
