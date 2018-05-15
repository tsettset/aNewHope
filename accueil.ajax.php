<?php
session_start();
<<<<<<< Updated upstream
$_SESSION['recherche']['orderby'] = 'date_enregistrement DESC';
$_SESSION['recherche']['categorie'] = '';
$_SESSION['recherche']['pays'] = '';
$_SESSION['recherche']['ville'] = '';
$_SESSION['recherche']['prixMini'] = 0;
$_SESSION['recherche']['prixMax'] = 99999;

if ( isset($_GET['action']) && $_GET['action'] == 'searchAnnonces'){
  if (!isset($_SESSION['cpt'])){
    $_SESSION['cpt'] = 0;
  }
  $sessionInt = intval($_SESSION['cpt']);
  $sessionInt++;
  $_SESSION['cpt'] = $sessionInt;
  $array_retour = array();
  $array_retour['valide'] = 1;
  $array_retour['optionList'][0]= 'Annonce HOLDER' . $_SESSION['cpt'];
  $array_retour['optionList'][1]= 'Annonce HOLDER' . $_SESSION['cpt'];

=======
function initRecherche(){
  $_SESSION['recherche']['orderby'] = 'date_enregistrement DESC';
  $_SESSION['recherche']['categorie'] = '';
  $_SESSION['recherche']['pays'] = '';
  $_SESSION['recherche']['ville'] = '';
  $_SESSION['recherche']['prixMini'] = 0;
  $_SESSION['recherche']['prixMax'] = 99999;
}

if ( isset($_GET['action']) && $_GET['action'] == 'searchAnnonces'){

  $array_retour = array();
  $array_retour['valide'] = 1;
  $array_retour['post'] = $_POST;
>>>>>>> Stashed changes

  echo json_encode($array_retour);
}

if ( isset($_GET['action']) && $_GET['action'] == 'categorie'){
<<<<<<< Updated upstream
  if (!isset($_SESSION['cpt'])){
    $_SESSION['cpt'] = 0;
  }
  $sessionInt = intval($_SESSION['cpt']);
  $sessionInt++;
  $_SESSION['cpt'] = $sessionInt;
  $array_retour = array();
  $array_retour['valide'] = 1;
  $array_retour['optionList'][0] = 'Annonce HOLDER ' . $_SESSION['cpt'];
  $array_retour['optionList'][1] = 'Annonce HOLDER ' . $_SESSION['cpt'];
  $array_retour['optionList'][2] = 'Annonce HOLDER ' . $_SESSION['cpt'];
=======

  $array_retour = array();
  $array_retour['valide'] = 1;
  $array_retour['post'] = $_POST;
>>>>>>> Stashed changes

  echo json_encode($array_retour);
}
