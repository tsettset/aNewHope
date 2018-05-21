<?php
require_once('accueil.fonctions.php');
require_once('annonce.fonctions.php');


if (isset($_GET['action'])){

  if (!isset($_SESSION['recherche'])) session_start();
  $array_retour = array();
  $array_retour['valide'] = 1;

  switch ($_GET['action']) {
    case 'categorie_id':
    if (isset($_POST['categorie_id'])){
      if ($_POST['categorie_id'] === 'na'){
        $_SESSION['recherche']['categorie_id'] = '';
      }
      $_SESSION['recherche']['categorie_id'] = intval($_POST['categorie_id']);
    }
    $array_retour['liste_annonces'] = makeSearch();
    break;

    case 'pays_id':
    if (isset($_POST['pays_id'])){
      if ($_POST['pays_id'] === 'na'){
        $_SESSION['recherche']['pays_id'] = '';
      }
      $_SESSION['recherche']['pays_id'] = intval($_POST['pays_id']);
      $_SESSION['recherche']['ville'] = '';
    }
    $array_retour['liste_annonces'] = makeSearch();
    break;

    case 'ville':
    if (isset($_POST['ville'])){
      if ($_POST['ville'] === 'na'){
        $_SESSION['recherche']['ville'] = '';
      }
      $_SESSION['recherche']['ville'] = intval($_POST['ville']);
    }
    $array_retour['liste_annonces'] = makeSearch();
    break;

    case 'f' :
    if (isset ($_POST['p']) && $_POST['p'] === 'na'){
      $array_retour['liste_annonces'] = makeSearch();
    } else {
      $array_retour['liste_annonces'] = 0;
    }
    break;

    case 'orderby':
    if (isset($_POST['orderby'])){
      $_SESSION['recherche']['orderby'] = $_POST['orderby'];
    }
    $array_retour['liste_annonces'] = makeSearch();
    break;

    case 'sens':
    if (isset($_POST['sens'])){
      $_SESSION['recherche']['sens'] = $_POST['sens'];
    }
    $array_retour['liste_annonces'] = makeSearch();
    break;

    case 'prix_min':
    if (isset($_POST['prix_min']) && intval($_POST['prix_min']) > 0 && ($_POST['prix_min'] !== '') ) {
      $_SESSION['recherche']['prixMini'] = intval($_POST['prix_min']);
    } else {
      $_SESSION['recherche']['prixMini'] = 0;
      $array_retour['liste_annonces'] = 0;
    }
    $array_retour['liste_annonces'] = makeSearch();
    break;

    case 'prix_max':
    if (isset($_POST['prix_max']) && intval($_POST['prix_max']) < 999999 && ($_POST['prix_max'] !== '') ) {
      $_SESSION['recherche']['prixMax'] = intval($_POST['prix_max']);
    } else {
      $_SESSION['recherche']['prixMax'] = 999999;
      $array_retour['liste_annonces'] = 0;
    }
    $array_retour['liste_annonces'] = makeSearch();
    break;

    case 'titre':
    if (isset($_POST['titre'])){
      if (strlen($_POST['titre']) > 2){
        $_SESSION['recherche']['titre'] = htmlspecialchars($_POST['titre'], ENT_QUOTES);
      } else {
        $_SESSION['recherche']['titre'] = '';
      }
    } else {
      $_SESSION['recherche']['titre'] = '';
    }
    $array_retour['liste_annonces'] = makeSearch();
    break;

    case 'pseudo':
    if (isset($_POST['pseudo'])){
      if (strlen($_POST['pseudo']) > 2){
        $_SESSION['recherche']['pseudo'] = htmlspecialchars($_POST['pseudo'], ENT_QUOTES);
      } else {
        $_SESSION['recherche']['pseudo'] = '';
      }
    } else {
      $_SESSION['recherche']['pseudo'] = '';
    }
    $array_retour['liste_annonces'] = makeSearch();
    break;

    case 'reset':
    if (isset($_POST['p']) && $_POST['p'] == 'titre'){
      $_SESSION['recherche']['titre'] = '';
    }
    $array_retour['liste_annonces'] = makeSearch();
    break;

    default:
    $array_retour['liste_annonces'] = 0;
    break;
  }

  if (!isset($array_retour['liste_annonces'])){
    $array_retour['liste_annonces'] = 0;
  }

  if ($array_retour['liste_annonces'] !== 0){
    for ($i=0; $i < count($array_retour['liste_annonces'])-1 ; $i++) {
      $array_retour['liste_annonces'][$i]['annonce']= getAnnonce($array_retour['liste_annonces'][$i]['id_annonce']);
    }
  }

  echo json_encode($array_retour);
}


/*
$_SESSION['recherche']['orderby'] = 'date_enregistrement DESC';
$_SESSION['recherche']['categorie_id'] = '';
$_SESSION['recherche']['pays_id'] = '';
$_SESSION['recherche']['ville'] = '';
$_SESSION['recherche']['prixMini'] = 0;
$_SESSION['recherche']['prixMax'] = 99999;*/
