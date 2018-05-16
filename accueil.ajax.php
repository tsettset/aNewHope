<?php
require_once('accueil.fonctions.php');
require_once('annonce.fonctions.php');


if (isset($_GET['action'])){

  if (!isset($_SESSION['recherche'])) session_start();
  $array_retour = array();
  $array_retour['valide'] = 1;

  switch ($_GET['action']) {
    case 'categorie_id':
    if ($_POST['categorie_id'] === 'na'){
        $_SESSION['recherche']['categorie_id'] = '';
    }
    $_SESSION['recherche']['categorie_id'] = intval($_POST['categorie_id']);
    $array_retour['liste_annonces'] = makeSearch();
    break;

    case 'pays_id':
    if ($_POST['pays_id'] === 'na'){
        $_SESSION['recherche']['pays_id'] = '';
    }
    $_SESSION['recherche']['pays_id'] = intval($_POST['pays_id']);
    $array_retour['liste_annonces'] = makeSearch();
    break;

    case 'ville':
    if ($_POST['ville'] === 'na'){
        $_SESSION['recherche']['ville'] = '';
    }
    $_SESSION['recherche']['ville'] = intval($_POST['ville']);
    $array_retour['liste_annonces'] = makeSearch();
      break;

    case 'f' :
    if (isset ($_POST['p']) && $_POST['p'] === 'na'){
        $array_retour['liste_annonces'] = makeSearch();
    }
    break;

    default:
    $array_retour['liste_annonces'] = 0;
    break;
  }

  if ($array_retour['liste_annonces'] !== 0){
    for ($i=0; $i < count($array_retour['liste_annonces']) ; $i++) {
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
