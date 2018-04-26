<?php

function getListCategoriesOption($selectedCategorie){
  global $bdd;
  $categoriesHTML = '<option value="na">Selectionnez une categorie</option>';
  $req_categories = $bdd->query("SELECT id_categorie,titre FROM categorie");
  $categories = $req_categories->fetchAll(PDO::FETCH_OBJ);
  foreach ($categories as $value) {
    $categoriesHTML .= '<option value="'.$value->id_categorie.'"';
    if ($selectedCategorie == $value->id_categorie){
      $categoriesHTML .= 'selected';
    }
    $categoriesHTML .= '>'.$value->titre.'</option>';
  }
  return $categoriesHTML;
}

function getListPaysOption($selectedPays){
  global $bdd;
  $paysHTML = '<option value="na">Selectionnez un pays</option>';
  $req_pays = $bdd->query("SELECT * FROM pays");
  $pays = $req_pays->fetchAll(PDO::FETCH_OBJ);
  foreach ($pays as $value) {
    $paysHTML .= '<option value="'.$value->id_pays.'"';
    if ($selectedPays == $value->id_pays){
      $paysHTML .= 'selected';
    }
    $paysHTML .= '>'.$value->nom.'</option>';
  }
  return $paysHTML;
}



function checkAnnonce($post, $files){
  //fonction qui nettoie et valide les input passes dans le $post
  //renvoie un tableau contenant les variables nettoyees et les index :
  //          - 'message' contient les messages d'erreur
  //          - 'valide' contient 1 si le tableau peut etre enregistre dans la bdd, 0 sinon
  //debug($post);
  extract($post);
  $tab = array();
  $tab['message'] = '';
  $tab['valide'] = 1;
  //---------------- Titre annonce ------------
  if (isset($titre)){
    $titre = htmlspecialchars($titre);
    $tab['titre'] = $titre;
    if (strlen($titre) > 255){
      $tab['message'] .= 'Titre de l\'annonce trop long <br>';
      $tab['valide'] = 0;
    }
    elseif (strlen($titre) < 1){
      $tab['message'] .= 'Le titre de l\'annonce ne peut pas etre vide<br>';
      $tab['valide'] = 0;
    }
  } else {
    $tab['message'] .= 'Le titre de l\'annonce ne peut pas etre vide<br>';
    $tab['valide'] = 0;
  }

  //---------------- Description courte ------------
  if (isset($description_courte)){
    $description_courte = htmlspecialchars($description_courte);
    $tab['description_courte'] = $description_courte;
    if (strlen($description_courte) > 255){
      $tab['message'] .= 'Description courte de l\'annonce trop longue <br>';
      $tab['valide'] = 0;
    }
  }

  //---------------- Description longue ------------
  if (isset($description_longue)){
    $description_longue = htmlspecialchars($description_longue);
    $tab['description_longue'] = $description_longue;
  }

  //---------------- Prix ------------
  if (isset($prix)){
    $tab['prix'] = $prix;
    if (!is_numeric($prix)){
      $tab['valide'] = 0;
      $tab['message'] .= 'Le prix entre n\'est pas un chiffre.<br>';
    }
  }

  //---------------- Selection categorie ------------
  if (isset($categorie)){
    $tab['categorie'] = $categorie;
    if ($categorie == 'na') {
      $tab['message'] .= 'Veuillez selectionner une categorie<br>';
      $tab['valide'] = 0;
    }
  }


  //---------------- Photo ------------
  /*for ($i=1;$i<6;$i++){
    $nomPhoto = 'photo'.$i;
    if(!empty($_FILES['$nomPhoto']['name'])){
      echo 'dans le if photo';
    } else{echo $nomPhoto.' : PAS DANS LE IF !!! ';}
  }*/


  //---------------- Adresse annonce------------
  if (isset($addresse)){
    $addresse = htmlspecialchars($addresse);
    $tab['addresse'] = $addresse;
    if (strlen($addresse) > 50){
      $tab['message'] .= 'Adresse l\'annonce trop longue <br>';
      $tab['valide'] = 0;
    }
  }

  //---------------- Ville annonce------------
  if (isset($ville)){
    $ville = htmlspecialchars($ville);
    $tab['ville'] = $ville;
    if (strlen($ville) > 20){
      $tab['message'] .= 'Ville de l\'annonce trop longue <br>';
      $tab['valide'] = 0;
    }
  }

  //---------------- CP annonce------------
  if (isset($code_postal)){
    $code_postal = htmlspecialchars($code_postal);
    $tab['code_postal'] = $code_postal;
    if (strlen($code_postal) > 5){
      $tab['message'] .= 'Code Postal de l\'annonce trop long <br>';
      $tab['valide'] = 0;
    }
  }

  //---------------- Pays annonce------------
  if (isset($pays)){
    $pays = htmlspecialchars($pays);
    $tab['pays'] = $pays;
    if (strlen($pays) > 20){
      $tab['message'] .= 'Pays de l\'annonce trop long <br>';
      $tab['valide'] = 0;
    }
  }
  return $tab;
}// --- fin checkAnnonce()
