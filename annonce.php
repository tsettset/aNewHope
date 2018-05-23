<?php
require_once('init.inc.php');
require_once('fonctions.inc.php');
require_once('header.inc.php');
require_once('annonce.fonctions.php');
require_once('navbar.php');
require_once('footer.php');

$annonce = array ();
$comm_msg = '';
if(isset($_GET['id']) && !empty($_GET['id'])){

  if(isset($_POST['post_comment']) && !empty($_POST['post_comment']) && isset($_SESSION['id_membre'])){
    $comm_msg = insertCommentaire($_POST['post_comment'], intval($_GET['id']), $_SESSION['id_membre']);
  }

  $annonce = getAnnonce(intval($_GET['id']));
  if ($annonce == 0){
    degage();
  }
  $annonce['comm_msg'] = $comm_msg;
}else{ degage();}

showForm($annonce);

require_once('footer.php');

function showForm($annonce){
  ?>
  <div class="container segment-annonce">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 text-center">
        <h1><?= $annonce['titre']; ?></h1>
      </div>
    </div>
    <?php
    if ( (!empty($_SESSION['id_membre']) && $_SESSION['id_membre'] == $annonce['membre_id']) || (isset($_SESSION['statut']) && $_SESSION['statut'] == 1)){ ?>
      <div class="row">
        <div class="col-xs-8 col-xs-offset-2 text-center">
          <a href="fannonce.php?action=m&annonce=<?= $annonce['id_annonce']; ?>">Modifier cette annonce</a>
        </div>
      </div>
    <?php }
    ?>
    <div class="row">
      <div class="col-xs-4 text-right">
        Date de derniere mise a jour :
      </div>
      <div class="col-xs-6 col-xs-offset-1">
        <?php
        if (!empty($annonce['date_enregistrement'])){
          echo $annonce['date_enregistrement'];
        }else echo '--:--:--';
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 text-right">
        Auteur :
      </div>
      <div class="col-xs-6 col-xs-offset-1">
        <?php
        echo $annonce['pseudo'];
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 text-right">
        Categorie :
      </div>
      <div class="col-xs-6 col-xs-offset-1">
        <?php
        if (!empty($annonce['nom_categorie'])){
          echo $annonce['nom_categorie'];
        }
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 text-right">
        Mots cles associes :
      </div>
      <div class="col-xs-6 col-xs-offset-1">
        <?php
        if (!empty($annonce['motscles'])){
          echo $annonce['motscles'];
        }
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 text-right">
        Les photos :
      </div>
      <div class="col-xs-6 col-xs-offset-1">
        <?php
        if (!empty($annonce['photos']['photo3'])){
          echo '<img src="'.$annonce['photos']['photo3'].'" alt="photo annonce troc" class="img-responsive">';
        }
        ?>
      </div>
      <div class="col-xs-2">
        <?php
        if (!empty($annonce['photos']['photo2'])){
          echo '<img src="'.$annonce['photos']['photo2'].'" alt="photo annonce troc" class="img-responsive">';
        }
        ?>
      </div>
      <div class="col-xs-2">
        <?php
        if (!empty($annonce['photos']['photo1'])){
          echo '<img src="'.$annonce['photos']['photo1'].'" alt="photo annonce troc" class="img-responsive">';
        }
        ?>
      </div>
      <div class="col-xs-2">
        <?php
        if (!empty($annonce['photos']['photo4'])){
          echo '<img src="'.$annonce['photos']['photo4'].'" alt="photo annonce troc" class="img-responsive">';
        }
        ?>
      </div>
      <div class="col-xs-2">
        <?php
        if (!empty($annonce['photos']['photo5'])){
          echo '<img src="'.$annonce['photos']['photo5'].'" alt="photo annonce troc" class="img-responsive">';
        }
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 text-right">
        Prix affiche :
      </div>
      <div class="col-xs-6 col-xs-offset-1">
        <?php
        if (!empty($annonce['prix'])){
          echo $annonce['prix'];
        }
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 text-right">
        Description courte :
      </div>
      <div class="col-xs-6 col-xs-offset-1">
        <?php
        if (!empty($annonce['description_courte'])){
          echo $annonce['description_courte'];
        }
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 text-right">
        Description longue :
      </div>
      <div class="col-xs-6 col-xs-offset-1">
        <?php
        if (!empty($annonce['description_longue'])){
          echo $annonce['description_longue'];
        }
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 text-right">
        Pays de l'annonce :
      </div>
      <div class="col-xs-6 col-xs-offset-1">
        <?php
        if (!empty($annonce['pays'])){
          echo $annonce['pays'];
        }
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 text-right">
        Ville de l'annonce :
      </div>
      <div class="col-xs-6 col-xs-offset-1">
        <?php
        if (!empty($annonce['ville'])){
          echo $annonce['ville'];
        }
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 text-right">
        Adresse :
      </div>
      <div class="col-xs-6 col-xs-offset-1">
        <?php
        if (!empty($annonce['adresse'])){
          echo $annonce['adresse'];
        }
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-4 text-right">
        Code postal :
      </div>
      <div class="col-xs-6 col-xs-offset-1">
        <?php
        if (!empty($annonce['cp'])){
          echo $annonce['cp'];
        }
        ?>
      </div>
    </div>
    <?php include ('commpi.php'); ?>
  </div>
  <?php
}
