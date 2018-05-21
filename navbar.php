<?php
require_once ('fonctions.inc.php');
require_once ('init.inc.php');
require_once ('header.inc.php');
?>
<nav class="navbar navbar-inverse navbar-fixed-top">

  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="accueil.php">TROC</a>
  </div>
  <div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
      <li><a href="#">Qui nous sommes nous ?</a></li>        
      <li><a href="#">Contact</a></li>  
      <li><a href="#">Annonces</a></li>
<?php if(internauteEstConnecteEtEstAdmin()){ 
  echo '<li><a href="gestion_membre.php">Gestion_membre</a></li>';
  echo '<li><a href="gestion_commentaire.php">Gestion_commentaire</a></li>';
  echo '<li><a href="gestion_note.php">Gestion_note</a></li>';
  echo '<li><a href="gestion_categorie.php">Gestion_catégorie</a></li>';
  echo '<li><a href="gestion_annonce.php">Gestion_annonce</a></li>';
  echo '<li><a href="statistique.php">Statistiques</a></li>';
}  ?>
    </ul>
    <ul class="nav navbar-nav col-md-2">
      <li style="width:80%"><form style="margin-top:8px;">
        <input type="text" class="form-control" placeholder="Search...">
        </form></li>
    </ul>
    <ul class="nav navbar-nav navbar-right" style="margin-right :10px;">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="  glyphicon glyphicon-user"> Espace membre</span></a>
        <ul class="dropdown-menu">
<?php if(!internauteEstConnecte()){
  echo '<li style="font-size: 20px;"><a href="inscription.php">Inscription</a></li>';
  echo '<li style="font-size: 20px;"><a href="connexion.php">Connexion</a></li>';
  //header('Location: accueil.php');
}else{
          
          echo'<li style="font-size: 20px;"><a href="profil.php">Profil</a></li>';
          echo'<li><a href="connexion.php?action=deconnexion" style="font-size: 20px; margin-top:10px;">Déconnexion</a></li>';
} ?>
</ul>
      </li>
    </ul>
  </div>
</nav>
<br>
<br>
