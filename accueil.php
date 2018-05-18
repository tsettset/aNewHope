<?php
require_once('init.inc.php');
require_once('accueil.fonctions.php');
initRecherche();
require_once('fonctions.inc.php');
require_once('header.inc.php');
require_once('annonce.fonctions.php');
require_once('fannonce.fonctions.php');

require_once('navbar.php');

// debug (makeSearch());
$check = array();
if (isset($_POST) && !empty($_POST)){
  // debug($_POST);
  $check = laveRecherchePost($_POST);
  // debug($check);
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
              <label for="titre">Titre de l'annonce contient</label>
              <input type="text" name="titre" id="titre" class="form-control" placeholder="Rechercher par titre de l'annonce" />
            </div>
            <div id="titre_suggest">
            </div>
          </div>
          <div class="col-xs-10 col-xs-offset-1" >
            <div class="form-group">
              <label for="prix_min">Prix Mini</label>
              <input type="number" name="prix_min" id="prix_min" title="superieur a 0">
            </div>
            <div class="form-group">
              <label for="prix_max">Prix Max</label>
              <input type="number" name="prix_max" id="prix_max" title="inferieur a 999999">
            </div>
          </div>
          <div class="col-xs-10 col-xs-offset-1" >
            <div class="form-group">
              <button type="submit" class="btn btn-primary">appliquer ces criteres</button>
            </div>
          </div>
        </div>
      </form>
    </div><!--fin module_recherche-->

    <div class="col-xs-8">
      <div class="row" >
        <div class="col-xs-10 col-xs-offset-1 text-center">
          <h3>Les annonces selon vos criteres de recherche </h3>
        </div>
        <div class="col-xs-5 col-xs-offset-1 text-center">
          <div class="form-group">
            <label for="search_param">Selectionnez un parametre de tri</label>
            <select class="form-control" id="search_param" name="search_param">
              <option value="date_enregistrement" selected>Date</option>;
              <option value="titre">Titre</option>
              <option value="categorie_id">Categorie</option>
              <option value="pays_id">Pays</option>
              <option value="ville">Ville</option>
              <option value="prix">Prix</option>
            </select>
          </div>
        </div>
        <div class="col-xs-5 text-center">
          <div class="form-group">
            <label for="sens">Selectionnez un sens de tri</label>
            <select class="form-control" id="sens" name="sens">
              <option value="ASC"> Ascendant </option>
              <option value="DESC"selected> Descendant </option>
            </select>
          </div>
        </div>

        <div id="liste_annonces">
          <div class="col-xs-10 col-xs-offset-1 text-center">
            <h2>Accueil</h2>
          </div>
        </div>
      </div>
    </div><!--fin module_annonces-->

  </div><!--fin row-->
</div><!--fin container-->

<script>
$(document).ready(function(){

  //--------------gestion du formulaire de recherche--------------------------

  //--------------Categorie---------------------------------------------------
  //on attache un event onchange  sur le <select categorie> : charger la liste d'annonces
  $('#categorie_id').on('change',function(){
    var params = 'categorie_id=' + $(this).find(':selected').val();
    recherche('categorie_id', params);
  });//fin categorie_id.on('change')

  //--------------Pays---------------------------------------------------
  //on attache un event onchange  sur le <select pays> :
  // - charger la liste des villes quand on change de pays
  // - actualiser la recherche d'annonces
  $('#pays').on('change',function(event){
    showVilles();
    var params = 'pays_id=' + $(this).find(':selected').val();
    recherche('pays_id' , params);
  });//fin pays.on('change')

  //--------------Ville---------------------------------------------------
  //on attache un event onchange sur le <select ville> : charger la liste d'annonces
  $('#ville_select').on('change',function(){
    var params = 'ville=' + $(this).find(':selected').val();
    recherche('ville', params);
  });//fin ville.on('change')

  //--------------Parametre de tri----------------------------------------------
  $('#search_param').on('change',function(){
    var params = 'orderby=' + $(this).find(':selected').val();
    recherche('orderby', params);
  });//fin search_param.on('change')

  //--------------Sens de tri--------------------------------------------------
  $('#sens').on('change',function(){
    var params = 'sens=' + $(this).find(':selected').val();
    recherche('sens', params);
  });//fin sens.on('change')

  //--------------Gestion Titre-------------------------------------------------
  $('#titre').on('input',function(){
    var params = 'titre=' + $(this).val();
    if (params.length - 6 > 2){
      recherche('titre', params);
      populateTitre();
    } else {
      $('#titre_suggest').html('');
    }

  });//fin titre.on('input')

  //--------------Prix Mini--------------------------------------------------
  $('#prix_min').on('input',function(){
    var params = 'prix_min=' + $(this).val();
    recherche('prix_min', params);
  });//fin prix_min.on('change')

  //--------------Prix Max--------------------------------------------------
  $('#prix_max').on('input',function(){
    var params = 'prix_max=' + $(this).val();
    recherche('prix_max', params);
  });//fin prix_min.on('change')

  //--------------formulaire de recherche complet--------------------------
  $('#form_recherche').on('submit',function(event){
    event.preventDefault();
    recherche('f','p=na');
  });//fin $.form_recherche

  //--------------FIN gestion du formulaire de recherche----------------------

  //-------------on prepare l'affichage de select pays et ville---------------
  //on commence par recuperer le pays selectionne
  //   var pays_selected = $('#pays').find(':selected').val();
  //   //on met dans "var ville" la ville selectionnee pour la reposter en cas de modif
  // var ville = '<?php// echo (isset($check['ville'])) ? $check['ville'] : '0';?>';
  //   if (ville == '0'){
  //   $('#ville_select').html('<em><select class="form-control"><option value="na">---</option></select></em>');
  // }else if (pays_selected) {//sinon appeler la fonction d'affichage de villes
  showVilles();
  // }
  recherche('f','p=na');//on lance une recherche telle quelle au rafrachissement

});// Fin DR

function populateTitre(){//post une recherche avec les parametres actuels et affiche les suggestions de titre
  $.post('accueil.ajax.php?action=f' , 'p=na', function(valeurRetour){
    if (valeurRetour.valide == 1){
      var finale = formatListeTitre(valeurRetour.liste_annonces);
      $('#titre_suggest').html(finale);
    }
  },'json');//fin $.post

  // $('#suggest').on('click',function(event){
  //   console.log('on est dedans');
  //   // console.log($(this).html());
  //
  // });//fin suggest.on(click)
  // $('#suggest').html('Hello world');
}//fin populateTitre

function recherche(a,p){//post en ajax avec a en get[action] et p en post puis affiche le resultat dans les annonces
  $.post('accueil.ajax.php?action='+a , p, function(valeurRetour){
    if (valeurRetour.valide == 1){
      var finale = formatListeAnnnonces(valeurRetour.liste_annonces);
      $('#liste_annonces').html(finale);
    }
  },'json');//fin $.post
}

function formatListeTitre(liste){
  var divDebut = '<div class="text-left module_recherche suggest">';
  var finale = '';
  if (Array.isArray(liste)){
    for (var i = 0; i < liste.length; i++) {
      finale += divDebut + '<a href="annonce.php?id='+ liste[i].annonce.id_annonce +'" title="consulter l\'annonce">';
      finale += liste[i].annonce.titre + '</a></div>';
    }
  }
  return finale;
}

function formatListeAnnnonces(liste){
  var divDebut = '<div class="col-xs-10 col-xs-offset-1 text-center module_recherche">';
  var finale = '';
  if (liste == 0){
    finale += divDebut + '<em>Pas de resultat</em>' + '</div>';
  } else {
    for (var i = 0; i < liste.length; i++) {
      // console.table(liste);
      finale += divDebut;
      if (liste[i].annonce.photos.photo1)  finale += '<img src="' + liste[i].annonce.photos.photo1 + '" style="max-width: 20%; height: auto;"></img> ';
      if (liste[i].annonce.photos.photo2)  finale += '<img src="' + liste[i].annonce.photos.photo2 + '" style="max-width: 20%; height: auto;"></img> ';
      if (liste[i].annonce.photos.photo3)  finale += '<img src="' + liste[i].annonce.photos.photo3 + '" style="max-width: 20%; height: auto;"></img> ';
      if (liste[i].annonce.photos.photo4)  finale += '<img src="' + liste[i].annonce.photos.photo4 + '" style="max-width: 20%; height: auto;"></img> ';
      if (liste[i].annonce.photos.photo5)  finale += '<img src="' + liste[i].annonce.photos.photo5 + '" style="max-width: 20%; height: auto;"></img> ';

      finale += '<br>' + liste[i].annonce.titre ;
      finale += '<br><strong>'+ liste[i].annonce.prix +'</strong>';
      finale += '<br>' + liste[i].annonce.description_courte;
      finale += '<br>' + liste[i].annonce.ville + '  --  ' + liste[i].annonce.pays;
      finale += '<br>' + liste[i].annonce.date_enregistrement;
      finale += '<br><a href="annonce.php?id='+ liste[i].annonce.id_annonce +'" title="consulter l\'annonce">Consulter l\'annonce</a>';
      finale += '</div>';
    }
    // finale +=divDebut + '<?php// if(isset($_SESSION['recherche']['requete']))  echo $_SESSION['recherche']['requete']; ?>' + '</div>';
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
