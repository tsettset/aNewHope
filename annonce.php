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
} else {
  degage();
}

$annonce['note_moyenne'] = avgNoteParUser($annonce['membre_id'])[0];

if (isset($_POST['id_note_supp']) && !empty($_POST['id_note_supp'])){
  if (supprimeAnnonce($_POST['id_note_supp'])){
    $annonce['note_message'] = 'Ok supprimed';
  } else {
    $annonce['note_message'] = 'Une erreur s\'est produite, suppression annulee';
  }
}

// debug($_POST);

if (isset($_POST['note']) && !empty($_POST['note'])){
  $autorise = true;
  $note = $_POST['note'];
  $avis = '';
  if (isset($_POST['avis']) && !empty($_POST['avis'])){
    $avis = htmlspecialchars($_POST['avis'], ENT_QUOTES);
    if (strlen($avis) > 100){
      $autorise = false;
      $annonce['note_message'] = '<br>Avis trop long veuillez recommencer';
    }
  }
  $membre_id1 = $_SESSION['id_membre'];
  $membre_id2 = $annonce['membre_id'];
  if ($autorise) {
    ajouteNote($membre_id1, $membre_id2, $note, $avis);
  }
}

showForm($annonce);

require_once('footer.php');

function showForm($annonce){
  ?>
  <div class="row" style="min-height:30px"></div>
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
          <a href="fannonce.php?action=m&annonce=<?= $annonce['id_annonce']; ?>"> <?php echo (internauteEstConnecteEtEstAdmin()) ? 'Modifier cette annonce (commande Admin)' : 'Modifier votre annonce'; ?></a>
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
      <div class="col-xs-4">
        <?php
        echo $annonce['pseudo'];
        ?>
        -- Note Moyenne :
        <?php
        echo $annonce['note_moyenne'];
        ?>
      </div>
    </div>

    <?php
    if(internauteEstConnecte() && $_SESSION['id_membre'] != $annonce['membre_id']){
      // debug($_SESSION);
      // debug($annonce);
      if (isset($annonce['note_message']) && !empty($annonce['note_message'])){
        echo '<div class="row">';
        echo '<div class="col-xs-6 col-xs-offset-2" style="color:red; font-weight:bold">';
        echo $annonce['note_message'];
        echo '</div>';
        echo '</div>';
      }

      $annonce['note_donnee'] = getNoteMembres($_SESSION['id_membre'],$annonce['membre_id']);

      if ($annonce['note_donnee'] == 0) {
        ?>
        <div class="row">
          <form class="form-inline" method="post" id="form_note_avis">
            <div class="col-xs-4 col-xs-offset-1">
              <div class="form-group">
                <label for="note">Noter ce membre</label>
                <select class="form-control" name="note" id="note">
                  <?php
                    for ($i=5; $i > 0 ; $i--) {
                      echo '<option value="';
                      echo $i;
                      echo '"';
                      if (isset($_POST['note']) && !empty($_POST['note']) && $_POST['note'] == $i)
                        {echo ' selected';}
                      echo '>';
                      echo $i;
                      echo '</option>';
                    }

                   ?>
                </select>
              </div>
            </div>
            <div class="col-xs-5">
              <div class="form-group">
                <label for="avis">Votre avis sur ce membre</label>
                <textarea class="form-control" name="avis" id="avis" placeholder="Votre avis...(100 caracteres max)" ><?php if (isset($_POST['avis']) && !empty($_POST['avis'])) echo $_POST['avis']; ?></textarea>
              </div>
            </div>
            <div class="col-xs-1">
              <button type="submit" class="btn btn-primary" name="form_note_avis">Valider</button>
            </div>
          </form>
        </div>
        <?php
      }else {
        ?>
        <div class="row">
          <div class="col-xs-2 col-xs-offset-1">
            <p>Note et avis donnes : </p>
          </div>
          <div class="col-xs-1">
            <p><?= $annonce['note_donnee']['note']; ?></p>
          </div>
          <div class="col-xs-4">
            <p><?= $annonce['note_donnee']['avis'];?></p>
          </div>
          <div class="col-xs-4">
            <form method="post">
              <input type="hidden" name="id_note_supp" value="<?= $annonce['note_donnee']['id_note']; ?>">
              <button type="submit" name="suppr_note" id="save_form" class="btn btn-danger btn-lg btn-block">Supprimer note et avis</button>
            </form>
          </div>
        </div>
        <?php
      }
    }
    ?>

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
  <div class="row" style="min-height:30px"></div>
  <?php
}
