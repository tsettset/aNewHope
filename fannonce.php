<?php
require_once('init.inc.php');
require_once('fonctions.inc.php');
require_once('header.inc.php');
require_once('fannonce.fonctions.php');
$check = array();
$check['valide'] = 0;
$check['message'] = '';

$post = array();
$files = array();

if (isset($_POST) && !empty($_POST)){
  debug($_POST);
  $post = $_POST;
}
if (isset($_FILES) && !empty($_FILES)){
  debug ($_FILES);
  $files = $_FILES;
}

$check = checkAnnonce($post, $files);
if ($check['valide'] == 1){

}

ShowForm($check);
?>
<script>
$(document).ready(function(){
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
});

function showVilles(){
  ville = '<?php echo (isset($check['ville'])) ? $check['ville'] : '0';?>';
  var params = 'pays=';
  pays_selected = '';
  pays_selected = $('#pays').find(':selected').val();
  if (pays_selected){
    params += pays_selected;
  }
  params += '&ville='+ville;
  $.post('fannonce.ajax.php?action=getvilles', params, function(valeurRetour){
    if (valeurRetour.valide == 1){
      $('#ville_select').html(valeurRetour.optionList);
    }
  },'json');
}
</script>

<?php
require_once('footer.php');
//----------- FIN DE LA PAGE

//----------- Fonctions
function ShowForm($check){?>
  <form method="post" action="" enctype="multipart/form-data" name="new_annonce" id="new_annonce">
    <div class="container">
      <div class="row" style="padding-top:10px">
        <div class="col-md-8 col-md-offset-2 text-center">
          <h1>Deposer une annonce</h1>
        </div>
      </div><!-- row -->

      <?php
      //debug ($check);
      if ( ($check['message'] !== '') && ($check['valide']==0) ) {
        echo '<div class="row">';
        echo '<div class="col-xs-10 col-xs-offset-1 alert alert-danger">';
        echo $check['message'];
        echo '</div>';
        echo '</div>';
      } elseif ($check['valide'] == 1){
        echo '<div class="row">';
        echo '<div class="col-xs-10 col-xs-offset-1 alert alert-success">';
        echo 'Enregistrement en cours...';
        echo '</div>';
        echo '</div>';
      }
      //debug($check);
      ?>

      <div class="form-group text-center ">
        <label for="titre">Titre</label>
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
          <input type="file" id="photo1" name="photo1" ><br>
        </div>
        <div class="form-group col-xs-2">
          <label for="photo2">Photo 2</label>
          <input type="file" id="photo2" name="photo2" ><br>
        </div>
        <div class="form-group col-xs-2">
          <label for="photo3">Photo 3</label>
          <input type="file" id="photo3" name="photo3" ><br>
        </div>
        <div class="form-group col-xs-2">
          <label for="photo4">Photo 4</label>
          <input type="file" id="photo4" name="photo4" ><br>
        </div>
        <div class="form-group col-xs-2">
          <label for="photo5">Photo 5</label>
          <input type="file" id="photo5" name="photo5" ><br>
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
        <input type="number" name="prix" id="prix" class="form-control" placeholder="Prix figurant dans l'annonce"
        <?php if (isset($check['prix']) && ($check['prix']) !== '' ){
          echo 'value = "'.$check['prix'].'"';
        }?>>
      </div>
      <div class="form-group">
        <label for="categorie">Categorie</label>
        <select class="form-control" name="categorie" id="categorie">
          <?php
          echo (isset($check['categorie'])) ? getListCategoriesOption($check['categorie']) : getListCategoriesOption(0);
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
        <label for="addresse">Addresse</label>
        <textarea name="addresse" id="addresse" class="form-control" placeholder="Addresse figurant dans l'annonce"><?php
        if ( isset($check['addresse']) && ($check['addresse'] !== '')){
          echo $check['addresse'];
        }
        ?></textarea>
      </div>
      <div class="form-group">
        <label for="code_postal">Code Postal</label>
        <input type="number" name="code_postal" id="code_postal" class="form-control" placeholder="Code postal figurant dans l'annonce"
        <?php
        if ( (isset($check['code_postal'])) && ($check['code_postal'] !== '') ){
          echo 'value = "'.$check['code_postal'].'"';
        }?>
        >
      </div>
      <button type="submit" name="save_form" id="save_form" class="btn btn-primary btn-lg btn-block">Enregistrer</button>
    </div><!-- container-fluid -->
    <div class="row" style="min-height:15px"></div>
  </form>
  <?php
}
