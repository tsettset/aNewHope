<?php
require_once ('init.inc.php');
require_once ('fonctions.inc.php');
require_once ('navbar.php');


if(isset($_GET['action']) && $_GET['action']=="deconnexion"){

   session_destroy();
   header('Location: accueil.php');
  
}




if($_POST){

   $verif=$bdd->prepare('SELECT * FROM membre where pseudo=:pseudo and mdp=:mdp LIMIT 1');
   //debug($verif);
   $verif->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
   $verif->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
   $verif->execute();
   $donnees=$verif->fetch(PDO::FETCH_ASSOC);
   //debug($donnees);

   if($verif->rowCount() >0){

      $_SESSION['id_membre']=$donnees['id_membre'] ;
      $_SESSION['pseudo']=$donnees['pseudo'] ;
      $_SESSION['statut']=$donnees['statut'];
      //debug($_SESSION);
      echo 'vous êtes bien connecté';



      //debug($_SESSION);
      /*internauteEstConnecte();   

      header('Location: profil.php');*/

      if(internauteEstConnecte() || internauteEstConnecteEtEstAdmin()){

         header('Location: profil.php');
      }

   }else {

      echo ' votre mot de passe et/ou pseudo sont erronés, veuillez recommencer';
   }
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



         <input type="submit" name="submit"  id="submit" class="btn btn-info" value="Se connecter">

      </form>
   </div>
</div>
<?php
require_once ('footer.php');
?>