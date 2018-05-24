<?php
require_once('init.inc.php');
require_once('fonctions.inc.php');
require_once('header.inc.php');
require_once('fannonce.fonctions.php');
require_once('navbar.php');
require_once('footer.php');

$annonceAModif = array();
$check['valide'] = -1;//on init a -1 pour le premier passage afin de ne pas trigger les messages d'erreur
$check['message'] = '';//on init a vide pour ne pas trigger les messages
$check['status'] = '';//pour savoir l'etat de la page c = creation, m = modification, r = enregistrement effectue -> redirection proposee
$check['titreDePage'] = 'Deposer une annonce';
// debug ($_SESSION);

if (isset($_SESSION['id_membre'])){
  $check['id_membre'] = $_SESSION['id_membre'];
} else degage();

if (isset($_GET['action']) && !empty($_GET['action'])){
  switch ($_GET['action']) {

    case 'c':
    $check['status'] = 'c';
    break;

    case 'm':
    $check['titreDePage'] = 'Modifier une annonce';
    $check['status'] = 'm';
    if (isset($_GET['annonce']) && !empty($_GET['annonce'])) {
      $annonceAModif = getIdAnnonce($_GET['annonce']);
      if (empty($annonceAModif)){
        $check['valide'] = 0;
      } else {
        $check = getAnnonceModif($annonceAModif, $check);
        if (($check['id_membre'] !== $check['membre_id']) && ($_SESSION['statut'] == 0)) {
          degage();
        }
      }
    }else{
      degage();
    }
    break;

    case 'r':
    $check['status'] = 'r';
    break;

    default:
    degage();
    break;
  }
} else {degage();}

if (isset($_POST) && !empty($_POST)){
  $files = array();
  if (isset($_FILES) && !empty($_FILES)){
    $files = $_FILES;
  }
  $check = checkAnnonce($check, $_POST, $files);//on envoie le tout a checkannonce qui nettoie et valide les donnees
}

if ($check['valide'] == 1){//si on est valide on procede a l'upload des photos et l'insert dans la bdd
  $photos_bdd = array();
  if(isset($check['photo'])){
    for ($i=0; $i < 6; $i++ ){
      if( isset($check['photo'][$i]) && isset($check['photo'][$i]['photo_tmp']) && !empty($check['photo'][$i]['photo_tmp']) ) {
        uploadPhoto($check['photo'][$i]['photo_tmp'], $check['photo'][$i]['photo_dossier']);
        $photos_bdd[] = $check['photo'][$i]['photo_bdd'];
      }
    }
  }//fin isset check-photo
  if ($_GET['action'] == 'c'){
    $check['id_annonce'] = insertionAnnonce($check, $photos_bdd);//Envoi vers la bdd
  }
  if ($_GET['action'] == 'm'){
    $check['id_annonce'] = modifAnnonce($check, $photos_bdd);//Envoi vers la bdd
    if ($check['id_annonce'] == 0){
      $check['valide'] = 0;
      $check['message'] .= 'Une erreur s\'est produite.<br>';
      $check['message'] .= '<a href="javascript:history.back(-1);">Retour</a><br>';
      $check['message'] .= '<a href="fannonce.php?action=c">Deposer une annonce</a><br>';
    }

  }
  $check['status'] = 'r';//affiche le menu de redirection

}else{//sinon on vide $_POST et $_FILES pour eviter certains comportements inattendus. On utilisera les donnees dans check pour preremplir les champs
  if (isset($_FILES)) unset($_FILES);
  if (isset($_POST)) unset($_POST);
  if ($check['status'] == 'm' && $check['valide'] == 0){
    $check['message'] .= 'Une erreur s\'est produite.<br>';
    $check['message'] .= '<a href="javascript:history.back(-1);">Retour</a><br>';
    $check['message'] .= '<a href="fannonce.php?action=c">Deposer une annonce</a><br>';
    $check['status'] = 'r';
  }
}
ShowForm($check);//affiche la page
?>
<script>
$(document).ready(function(){

  _prefix_img = 'img_';//globale, sera utilisee pour retrouver les id des images
  _prefix_file = 'file_';//globale, sera utilisee pour retrouver les id de l'interface d'upload de fichier
  _prefix_suppr = 'suppr_';//globale, sera utilisee pour retrouver les id des liens de suppression

  <?php  for ($i=1; $i < 6 ; $i++) {
    $indice_photo = 'photo'.$i;
    echo "var imgId = _prefix_img + `photo` + $i;";
    echo "var fileUploadId = _prefix_file + 'photo' + $i;";
    echo "var suppLinkId = _prefix_suppr + 'photo' + $i;";

    if (isset($check[$indice_photo]) && !empty($check[$indice_photo])){
      echo "$('#'+imgId).show();";
      echo "$('#'+imgId).attr('src', '".$check[$indice_photo]."');";
      echo "$('#'+suppLinkId).show();";
      echo "$('#'+fileUploadId).hide();";
    } else {
      echo "$('#'+imgId).hide();";
      echo "$('#'+suppLinkId).hide();";
      echo "$('#'+fileUploadId).show();";
    }
  }?>
  $('.subphoto').on('click',function(event){//supprime une photo et reload la page
    console.log(this.id);
    event.preventDefault();
    var id = '<?= isset($check['photo_id']) ? $check['photo_id'] : ''; ?>';
    var params = 'photo=' + this.name + '&photo_id=' + id;
    var imgId = '#' + _prefix_img + this.name;
    var fileUploadId = '#' + _prefix_file + this.name;
    var suppLinkId = '#' + _prefix_suppr + this.name;
    $(imgId).hide();
    $(suppLinkId).hide();
    $(fileUploadId).show();
    $.post('fannonce.ajax.php?action=photosupp', params, function(valeurRetour){},'json');
  });//fin subphoto

  var pays_selected = $('#pays').find(':selected').val();
  var ville = '<?php echo (isset($check['ville'])) ? $check['ville'] : '0';?>';
  if (ville == '0'){
    $('#ville_select').html('<em><select class="form-control"><option>Selectionnez un pays</option></select></em>');
  }else if (pays_selected) {
    showVilles();
  }
  //on attache un event sur le <select pays> : charger la liste des villes quand on change de pays
  $('#pays').on('change',function(event){
    showVilles();
  });

});// Fin DR

