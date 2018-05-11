<?php

require_once('init.inc.php');
require_once('fonctions.inc.php');
require_once('navbar.php');



$req=$bdd->prepare('select * from membre where id_membre=:id');
$req->bindValue(':id', $_SESSION['id_membre'], PDO::PARAM_STR);
$req->execute();
debug($req);
$donnees=$req->fetch(PDO::FETCH_ASSOC);


?>

<h1 style="color : darkblue; text-decoration : underline; font-weight : bold; text-align : center">PROFIL</h1>
<div class="jumbotron" >
    
    <p style="text-align : center"><span style="font-weight : bold; color: darkblue">Pseudo : </span> <?= $_SESSION['pseudo']; ?></p>
    <p style="text-align : center"><span style="font-weight : bold; color: darkblue">Nom : </span> <?= $_SESSION['nom']=$donnees['nom']; ?></p>
    <p style="text-align : center"><span style="font-weight : bold; color: darkblue">Prénom : </span> <?= $_SESSION['prenom']=$donnees['prenom']; ?></p>
    <p style="text-align : center"><span style="font-weight : bold; color: darkblue">Email : </span> <?= $_SESSION['email']=$donnees['email']; ?></p>
    <p style="text-align : center"><span style="font-weight : bold; color: darkblue">Téléphone : </span> <?= $_SESSION['telephone']=$donnees['telephone']; ?></p>
    <p style="text-align : center"><span style="font-weight : bold; color: darkblue">Date d'inscription : </span><?= $_SESSION['date_enregistrement']=$donnees['date_enregistrement']; ?></p>
    

</div>
