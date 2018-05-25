<?php
require_once('init.inc.php');
require_once('fonctions.inc.php');
require_once('navbar.php');
?>

<?php $req=$bdd->query('select * from membre');

$donnees=$req->fetchAll(PDO::FETCH_ASSOC);




if(isset($_GET['action'])&& $_GET['action']=="suppression"){

    $del=$bdd->prepare('delete from membre where id_membre=:id');
    $del->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $del->execute();


    $content .='<div class="alert alert-success col-md-8 col-md-offset-2 text-center">Le membre '.$_GET['id'].' a bien été supprimé ! </div>';


    $req=$bdd->query('select * from membre');

    $donnees=$req->fetchAll(PDO::FETCH_ASSOC);
    //debug($donnees, 2);

}

echo $content;


if(isset($_GET['action']) && $_GET['action']=="modification"){

    $req=$bdd->prepare("select * from membre where id_membre=:id");
    $req->bindValue('id', $_GET['id'], PDO::PARAM_INT);
    $req->execute();

    $donnees=$req->fetchAll(PDO::FETCH_ASSOC);
    //debug($donnees);

    foreach($donnees as $value){

        //debug($value);
    }

    if(isset($_POST['inscriSubmit'])){

        $maj=$bdd->prepare("update membre set pseudo=:pseudo, nom=:nom, prenom=:prenom, telephone=:telephone, email=:email, civilite=:civilite, statut=:statut where id_membre=:id");
        $maj->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
        $maj->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
        $maj->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
        $maj->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $maj->bindValue(':telephone', $_POST['telephone'], PDO::PARAM_INT);
        $maj->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $maj->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
        $maj->bindValue(':statut', $_POST['statut'], PDO::PARAM_STR);
        $maj->execute();





        $content .='<div class="alert alert-success col-md-8 col-md-offset-2 text-center">Le membre '.$_GET['id'].' a bien été modfié ! </div>';
    }


    $_GET['action']=="affichage";
    $req=$bdd->query('select * from membre');

    $donnees=$req->fetchAll(PDO::FETCH_ASSOC);
//debug($donnees, 2);
?>


<div class="container">
    <div class="jumbotron">
        <form id="form" method="post" action="#">


            <div class="row">
                <div class="col-md-6">
                    <label for="pseudo">Pseudo : </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div><input class="form-control" type="text" name="pseudo" placeholder="Votre pseudo" id="pseudo" value="<?= $value['pseudo'];?>">
                    </div>
                </div>
                <!--<div class="col-md-6">
                    <label for="mdp">Mot de passe : </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div><input class="form-control" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe" >
                    </div>
                </div>-->
            </div><br>
            <div class="row">
                <div class="col-md-6">
                    <label for="nom">Nom: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></div><input class="form-control" type="text" name="nom" id="nom" placeholder="Votre nom" value="<?= $value['nom'];?>" >
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="prenom">Prénom: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></div><input class="form-control" type="text" name="prenom" id="prenom" placeholder="Votre prenom" value="<?=$value['prenom'];?>"  >
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label for="telephone">Téléphone : </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></div><input class="form-control" type="tel"  name="telephone" id="telephone" placeholder="Votre téléphone" value="<?= $value['telephone'];?>"  >
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="mdp">Email: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div><input class="form-control" type="email" name="email" id="email" placeholder="Votre email" value="<?= $value['email'];?>" >
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-2">
                    <label for="civilite">Civilite :</label>
                    <select name="civilite" class="form-control">
                        <option value="monsieur"<?php if($value['civilite']=="monsieur"){ echo 'selected="selected"';}?>>Monsieur</option>
                        <option value="madame"<?php if($value['civilite']=="madame"){ echo 'selected="selected"';}?>>Madame</option>
                        <option value="mademoiselle"<?php if($value['civilite']=="mademoiselle"){ echo 'selected="selected"';}?>>Mademoiselle</option>
                    </select>
                </div>
                <div class="col-md-2 col-md-offset-8">
                    <label for="statut">Statut :</label>
                    <select name="statut" class="form-control">
                        <option value="admin" <?php if($value['statut']==1){ echo 'selected="selected"';}?>>Admin</option>
                        <option value="membre" <?php if($value['statut']==0){ echo 'selected="selected"';}?>>Membre</option>
                    </select>
                </div>
            </div><br>

            <input type="submit" name="inscriSubmit" id="inscriSubmit" class="btn btn-info center-block" value="Modifier">

        </form>
    </div>
</div>

<?php

    //header('Location:gestion_membre');
}



?>








<div class="container">

    <table class="table table-striped" style="border: 1px solid darkblue; width:100%">
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

</div>
<br><br><br><br>
<?php
require_once('footer.php');
?>
