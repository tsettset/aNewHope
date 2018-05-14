<?php

function getAnnonce($idAnnonce){
  global $bdd;
  $req_annonce = $bdd->prepare("SELECT * FROM annonce WHERE id_annonce=:id");
  $req_annonce->bindValue(':id', $idAnnonce, PDO::PARAM_INT);
  $req_annonce->execute();
  $tab_annonce = $req_annonce->fetch(PDO::FETCH_ASSOC);

  $req_photos = $bdd->query("SELECT photo1, photo2, photo3, photo4, photo5 FROM photo WHERE id_photo=".$tab_annonce['photo_id']);
  $photos = $req_photos->fetch(PDO::FETCH_ASSOC);
  $tab_annonce['photos'] = $photos;

  $req_categorie = $bdd->query("SELECT titre, motscles FROM categorie WHERE id_categorie=".$tab_annonce['categorie_id']);
  $categorie = $req_categorie->fetch(PDO::FETCH_ASSOC);
  $tab_annonce['nom_categorie']=$categorie['titre'];
  $tab_annonce['motscles']=$categorie['motscles'];

  $req_membre = $bdd->query("SELECT pseudo FROM membre WHERE id_membre=".$tab_annonce['membre_id']);
  $membre = $req_membre->fetch(PDO::FETCH_ASSOC);
  $tab_annonce['pseudo'] = $membre['pseudo'];

  $req_pays = $bdd->query("SELECT nom FROM pays WHERE id_pays=".$tab_annonce['pays']);
  $nom_pays = $req_pays->fetch(PDO::FETCH_ASSOC);
  $tab_annonce['pays'] = $nom_pays['nom'];

  $req_ville = $bdd->query("SELECT nom_ville FROM ville WHERE id_ville=".$tab_annonce['ville']);
  $nom_ville = $req_ville->fetch(PDO::FETCH_ASSOC);
  $tab_annonce['ville'] = $nom_ville['nom_ville'];

  $req_commentaires = $bdd->query("SELECT * FROM commentaire WHERE annonce_id=".$tab_annonce['id_annonce']." ORDER BY date_enregistrement DESC");
  $tab_annonce['commentaires'] = $req_commentaires->fetchAll(PDO::FETCH_ASSOC);
  return ($tab_annonce);
}

function getPseudoMembre($id_membre){
  global $bdd;
  $req_pseudo = $bdd->query("SELECT pseudo FROM membre WHERE id_membre=".$id_membre);
  $pseudo = $req_pseudo->fetch(PDO::FETCH_ASSOC);
  return ($pseudo['pseudo']);
}

function insertCommentaire($commentaire, $id_annonce, $id_membre){
  global $bdd;
  $return_message = 'Basic';
  $allowInsert = true;

  try{
    $req_dernier_comm = $bdd->prepare("SELECT date_enregistrement FROM commentaire WHERE membre_id = :id_membre AND annonce_id = :id_annonce ORDER BY date_enregistrement DESC LIMIT 1");
    $req_dernier_comm->bindValue(':id_membre', intval($id_membre), PDO::PARAM_INT);
    $req_dernier_comm->bindValue(':id_annonce', intval($id_annonce), PDO::PARAM_INT);
    $req_dernier_comm->execute();

    if ($req_dernier_comm->rowCount() > 0){
      $dernier_comm = $req_dernier_comm->fetch(PDO::FETCH_OBJ);
      $reqtempo_string = "SELECT TIMESTAMPDIFF(MINUTE, '$dernier_comm->date_enregistrement', NOW());";
      $req_tempo = $bdd->query($reqtempo_string);
      $tempo = $req_tempo->fetch(PDO::FETCH_NUM );
      if ($tempo[0] < 2) {
        $allowInsert = false;
        $return_message = '<em style="color:red">Veuillez attendre au moins 2 minutes avant votre nouveau commentaire sur la meme annonce.</em>';
      }
    }

    if ($allowInsert){
      $comm_filtre = htmlspecialchars($commentaire, ENT_QUOTES);
      $req_comm = $bdd->prepare("INSERT INTO commentaire (commentaire, membre_id, annonce_id, date_enregistrement)
      VALUES (:commentaire, :membre_id, :annonce_id, NOW());");
      $req_comm->bindValue(':commentaire', $comm_filtre, PDO::PARAM_STR);
      $req_comm->bindValue(':membre_id', $id_membre, PDO::PARAM_INT);
      $req_comm->bindValue(':annonce_id', $id_annonce, PDO::PARAM_INT);
      $insert_result = $req_comm->execute();
      $return_message = 'Ok, commentaire ajoute, l\'auteur de l\'annonce en sera notifie.';
    }

  }
  catch(Exception $e){
    echo "Erreur ! ".$e->getMessage();
    die();
  }
  return ($return_message);
}
?>
