<?php

function laveRecherchePost($post){
  $array_retour = array();

  if(isset($post['categorie_id']) && $post['categorie_id'] !== 'na' && !empty($post['categorie_id'])){
    $array_retour['categorie_id'] = intval($post['categorie_id']);
  } else {
    $array_retour['categorie_id'] = NULL;
  }

  if(isset($post['pays']) && $post['pays'] !== 0 && !empty($post['pays'])){
    $array_retour['pays'] = intval($post['pays']);
  } else {
    $array_retour['pays'] = NULL;
  }

  if(isset($post['ville']) && $post['ville'] !== 0 && !empty($post['ville'])){
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
