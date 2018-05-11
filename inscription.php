<?php
require_once 'init.inc.php';
require_once 'fonctions.inc.php';
require_once 'navbar.php';


if(isset($_POST['inscriSubmit'])){
  
  $req=$bdd->prepare('insert into membre(pseudo, mdp, nom, prenom, telephone, email, civilite, statut, date_enregistrement)values(:pseudo, :mdp, :nom, :prenom, :telephone, :email, :civilite, :statut, NOW())');
  $req->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
  $req->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
  $req->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
  $req->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
  $req->bindValue(':telephone', $_POST['telephone'], PDO::PARAM_STR);
  $req->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
  $req->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
  $req->bindValue(':statut', 0, PDO::PARAM_INT);
  $req->execute();

}
?>


<br>
<div class="container">
<div class="jumbotron">
<form method="post" action="">
  <label for="pseudo">Pseudo : </label><br>
  <input class="form-control" type="text" name="pseudo" placeholder="Votre pseudo" id="pseudo"><br>


  <label for="mdp">Mot de passe : </label><br>
  <input class="form-control" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe"><br>

  <label for="nom">Nom: </label><br>
  <input class="form-control" type="text" name="nom" id="nom" placeholder="Votre nom"><br>

  <label for="prenom">prenom: </label><br>
  <input class="form-control" type="text" name="prenom" id="prenom" placeholder="Votre prenom"><br>


  <label for="telephone">Téléphone : </label><br>
  <input class="form-control" type="tel" name="telephone" id="telephone" placeholder="Votre téléphone"><br>

  <label for="mdp">Email: </label><br>
  <input class="form-control" type="email" name="email" id="email" placeholder="Votre email"><br>

  <label for="civilite">Civilite :</label><br>
  <input type="radio" name="civilite" id="civilite" name="civilite" value="m"> Monsieur
  <input type="radio" name="civilite" id="civilite" name="civilite" value="f"> Madame

  <input type="submit" name="inscriSubmit"  id="inscriSubmit" class="btn btn-info" value="S'inscrire">

</form>
</div>
</div>