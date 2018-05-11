<?php
require_once ('init.inc.php');
require_once ('fonctions.inc.php');
require_once ('navbar.php');


$req=$bdd->query('select * from membre');

$donnees=$req->fetchAll(PDO::FETCH_ASSOC);




if(isset($_GET['action'])&& $_GET['action']=="suppression"){

    $del=$bdd->prepare('delete from membre where id_membre=:id');
    $del->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $del->execute();


    $content .='<div class="alert alert-success col-md-8 col-md-offset-2 text-center">Le membre '.$_GET['id'].'a bien été supprimé ! </div>';


    $req=$bdd->query('select * from membre');

    $donnees=$req->fetchAll(PDO::FETCH_ASSOC);
    //debug($donnees, 2);

}

echo $content;


if(isset($_GET['action']) && $_GET['action']=="modification")




?>

<h1 style="color : darkblue; font-weight : bold; text-align :center; text-decoration: underline">GESTION DES MEMBRES</h1>

<div class="container">

    <table class="table table-striped" style="border: 1px solid darkblue; height:350px; width:100%">
        <tr class="info">
            <th>Pseudo</th>
            <th>Civilité</th>
            <th>Nom</th>
            <th>Prénom</th> 
            <th>Email</th>
            <th>Téléphone</th>
            <th>Date Enregistrement</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>


        <?php 

        for ($i=0; $i<$req->rowCount(); $i++){

            echo '</tr>';
            echo'<td>'.$donnees[$i]['pseudo'].'</td>';
            echo'<td>'.$donnees[$i]['civilite'].'</td>';
            echo'<td>'.$donnees[$i]['nom'].'</td>';
            echo'<td>'.$donnees[$i]['prenom'].'</td>';
            echo'<td>'.$donnees[$i]['email'].'</td>';
            echo'<td>'.$donnees[$i]['telephone'].'</td>';
            echo'<td>'.$donnees[$i]['date_enregistrement'].'</td>';
            echo'<td>'.$donnees[$i]['statut'].'</td>';
            echo'<td><a href="gestion_membre.php?action=recherche&id='.$donnees[$i]['id_membre'].'"><span class="glyphicon glyphicon-search">&nbsp;</span></a><a href="gestion_membre.php?action=modification&id='.$donnees[$i]['id_membre'].'"><span class="glyphicon glyphicon-edit">&nbsp;</span></a><a href="gestion_membre.php?action=suppression&id='.$donnees[$i]['id_membre'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';
            echo '<tr>';
        } 




        ?>

    </table>




    <div class="jumbotron">
        <form method="post" action="">


            <div class="row">
                <div class="col-md-6">
                    <label for="pseudo">Pseudo : </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div><input class="form-control" type="text" name="pseudo" placeholder="Votre pseudo" id="pseudo">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="mdp">Mot de passe : </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div><input class="form-control" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe">
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6">
                    <label for="nom">Nom: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></div><input class="form-control" type="text" name="nom" id="nom" placeholder="Votre nom">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="prenom">Prénom: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></div><input class="form-control" type="text" name="prenom" id="prenom" placeholder="Votre prenom">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label for="telephone">Téléphone : </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></div><input class="form-control" type="tel" name="telephone" id="telephone" placeholder="Votre téléphone">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="mdp">Email: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div><input class="form-control" type="email" name="email" id="email" placeholder="Votre email">
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-2">
                    <label for="civilite">Civilite :</label>
                    <select class="form-control">
                        <option value="monsieur">Monsieur</option>
                        <option value="Madame">Madame</option>
                        <option value="Mademoiselle">Mademoiselle</option>
                    </select>
                </div>
                <div class="col-md-2 col-md-offset-8">
                    <label for="statut">Statut :</label>
                    <select class="form-control">
                        <option value="admin">Admin</option>
                        <option value="membre">Membre</option>   
                    </select>
                </div>
            </div><br>

            <input type="submit" name="inscriSubmit" id="inscriSubmit" class="btn btn-info" value="S'inscrire">

        </form>
    </div>
</div>