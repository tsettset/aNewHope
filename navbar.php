<?php
require_once ('fonctions.inc.php');
require_once ('init.inc.php');
require_once ('header.inc.php');
?>
<nav class="navbar navbar-fixed-top" style="background-color : black; color : steelblue">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" style="background-color : #303030">
      <span class="sr-only">Toggle navigation</span>
      <span style="background-color: steelblue" class="icon-bar"></span>
      <span style="background-color: steelblue" class="icon-bar"></span>
      <span style="background-color: steelblue" class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="accueil.php">TROC</a>
  </div>
  <div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
      <li><a href="contact.php">Qui sommes nous ?</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="accueil.php">Annonces</a></li>
      <?php if(internauteEstConnecteEtEstAdmin()){
        echo '<li><a href="gestion_membre.php">Gestion membre</a></li>';
        echo '<li><a href="gestion_commentaire.php">Gestion commentaire</a></li>';
        echo '<li><a href="gestion_note.php">Gestion note</a></li>';
        echo '<li><a href="gestion_categorie.php">Gestion catégorie</a></li>';
        // echo '<li><a href="gestion_annonce.php">Gestion annonce</a></li>';
        echo '<li><a href="statistique.php">Statistiques</a></li>';
      }  ?>
    </ul>
    <ul class="nav navbar-nav navbar-right" style="margin-right :10px;">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="  glyphicon glyphicon-user"> Espace membre</span></a>
        <ul class="dropdown-menu">
          <?php if(!internauteEstConnecte()){
            echo '<li style="font-size: 20px;"><a href="inscription.php">Inscription</a></li>';
            echo '<li style="font-size: 20px;"><a href="connexion.php">Connexion</a></li>';

          }else{

            echo'<li style="font-size: 20px;"><a href="profil.php">Profil</a></li>';
            echo'<li><a href="connexion.php?action=deconnexion" style="font-size: 20px; margin-top:10px;">Déconnexion</a></li>';
          }?>
        </ul>
      </li>
    </ul>
  </div>
</nav>

<br>
<br>
