<?php
require_once('init.inc.php');
require_once('fonctions.inc.php');
require_once('header.inc.php');
require_once('annonce.fonctions.php');
require_once('fannonce.fonctions.php');
require_once('accueil.fonctions.php');
require_once('navbar.php');
initRecherche();
// debug (makeSearch());
$check = array();
if (isset($_POST) && !empty($_POST)){
  debug($_POST);
  $check = laveRecherchePost($_POST);
  debug($check);
}
?>
<div class="container">
  <div class="row">
    <div class="col-xs-4 module_recherche">
      <form method="post" action="" id="form_recherche" >
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
                if (isset($check['pays'])){
                  echo getListPaysOption($check['pays']);
                } else {
                  echo getListPaysOption(0);//par defaut pays 1 qui devrait etre la France..
                  $check['ville'] = 0;//par defaut ville 1 qui devrait etre Paris.. ICI c'est PARIS, BITCH !
                }
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
              <input type="text" name="titre" id="titre" class="form-control" placeholder="Rechercher par titre de l'annonce" value="<?=
              (isset($check['titre']) && !empty($check['titre'])) ? $check['titre'] : '';
              ?>">
            </div>
          </div>
          <div class="col-xs-10 col-xs-offset-1">
            <div class="form-group">
              <button type="submit" class="btn btn-primary">appliquer ces criteres</button>
            </div>
          </div>
        </div>
      </form>
    </div><!--fin module_recherche-->

    <div class="col-xs-8 module_annonces">
      <div class="row" >
        <div class="col-xs-10 col-xs-offset-1 text-center">
          <h3>Les annonces selon vos criteres de recherche </h3>
        </div>
        <div class="col-xs-4 col-xs-offset-4">
          <a href="" id="orderByAlpha">A - Z</a>
        </div>
        <div class="col-xs-4">
          <a href="" id="orderByDate">Date de mise a jour > </a>
        </div>
        <div id="liste_annonces">
          <div class="col-xs-10 col-xs-offset-1 module_recherche text-center">
            <h2>Accueil</h2>
          </div>
        </div>
      </div>
    </div><!--fin module_annonces-->

  </div><!--fin row-->
</div><!--fin container-->

<script>
$(document).ready(function(){

  //--------------Categorie---------------------------------------------------
  //on attache un event onchange  sur le <select categorie> : charger la liste d'annonces
  $('#categorie_id').on('change',function(){
    params = 'categorie_id=' + $(this).find(':selected').val();
    recherche('categorie_id', params);
  });//fin categorie_id.on('change')

  //--------------Pays---------------------------------------------------
  //on attache un event onchange  sur le <select pays> :
  // - charger la liste des villes quand on change de pays
  // - actualiser la recherche d'annonces
  $('#pays').on('change',function(event){
    showVilles();
    params = 'pays_id=' + $(this).find(':selected').val();
    recherche('pays_id' , params);
  });//fin pays.on('change')

  //--------------Categorie---------------------------------------------------
  //on attache un event onchange sur le <select ville> : charger la liste d'annonces
  $('#ville_select').on('change',function(){
    params = 'ville=' + $(this).find(':selected').val();
    recherche('ville', params);
  });//fin ville.on('change')



  //--------------gestion du formulaire de recherche--------------------------
  $('#form_recherche').on('submit',function(event){
    event.preventDefault();
    var params = $(this).serialize();
    recherche('f',params);
  });//fin $.form_recherche

  //--------------FIN gestion du formulaire de recherche----------------------

  //-------------on prepare l'affichage de select pays et ville---------------
  //on commence par recuperer le pays selectionne
  var pays_selected = $('#pays').find(':selected').val();
  //on met dans "var ville" la ville selectionnee pour la reposter en cas de modif
  var ville = '<?php echo (isset($check['ville'])) ? $check['ville'] : '0';?>';
  if (ville == '0'){//si 0 demander d'abord le choix d'un pays
  $('#ville_select').html('<em><select class="form-control"><option value="na">Toutes</option></select></em>');
}else if (pays_selected) {//sinon appeler la fonction d'affichage de villes
showVilles();
}
 recherche('f','p=na');//on lance une recherche telle quelle au rafrachissement
});// Fin DR

function recherche(a,p){
  console.log('params ' + p);
  $.post('accueil.ajax.php?action='+a , p, function(valeurRetour){
    var divDebut = '<div class="col-xs-10 col-xs-offset-1 text-center module_recherche">';
    if (valeurRetour.valide == 1){
      var finale = formatListeAnnnonces(valeurRetour.liste_annonces);
      $('#liste_annonces').html(finale);
    }
  },'json');//fin $.post
}

function formatListeAnnnonces(liste){
  var divDebut = '<div class="col-xs-10 col-xs-offset-1 text-center module_recherche">';
  var finale = '';
  if (liste == 0){
    finale += divDebut + '<em>Pas de resultat</em>' + '</div>';
  } else {
    for (var i = 0; i < liste.length; i++) {
      finale += divDebut + liste[i].id_annonce + '<br>';
      finale += liste[i].annonce.titre;
      finale += '</div>';
    }
  }
  return finale;
}

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
