 <?php

function getListCategoriesOption($selectedCategorie){//renvoie la liste des pays dans un <select><option>
  global $bdd;
  $categoriesHTML = '<option value="na"';
  if ($selectedCategorie == 0){
    $categoriesHTML .= ' selected';
  }
  $categoriesHTML .= '>Selectionnez une categorie</option>';
  $req_categories = $bdd->query("SELECT id_categorie,titre FROM categorie ORDER BY titre ASC");
  $categories = $req_categories->fetchAll(PDO::FETCH_OBJ);
  foreach ($categories as $value) {
    $categoriesHTML .= '<option value="'.$value->id_categorie.'"';
    if ($selectedCategorie == $value->id_categorie){
      $categoriesHTML .= ' selected';
    }
    $categoriesHTML .= '>'.$value->titre.'</option>';
  }
  return $categoriesHTML;
}

function getListPaysOption($selectedPays){//renvoie la liste des pays dans un <select><option>
  global $bdd;
  $paysHTML = '<option value="na">---</option>';
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

function uploadPhoto($tmp, $dossier){
  //echo '<hr>uploadPhoto<br>'.$tmp.' - '.$dossier.'<hr>';
  copy($tmp, $dossier);
}

function insertionAnnonce($check, $photos){//Envoi vers la bdd - retourne l'id_annonce si reussite, 0 sinon
  //debug($check);
  // debug($photos);
  global $bdd;
  try{
    if( count($photos) > 0){
      $req_photo_str = 'INSERT INTO photo (photo1) VALUES (:url)';
      $req_photo = $bdd->prepare($req_photo_str);
      $req_photo->bindValue(':url', $photos[0]);
      $req_photo->execute();
      $id_photos = $bdd->lastInsertId();
      if( count($photos) > 1){
        for($i=1; $i < count($photos); $i++){
          $num_photo = $i+1;
          $nom_photo = 'photo'. $num_photo;
          $req_photo_str = 'UPDATE photo SET '. $nom_photo .' = :temp WHERE id_photo = '.$id_photos;
          $req_photo = $bdd->prepare($req_photo_str);
          $req_photo->bindValue(':temp', $photos[$i]);
          $req_photo->execute();
        }
      }
    }
    $req_insert = $bdd->prepare(
      "INSERT INTO annonce (titre, description_courte, description_longue, prix, pays, ville, adresse, cp, date_enregistrement, membre_id, categorie_id)
      VALUES (:titre, :description_courte, :description_longue, :prix, :pays, :ville, :adresse, :cp, NOW(), :membre_id, :categorie_id);");

      $req_insert->bindValue(':titre', $check['titre'], PDO::PARAM_STR);
      $req_insert->bindValue(':description_courte', $check['description_courte'], PDO::PARAM_STR);
      $req_insert->bindValue(':description_longue', $check['description_longue'], PDO::PARAM_STR);
      $prixFloat = (float)$check['prix'];
      $req_insert->bindValue(':prix', $prixFloat);
      $req_insert->bindValue(':pays', $check['pays'], PDO::PARAM_STR);
      $req_insert->bindValue(':ville', $check['ville'], PDO::PARAM_STR);
      $req_insert->bindValue(':adresse', $check['adresse'], PDO::PARAM_STR);
      $req_insert->bindValue(':cp', $check['code_postal'], PDO::PARAM_INT);
      $req_insert->bindValue(':membre_id', $check['id_membre']);
      $req_insert->bindValue(':categorie_id', $check['categorie_id'], PDO::PARAM_INT);
      $req_insert->execute();
      if (isset($id_photos)){
        $id_annonce = $bdd->lastInsertId();
        $req_link_photos = $bdd->query("UPDATE annonce SET photo_id = $id_photos WHERE id_annonce = $id_annonce");
      }

    } catch (Exception $e) {
      echo 'Exception reçue : ',  $e->getMessage(), "<br>";
    }
    return (isset($id_annonce)) ? $id_annonce : 0;
  }

  function modifAnnonce($check, $photos_bdd){
    //debug($check);
    global $bdd;
    try{
      $req_insert = $bdd->prepare(
        "UPDATE annonce SET
        titre = :titre,
        description_courte = :description_courte,
        description_longue = :description_longue,
        prix = :prix,
        pays = :pays,
        ville = :ville,
        adresse = :adresse,
        cp = :cp,
        date_enregistrement = NOW(),
        membre_id = :membre_id,
        categorie_id = :categorie_id
        WHERE id_annonce = :id_annonce ;");
        $req_insert->bindValue(':titre', $check['titre'], PDO::PARAM_STR);
        $req_insert->bindValue(':description_courte', $check['description_courte'], PDO::PARAM_STR);
        $req_insert->bindValue(':description_longue', $check['description_longue'], PDO::PARAM_STR);
        $prixFloat = (float)$check['prix'];
        $req_insert->bindValue(':prix', $prixFloat);
        $req_insert->bindValue(':pays', $check['pays'], PDO::PARAM_STR);
        $req_insert->bindValue(':ville', $check['ville'], PDO::PARAM_STR);
        $req_insert->bindValue(':adresse', $check['adresse'], PDO::PARAM_STR);
        $req_insert->bindValue(':cp', $check['code_postal'], PDO::PARAM_INT);
        $req_insert->bindValue(':membre_id', $check['id_membre'], PDO::PARAM_INT);
        $req_insert->bindValue(':categorie_id', $check['categorie_id'], PDO::PARAM_INT);
        $req_insert->bindValue(':id_annonce', $check['id_annonce'], PDO::PARAM_STR);
        $req_insert->execute();
        if (isset($check['photo_id'])){
          $id_photos = $check['photo_id'];
          $id_annonce = $check['id_annonce'];
          $req_link_photos = $bdd->query("UPDATE annonce SET photo_id = $id_photos WHERE id_annonce = $id_annonce");
        }
        $req_get_photos = $bdd->query("SELECT * FROM photo WHERE id_photo = '$id_photos'");
        $photosList = $req_get_photos->fetch(PDO::FETCH_ASSOC);
        $i=0;
        foreach ($photos_bdd as $value) {
          do {
            $i++;
          }while(!empty($photosList['photo'.$i]));

          $req_photos_str = 'UPDATE photo SET photo'.$i.' = \''.$value.'\' WHERE id_photo = :id';
          $req_update_photo = $bdd->prepare($req_photos_str);
          $req_update_photo->bindValue(':id', $id_photos, PDO::PARAM_STR);
          $req_update_photo->execute();
        }

      } catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "<br>";
      }
      return (isset($check['id_annonce'])) ? $check['id_annonce'] : 0;
    }

    function getIdAnnonce($id_annonce){
      global $bdd;
      $req_annonce = $bdd->prepare("SELECT * FROM annonce WHERE id_annonce = :id");
      $req_annonce->bindValue(':id', $id_annonce);
      $req_annonce->execute();
      $annonce = $req_annonce->fetch(PDO::FETCH_ASSOC);
      return ($annonce['id_annonce']);
    }

    function getAnnonceModif($id_annonce, $tab){
      global $bdd;
      $req_annonce = $bdd->prepare("SELECT * FROM annonce WHERE id_annonce = :id");
      $req_annonce->bindValue(':id', $id_annonce, PDO::PARAM_INT);
      $req_annonce->execute();
      $annonce = $req_annonce->fetch(PDO::FETCH_ASSOC);
      foreach ($annonce as $key => $value) {
        $tab[$key] = $value;
      }

      $photo_id = $tab['photo_id'];
      $req_photos = $bdd->query("SELECT * FROM photo WHERE id_photo = '$photo_id'");
      $photos = $req_photos->fetch(PDO::FETCH_ASSOC);
      // debug($photos);
      if (!empty($photos)){
        foreach ($photos as $key => $value) {
          $tab[$key] = $value;
        }
      }
      return $tab;
    }

    function checkAnnonce($tab, $post, $files){
      //fonction qui nettoie et valide les input passes dans le $post
      //renvoie un tableau contenant les variables nettoyees et les index :
      //          - 'message' contient les messages d'erreur
      //          - 'valide' contient 1 si le tableau peut etre enregistre dans la bdd, 0 sinon
      // debug($post);
      // debug($files);
      extract($post);

      $tab['valide'] = 1;
      //---------------- Titre annonce ------------
      if (isset($titre)){
        $titre = htmlspecialchars($titre, ENT_QUOTES);
        $tab['titre'] = $titre;
        if (strlen($titre) > 255){
          $tab['message'] .= 'Titre de l\'annonce trop long <br>';
          $tab['valide'] = 0;
        }
        elseif (strlen($titre) < 3){
          $tab['message'] .= 'Le titre de l\'annonce est trop court<br>';
          $tab['valide'] = 0;
        }
      } else {
        $tab['message'] .= 'Le titre ne peut pas etre vide<br>';
        $tab['valide'] = 0;
      }

      //---------------- Description courte ------------
      if (isset($description_courte)){
        $description_courte = htmlspecialchars($description_courte, ENT_QUOTES);
        $tab['description_courte'] = $description_courte;
        if (strlen($description_courte) > 255){
          $tab['message'] .= 'Description courte de l\'annonce trop longue <br>';
          $tab['valide'] = 0;
        }
      }

      //---------------- Description longue ------------
      if (isset($description_longue)){
        $description_longue = htmlspecialchars($description_longue, ENT_QUOTES);
        $tab['description_longue'] = $description_longue;
      }

      //---------------- Prix ------------
      if (isset($prix)){
        $tab['prix'] = $prix;
        if (!is_numeric($prix)){
          $tab['valide'] = 0;
          $tab['message'] .= 'Le prix entre n\'est pas un chiffre.<br>';
        } else {
          if ( $prix > 99999){
            $tab['valide'] = 0;
            $tab['message'] .= 'Nous n\'autorisons pas des annonces au prix superieur a 99999.<br>';
          }
        }
      }else {
        $tab['message'] .= '';
        $tab['valide'] = 0;
      }

      //---------------- Selection categorie ------------
      if (isset($categorie_id)){
        $tab['categorie_id'] = $categorie_id;
        if ($categorie_id == 'na') {
          $tab['message'] .= 'Veuillez selectionner une categorie<br>';
          $tab['valide'] = 0;
        }
      }else {
        $tab['message'] .= '';
        $tab['valide'] = 0;
      }


      //---------------- Photo ------------
      for ($i=1; $i<6; $i++){
        if(!empty($files['photo'.$i]['name'])){
          $tmp_tab = explode('/',$files['photo'.$i]['tmp_name']);
          $tmp_name = $tmp_tab[count($tmp_tab)-1];
          $nom_photo = $tmp_name.$files['photo'.$i]['name'];
          $photo_bdd = URL . "photo/$nom_photo";
          $photo_dossier = RACINE_SITE . "photo/$nom_photo";
          $tab['photo'][$i]['photo_dossier'] = $photo_dossier;
          $tab['photo'][$i]['photo_bdd'] = $photo_bdd;
          $tab['photo'][$i]['photo_tmp'] = $files['photo'.$i]['tmp_name'];
        }
      }




      //---------------- Adresse annonce------------
      if (isset($adresse)){
        $adresse = htmlspecialchars($adresse, ENT_QUOTES);
        $tab['adresse'] = $adresse;
        if (strlen($adresse) > 50){
          $tab['message'] .= 'L\'Adresse de l\'annonce est trop longue -- (limite a 50 caracteres) <br>';
          $tab['valide'] = 0;
        }
      }

      //---------------- Ville annonce------------
      if (isset($ville)){
        $ville = htmlspecialchars($ville, ENT_QUOTES);
        $tab['ville'] = $ville;
        if (strlen($ville) > 20){
          $tab['message'] .= 'Ville de l\'annonce trop longue <br>';
          $tab['valide'] = 0;
        }
      }

      //---------------- CP annonce------------
      if (isset($code_postal)){
        $code_postal = htmlspecialchars($code_postal, ENT_QUOTES);
        $tab['code_postal'] = $code_postal;
        if (strlen($code_postal) > 5){
          $tab['message'] .= 'Code Postal de l\'annonce trop long <br>';
          $tab['valide'] = 0;
        }
      }

      //---------------- Pays annonce------------
      if (isset($pays)){
        $pays = htmlspecialchars($pays, ENT_QUOTES);
        $tab['pays'] = $pays;
        if (strlen($pays) > 20){
          $tab['message'] .= 'Pays de l\'annonce trop long <br>';
          $tab['valide'] = 0;
        }
      }

      //$tab['status'] = 'c';
      return $tab;
    }// --- fin checkAnnonce()
