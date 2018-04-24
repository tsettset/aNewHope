<?php
require_once('header.inc.php');

if(isset($_GET['action'])){

  switch ($_GET['action']) {
    case 'view':
    break;
    case 'modif':
      break;
      case 'create':
      Create();
      break;
      default:
      echo 'fiche annonce defaut';
      break;
    }
  }

  if (isset($_POST)){
    debug($_POST);
  }

  require_once('footer.php');

  function Create(){?>
    <form method="post" action="" enctype="multipart/form-data">
      <div class="container">
        <div class="row" style="padding-top:10px">
          <div class="col-md-8 col-md-offset-2 text-center">
            <h1>Deposer une annonce</h1>
          </div>
        </div><!-- row -->
        <div class="form-group text-center ">
          <label for="titre">Titre</label>
          <input type="text" name="titre" id="titre" class="form-control" placeholder="Titre de l'annonce">
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
          <textarea name="description_courte" id="description_courte" class="form-control" placeholder="Description courte de votre annonce"></textarea>
        </div>
        <div class="form-group">
          <label for="description_longue">Description Longue</label>
          <textarea name="description_longue" id="description_longue" class="form-control" placeholder="Description longue de votre annonce"></textarea>
        </div>
        <div class="form-group">
          <label for="prix">Prix</label>
          <input type="number" name="prix" id="prix" class="form-control" placeholder="Prix figurant dans l'annonce">
        </div>
        <div class="form-group">
          <label for="categorie">Categorie</label>
          <select class="form-control" name="categorie" id="categorie">
            <option>Selectionnez une categorie</option>
          </select>
        </div>
        <div class="form-group">
          <label for="pays">Pays</label>
          <select class="form-control" name="pays" id="pays">
            <option>France</option>
          </select>
        </div>
        <div class="form-group">
          <label for="ville">Ville</label>
          <select class="form-control" name="ville" id="ville">
            <option>Paris</option>
          </select>
        </div>
        <div class="form-group">
          <label for="addresse">Addresse</label>
          <textarea name="addresse" id="addresse" class="form-control" placeholder="Addresse figurant dans l'annonce"></textarea>
        </div>
        <div class="form-group">
          <label for="code_postal">Code Postal</label>
          <input type="number" name="code_postal" id="code_postal" class="form-control" placeholder="Code postal figurant dans l'annonce">
        </div>
        <button type="submit" name="save_form" id="save_form" class="btn btn-primary btn-lg btn-block">Enregistrer</button>
      </div><!-- container-fluid -->
      <div class="row" style="min-height:15px"></div>
    </form>
    <?php
  }
