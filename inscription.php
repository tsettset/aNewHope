<?php
require_once 'init.inc.php';
require_once 'fonctions.inc.php';
require_once 'navbar.php';





$pseudo=" ";
$mdp=" ";
$nom=" ";
$prenom=" ";
$telephone=" ";
$email=" ";



if(isset($_POST['inscriSubmit'])){

  if(!preg_match("/[a-zA-Z0-9]{2,12}/", $_POST['pseudo'])||!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-=]).{8,}$/", $_POST['mdp'])||!preg_match("/[a-zA-Z]{2,20}/", $_POST['nom'])||!preg_match("/[a-zA-Z]{2,15}/", $_POST['prenom'])||!preg_match("/[0-9]{10,20}/" , $_POST['telephone'])||!preg_match("/[a-z]{3,}[@]{1}[a-z]{3,}[.]{1}[comfr]{2,3}/" , $_POST['email'])){



    if(!preg_match("/[a-zA-Z0-9]{2,12}/", $_POST['pseudo'])){

      $pseudo='<div class="alert alert-danger"> Vous devez saisir un pseudo entre 2 et 12 caracteres et qui ne contient pas de caractères spéciaux</div>';
    }
    if(!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-=]).{8,}$/", $_POST['mdp'])){

      $mdp='<div class="alert alert-danger"> Votre mot de passe doit comprendre au moins une majuscule, au moins une minuscule, au moins un chiffre, au moins un caractère spécial et doi être d\'une longueur de 8 caractères au minimum</div>';
    }


    if(!preg_match("/[a-zA-Z]{2,20}/", $_POST['nom'])){

      $nom='<div class="alert alert-danger"> Vous devez saisir un pseudo entre 2 et 20 caracteres</div>';
    }


    if(!preg_match("/[a-zA-Z]{2,15}/", $_POST['prenom'])){

      $prenom='<div class="alert alert-danger"> Vous devez saisir un pseudo entre 2 et 15 caracteres</div>';
    }


    if(!preg_match("/[0-9]{10,20}/" , $_POST['telephone'])){

      $telephone='<div class="alert alert-danger">Vous devez saisir le bon numero de telephone</div>';
    }

    if(!preg_match("/[a-z]{3,}[@]{1}[a-z]{3,}[.]{1}[comfr]{2,3}/" , $_POST['email'])){

      $email='<div class="alert alert-danger">Vous devez saisir un bon email</div>';

    }

  }else{





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
}





?>


<br>
<div class="container">
  <div class="jumbotron">
    <form method="post" action="">
      <label for="pseudo">Pseudo : </label><br>
      <input class="form-control" type="text" name="pseudo" placeholder="Votre pseudo"  id="pseudo" required><br><?=$pseudo?><br>


      <label for="mdp">Mot de passe : </label><br>
      <input class="form-control" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe" required><br><?=$mdp?><br>

      <label for="nom">Nom: </label><br>
      <input class="form-control" type="text" name="nom" id="nom" placeholder="Votre nom"  required><br><?=$nom?><br>

      <label for="prenom">prenom: </label><br>
      <input class="form-control" type="text" name="prenom" id="prenom" placeholder="Votre prenom" required><br><?=$prenom?><br>


      <label for="telephone">Téléphone : </label><br>
      <input class="form-control" type="tel" name="telephone" id="telephone"  placeholder="Votre téléphone" required><br><?=$telephone?><br>

      <label for="mdp">Email: </label><br>
      <input class="form-control" type="email" name="email" id="email" placeholder="Votre email" required><br><?=$email?><br>

      <label for="civilite">Civilite :</label>
      <select name="civilite"class="form-control">
        <option value="monsieur">Monsieur</option>
        <option value="madame">Madame</option>
        <option value="mademoiselle">Mademoiselle</option>
      </select>
      <br>
      <div class="text-center"><input type="submit" name="inscriSubmit"  id="inscriSubmit" class="btn btn-info" value="S'inscrire"></div>

    </form>
  </div>
</div>
<br>
<br>
<?php
  require_once 'footer.php';
?>