function showVilles(){
  var ville = '<?php echo (isset($check['ville'])) ? $check['ville'] : '0';?>';
  var params = 'pays=';
  var pays_selected = '';
  pays_selected = $('#pays').find(':selected').val();
  if (pays_selected){
    params += pays_selected;
  }
  params += '&ville='+ville;
  $.post('fannonce.ajax.php?action=getvilles', params, function(valeurRetour){
    if (valeurRetour.valide == 1){
      $('#ville_select').html(valeurRetour.optionList);
    }
  },'json');//fin $.post
}//fin showVilles

</script>

<?php
require_once('footer.php');
//----------- FIN DE LA PAGE

//----------- Fonctions
function ShowForm($check){?>
<div class="row" style="min-height:30px"></div>
  <div class="container">
    <div class="row" style="padding-top:10px">
      <div class="col-md-8 col-md-offset-2 text-center">
        <h1><?= $check['titreDePage']; ?></h1>
      </div>
    </div><!-- row -->

    <?php
    if ( ($check['message'] !== '') && ($check['valide']==0) ) {
      echo '<div class="row">';
      echo '<div class="col-xs-10 col-xs-offset-1 alert alert-danger">';
      echo '<p>';
      echo $check['message'];
      echo '</p>';
      echo '</div>';
      echo '</div>';
    } elseif ($check['valide'] == 1){
      echo '<div class="row">';
      echo '<div class="col-xs-10 col-xs-offset-1 alert alert-success">';
      echo '<p>';
      echo '<h4>Votre annonce a bien ete publiee !</h4>';
      echo '<ul>';
      echo '<li><a href="annonce.php?id='.$check['id_annonce'].'" title="fiche annonce">Consulter la fiche de l\'annonce.</a></li>';
      echo '<li><a href="fannonce.php?action=m&annonce='.$check['id_annonce'].'" title="modifier l\'annonce">Modifier l\'annonce.</a></li>';
      echo '</ul>';
      echo '</p>';
      echo '</div>';
      echo '</div>';
    }
    if ($check['status'] !== 'r'):
      ?>
      <form method="post" action="" enctype="multipart/form-data" name="new_annonce" id="new_annonce">
        <div class="form-group text-center ">
          <label for="titre">Titre - derniere mise a jour : <?= isset($check['date_enregistrement']) ? $check['date_enregistrement'] : '--:--:--'; ?></label>
          <input type="text" name="titre" id="titre" class="form-control" placeholder="Titre de l'annonce"
          <?php
          if ( (isset($check['titre'])) && ($check['titre'] !== '') ){
            echo 'value = "'.$check['titre'].'"';
          }?>
          >
        </div>
        <div class="row">
          <div class="form-group col-xs-2 col-xs-offset-1">
            <label for="photo1">Photo 1</label>
            <img src="" alt="photo de l'annonce" class="img-responsive" id="img_photo1">
            <br>
            <a href="" class="subphoto" name="photo1" id="suppr_photo1" >Supprimer cette photo</a>
            <input type="file" name="photo1" id="file_photo1">
            <br>
          </div>
          <div class="form-group col-xs-2">
            <label for="photo2">Photo 2</label>
            <img src="" alt="photo de l'annonce" class="img-responsive" id="img_photo2">
            <br>
            <a href="" class="subphoto" name="photo2" id="suppr_photo2" >Supprimer cette photo</a>
            <input type="file" name="photo2" id="file_photo2">
            <br>
          </div>
          <div class="form-group col-xs-2">
            <label for="photo3">Photo 3</label>
            <img src="" alt="photo de l'annonce" class="img-responsive" id="img_photo3">
            <br>
            <a href="" class="subphoto" name="photo3" id="suppr_photo3" >Supprimer cette photo</a>
            <input type="file" name="photo3" id="file_photo3">
            <br>
          </div>
          <div class="form-group col-xs-2">
            <label for="photo4">Photo 4</label>
            <img src="" alt="photo de l'annonce" class="img-responsive" id="img_photo4">
            <br>
            <a href="" class="subphoto" name="photo4" id="suppr_photo4" >Supprimer cette photo</a>
            <input type="file" name="photo4" id="file_photo4">
            <br>
          </div>
          <div class="form-group col-xs-2">
            <label for="photo5">Photo 5</label>
            <img src="" alt="photo de l'annonce" class="img-responsive" id="img_photo5">
            <br>
            <a href="" class="subphoto" name="photo5" id="suppr_photo5" >Supprimer cette photo</a>
            <input type="file" name="photo5" id="file_photo5">
            <br>
          </div>
        </div><!-- row -->
        <div class="form-group">
          <label for="description_courte">Description Courte</label>
          <textarea name="description_courte" id="description_courte" class="form-control" placeholder="Description courte de votre annonce"><?php
          if ( isset($check['description_courte']) && ($check['description_courte'] !== '')){
            echo $check['description_courte'];
          }?></textarea>
        </div>
        <div class="form-group">
          <label for="description_longue">Description Longue</label>
          <textarea name="description_longue" id="description_longue" class="form-control" placeholder="Description longue de votre annonce"><?php
          if ( isset($check['description_longue']) && ($check['description_longue'] !== '')){
            echo $check['description_longue'];
          }
          ?></textarea>
        </div>
        <div class="form-group">
          <label for="prix">Prix</label>
          <input type="float" title="entrez le prix avec un . pour les decimales " name="prix" id="prix" class="form-control" placeholder="Prix figurant dans l'annonce"
          <?php if (isset($check['prix']) && ($check['prix']) !== '' ){
            echo 'value = "'.$check['prix'].'"';
          }?>>
        </div>
        <div class="form-group">
          <label for="categorie_id">Categorie</label>
          <select class="form-control" name="categorie_id" id="categorie_id">
            <?php
            echo (isset($check['categorie_id'])) ? getListCategoriesOption($check['categorie_id']) : getListCategoriesOption(0);
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="pays">Pays</label>
          <select class="form-control" name="pays" id="pays">
            <?php
            echo (isset($check['pays'])) ? getListPaysOption($check['pays']) : getListPaysOption(0);
            ?>
          </select>
        </div>
        <div class="form-group">
          <label for="ville">Ville</label>
          <div id="ville_select">
          </div>
        </div>
        <div class="form-group">
          <label for="adresse">Adresse</label>
          <textarea name="adresse" id="adresse" class="form-control" placeholder="Adresse figurant dans l'annonce"><?php
          if ( isset($check['adresse']) && ($check['adresse'] !== '')){
            echo $check['adresse'];
          }
          ?></textarea>
        </div>
        <div class="form-group">
          <label for="code_postal">Code Postal</label>
          <input type="number" name="code_postal" id="code_postal" class="form-control" placeholder="Code postal figurant dans l'annonce"
          <?php
          if ( (isset($check['cp'])) && ($check['cp'] !== '') ){
            echo 'value = "'.$check['cp'].'"';
          }?>
          >
        </div>
        <button type="submit" name="save_form" id="save_form" class="btn btn-primary btn-lg btn-block">Enregistrer</button>
      </form>
      <?php if ($check['status'] == 'm'){ ?>
        <!-- <a href="sannonce.php?id_annonce=<?php //echo $check['id_annonce']; ?>">Supprimer</a> -->
        <form method="post" action="sannonce.php?id_annonce=<?php echo $check['id_annonce']; ?>">
          <button type="submit" name="" class="btn btn-danger btn-lg btn-block">Supprimer</button>
        </form>
      <?php
      } ?>

      <?php
    endif;?>
  </div><!-- container-fluid -->
  <div class="row" style="min-height:100px"></div>

  <?php
}?>
