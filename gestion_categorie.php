<?php
require_once('init.inc.php');
require_once('fonctions.inc.php');
require_once('header.inc.php');
require_once('navbar.php');

if (!internauteEstConnecteEtEstAdmin()){
  header("Location: accueil.php");
}
if (!isset($_SESSION['categories']['orderBy'])){
  $_SESSION['categories']['orderBy'] = 'ASC';
}
// debug($_SESSION);

global $bdd;


?>

<div class="container">
  <div class="row">
    <div class="col-xs-8 col-xs-offset-2 text-center">
      <h2>Gestion des categories</h2>
    </div>
  </div>
  <div class="row module_recherche">
    <div class="col-xs-2">
      <h3>Nom categorie</h3>
      <div class="form-group">
        <label for="orderBy">Ordre alpha :</label>
        <select name="orderBy" id="orderBy" class="form-control">
          <option value="ASC">Ascendant</option>
          <option value="DESC">Descendant</option>
        </select>
      </div>
    </div>
    <div class="col-xs-8">
      <h3>Mots Cles</h3>

    </div>
    <div class="col-xs-2">
      <h3>Actions</h3>
    </div>
  </div>
  <form id="form_add">
    <div class="row module_recherche">
      <div class="col-xs-2 module_recherche">
        <input type="text" id="titre_add" name="titre_add" class="form-control" placeholder="Ajout de categorie">
        <div id="err_message" style="color: red"></div>
      </div>
      <div class="col-xs-8 module_recherche">
        <input type="text" id="motscles_add" name="motscles_add" class="form-control" placeholder="mots cles a associer">
      </div>
      <div class="col-xs-2 module_recherche">
        <input type="submit" class="form-control glyphicon glyphicon-edit" value="save">
      </div>
    </div>
  </form>
  <div id="liste_categorie">
  </div>

  <div class="row" style="min-height: 20px; "></div>

</div>

<script>
$(document).ready(function(){
  populateCategories(0);//rempli la liste des categories , 0 = affichage, pas de modification

  //-------------------AJOUT-------------------------------------------------------------

  $('#form_add').on('submit', function(event){
    //pour les events dynamiques (= events sur elements ajoutes dynamiquement dans la page)
    //il faut attacher l'event par le parent, ainsi des la creation des elements ils auront deja
    //l'event
    event.preventDefault();
    var param = $('#form_add').serialize();
    $.post('gestion_categorie.ajax.php?action=add' , param, function(valeurRetour){
      if (valeurRetour.valide==0){
        if (valeurRetour.err_message){
          $('#err_message').html(valeurRetour.err_message);
        }
      } else {
        $('#titre_add').val('');
        $('#motscles_add').val('');
      }
    },'json');//fin $.post


    populateCategories(0);
  });//fin #ajout on.submit

  //--------------Modification-----------------------------------------------------------

  $('#liste_categorie').on('click', '.modif', function(event){
    //pour les events dynamiques (= events sur elements ajoutes dynamiquement dans la page)
    //il faut attacher l'event par le parent, ainsi des la creation des elements ils auront deja
    //l'event
    event.preventDefault();
    populateCategories($(this).attr('value'));//affiche la liste, parametre = la categorie a affiche avec modif/input
  });

  $('#liste_categorie').on('submit', '#form_modif', function(event){
    //pour les events dynamiques (= events sur elements ajoutes dynamiquement dans la page)
    //il faut attacher l'event par le parent, ainsi des la creation des elements ils auront deja
    //l'event
    event.preventDefault();
    var param = $('#form_modif').serialize();
    $.post('gestion_categorie.ajax.php?action=modif' , param, function(valeurRetour){
      if (valeurRetour.valide==0){
        if (valeurRetour.err_message){
          $('#err_message').html(valeurRetour.err_message);
        }
      }
    },'json');//fin $.post


    populateCategories(0);
  });//fin #modif on.submit



  //--------------Suppression-----------------------------------------------------------
  $('#liste_categorie').on('click', '.suppression', function(event){
    //pour les events dynamiques (= events sur elements ajoutes dynamiquement dans la page)
    //il faut attacher l'event par le parent, ainsi des la creation des elements ils auront deja
    //l'event
    event.preventDefault();
    var param = 'id_categorie=' + $(this).attr('value');
    $.post('gestion_categorie.ajax.php?action=suppression' , param, function(valeurRetour){
      populateCategories(0);
    }
    ,'json');
  });//fin .suppression on.click

  //-----------------Ordre de tri sur le titre-------------------------------------------

  $('#orderBy').on('change', function(event){
    var param = 'orderBy=' + $(this).find(':selected').val();
    $.post('gestion_categorie.ajax.php?action=orderBy' , param, function(valeurRetour){
      if (valeurRetour.valide==1){
        populateCategories(0);
      }
    },'json');//fin $.post
  });//fin orderBy.on change




});//fin DR

//--------------FONCTIONS-----------------------------
function populateCategories(categorieAModif){
  var p = 'catmod='+categorieAModif;
  $.post('gestion_categorie.ajax.php?action=liste' , p, function(valeurRetour){
    var finale = '';
    var divDebut = '<div class="row module_recherche"><div class="col-xs-2 module_recherche">';
    //nom categorie
    var divDeux = '</div><div class="col-xs-8 module_recherche">';
    //Mots cles
    var divTrois = '</div><div class="col-xs-2 module_recherche">';
    // <a href="#">Modifier</a>
    // <a href="#">Supprimer</a>
    var divFin = '</div></div>';

    if (valeurRetour.valide == 1){
      for (var i = 0; i < valeurRetour.categorie.length; i++) {
        if (valeurRetour.categorie[i].id_categorie == valeurRetour.catmod){
          finale += '<form id="form_modif">';
          finale += divDebut;
          finale += '<input type="text" name="titre" value="' + valeurRetour.categorie[i].titre + '" class="form-control">';
          finale += divDeux;
          if (valeurRetour.categorie[i].motscles == 'null') valeurRetour.categorie[i].motscles = '';
          finale += '<input type="text" name="motscles" value="' + valeurRetour.categorie[i].motscles + '" class="form-control">';
          finale += divTrois;
          finale += '<input type="hidden" name="id_categorie" value="' + valeurRetour.categorie[i].id_categorie + '">';
          finale += '<input type="submit" class="form-control glyphicon glyphicon-edit" value="save">';
          finale += divFin;
          finale += '</form>';
        } else{
          if (valeurRetour.categorie[i].motscles == null) valeurRetour.categorie[i].motscles = '';
          finale += divDebut + valeurRetour.categorie[i].titre + divDeux + valeurRetour.categorie[i].motscles + divTrois;
          finale += '<div class="row"><div class="col-xs-2 col-xs-offset-1">';
          finale += '<a href=""><span class="modif glyphicon glyphicon-edit" value="' + valeurRetour.categorie[i].id_categorie + '"></span></a>';
          finale += '</div><div class="col-xs-2 col-xs-offset-3">';
          finale += '<a href=""><span class="suppression glyphicon glyphicon-trash" value="' + valeurRetour.categorie[i].id_categorie + '"></span></a>';
          finale += '</div></div>';
          finale += divFin;
        }
      }
      $('#liste_categorie').html(finale);
    } else {
      $('#liste_categorie').html(divDebut + '<em>Pas de resultats</em>' + divFin);
    }
  },'json');//fin $.post
}

</script>
<?php
require_once('footer.php');
?>
