<?php
require_once 'fonctions.inc.php';
require_once 'init.inc.php';
require_once 'header.inc.php';

?>
  <nav class="navbar navbar-inverse">

  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#">TROC</a>
  </div>
  <div id="navbar" class="navbar-collapse collapse">
    <ul class="nav navbar-nav navbar-left">
          <li><a href="connexion.php?action=deconnexion">Déconnexion</a></li>          

    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="btn btn-default glyphicon glyphicon-user"> Espace membre</span></a>
        <ul class="dropdown-menu">
          <li><a href="inscription.php">Inscription</a></li>
          <li><a href="connexion.php">Connexion</a></li>
          <li><a href="profil.php">Profil</a></li> 
        </ul>
      </li>
    </ul>
    <form class="navbar-form navbar-center">
      <input type="text" class="form-control" placeholder="Search...">
    </form>
 
  </div>

</nav>
             
<div class="container mon-conteneur">


<br>
<br>

