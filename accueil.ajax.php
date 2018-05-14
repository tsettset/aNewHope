<?php
session_start();

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


  echo json_encode($array_retour);
}

if ( isset($_GET['action']) && $_GET['action'] == 'categorie'){
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

  echo json_encode($array_retour);
}
