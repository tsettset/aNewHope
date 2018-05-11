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
  $req_commentaires = $bdd->query("SELECT * FROM commentaire WHERE annonce_id=".$tab_annonce['id_annonce']." ORDER BY date_enregistrement");
  $tab_annonce['commentaires'] = $req_commentaires->fetchAll(PDO::FETCH_ASSOC);
  return ($tab_annonce);
}

function getPseudoMembre($id_membre){
  global $bdd;
  $req_pseudo = $bdd->query("SELECT pseudo FROM membre WHERE id_membre=".$id_membre);
  $pseudo = $req_pseudo->fetch(PDO::FETCH_ASSOC);
  return ($pseudo['pseudo']);
}


?>
