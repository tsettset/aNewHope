<?php
require_once('fonctions.inc.php');
require_once('header.inc.php');
$check = array();
$check['valide'] = 0;
$check['message'] = '';

if (isset($_POST) && !empty($_POST)){
  debug($_POST);
  $check = checkAnnonce($_POST);
}
  ShowForm($check);

  require_once('footer.php');

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
              echo 'Ok ! enregistrement en cours !';
            echo '</div>';
          echo '</div>';
        }
        ?>

        <div class="form-group text-center ">
          <label for="titre">Titre</label>
          <input type="text" name="titre" id="titre" class="form-control" placeholder="Titre de l'annonce"
          <?php
          if ( (isset($check['titre'])) && ($check['valide'] == 0) && ($check['titre'] !== '') ){
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
          <textarea name="description_courte" id="description_courte" class="form-control" placeholder="Description courte de votre annonce">
            <?php
            if ( isset($check['description_courte']) ($check['valide'] == 0) && ($check['description_courte'] !== '')){
              echo $check['description_courte'];
            }
             ?>
          </textarea>
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


  function checkAnnonce($post){
    extract($post);
    $tab = array();
    $tab['message'] = '';
    $tab['valide'] = 1;
    //---------------- Titre annonce ------------
    $titre = htmlspecialchars($titre);
    $tab['titre'] = $titre;
    if (strlen($titre) > 255){
      $tab['message'] .= 'Titre de l\'annonce trop long <br>';
      $tab['valide'] = 0;
    }
    elseif (strlen($titre) < 1){
      $tab['message'] .= 'Le titre de l\'annonce ne peut pas etre vide<br>';
      $tab['valide'] = 0;
    }

    //---------------- Description courte ------------
    $description_courte = htmlspecialchars($description_courte);
    $tab['description_courte'] = $description_courte;
    if (strlen($description_courte) > 255){
      $tab['message'] .= 'Description courte de l\'annonce trop longue <br>';
      $tab['valide'] = 0;
    }

    //---------------- Description longue ------------
    $description_longue = htmlspecialchars($description_longue);
    $tab['description_longue'] = $description_longue;

    //---------------- Prix ------------
    $tab['prix'] = $prix;
    if (!is_numeric($prix)){
      $tab['valide'] = 0;
      $tab['message'] .= 'Le prix entre n\'est pas un chiffre.<br>';
    }

    //---------------- Selection categorie ------------
    $tab['categorie'] = $categorie;
    if ($categorie == 'na') {
      $tab['message'] .= 'Veuillez selectionner une categorie<br>';
      $tab['valide'] = 0;
    }


    //---------------- Photo ------------
    /*if(!empty($_FILES['upload_photo']['name'])){
    $tab['upload_photo'] = $_FILES['upload_photo']['name'];
    if (strlen($tab['upload_photo']) > 50){
    $tab['message'] .= 'Nom de fichier trop long veuillez renommer<br>';
    $tab['valide'] = false;
  }
}*/

//---------------- Adresse annonce------------
$addresse = htmlspecialchars($addresse);
$tab['addresse'] = $addresse;
if (strlen($addresse) > 50){
  $tab['message'] .= 'Adresse l\'annonce trop longue <br>';
  $tab['valide'] = 0;
}

//---------------- Ville annonce------------
$ville = htmlspecialchars($ville);
$tab['ville'] = $ville;
if (strlen($ville) > 20){
  $tab['message'] .= 'Ville de l\'annonce trop longue <br>';
  $tab['valide'] = 0;
}
elseif (strlen($ville) < 1){
  $tab['message'] .= 'La ville de l\'annonce ne peut pas etre vide<br>';
  $tab['valide'] = 0;
}

//---------------- CP annonce------------
$code_postal = htmlspecialchars($code_postal);
$tab['code_postal'] = $code_postal;
if (strlen($code_postal) > 5){
  $tab['message'] .= 'Code Postal de l\'annonce trop long <br>';
  $tab['valide'] = 0;
}
elseif (strlen($code_postal) < 1){
  $tab['message'] .= 'Le code postal de l\'annonce ne peut pas etre vide<br>';
  $tab['valide'] = 0;
}

//---------------- Pays annonce------------
$pays = htmlspecialchars($pays);
$tab['pays'] = $pays;
if (strlen($pays) > 20){
  $tab['message'] .= 'Pays de l\'annonce trop long <br>';
  $tab['valide'] = 0;
}
return $tab;
}
