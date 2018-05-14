<?php
require_once('init.inc.php');
require_once('fonctions.inc.php');
require_once('header.inc.php');
require_once('annonce.fonctions.php');
require_once('fannonce.fonctions.php');
require_once('navbar.php');

?>
<div class="container">
  <div class="row">
    <div class="col-xs-4 module_recherche">
      <form>
        <div class="row">
          <div class="col-xs-10 col-xs-offset-1">
            <h3>Module Recherche</h3>
          </div>
          <div class="col-xs-10 col-xs-offset-1">
            <div class="form-group">
              <label for="categorie_id">Categorie</label>
              <select class="form-control" name="categorie_id" id="categorie_id">
                <?php
                echo (isset($check['categorie_id'])) ? getListCategoriesOption($check['categorie_id']) : getListCategoriesOption(0);
                ?>
              </select>
            </div>
          </div>
          <div class="col-xs-10 col-xs-offset-1">
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
          </div>
          <div class="col-xs-10 col-xs-offset-1">
            <div class="form-group">
              <label for="titre">Titre de l'annonce</label>
              <input type="text" name="titre" id="titre" class="form-control" placeholder="Rechercher par titre de l'annonce">
            </div>
          </div>
        </div>
      </form>
    </div><!--fin module_recherche-->

    <div class="col-xs-8 module_annonces">
      <div class="row" id="liste_annonces">
        <div class="col-xs-10 col-xs-offset-1 text-center">
          <h3>Les dernieres annonces</h3>
        </div>
        <div class="col-xs-10 col-xs-offset-1">          
        </div>
        <div class="col-xs-10 col-xs-offset-1">
        </div>
        <div class="col-xs-10 col-xs-offset-1">
        </div>
      </div>
    </div><!--fin module_annonces-->

  </div><!--fin row-->
</div><!--fin container-->

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
require_once ('footer.php');
?>
