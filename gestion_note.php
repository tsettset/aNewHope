<?php

require_once('init.inc.php');
require_once('fonctions.inc.php');
require_once('navbar.php');


$req=$bdd->query('select * from note');

$donnees=$req->fetchAll(PDO::FETCH_ASSOC);




if(isset($_GET['action'])&& $_GET['action']=="suppression"){

    $del=$bdd->prepare('delete from note where id_note=:id');
    $del->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $del->execute();


    $content .='<div class="alert alert-success col-md-8 col-md-offset-2 text-center">La note '.$_GET['id'].' a bien été supprimée ! </div>';


    $req=$bdd->query('select * from note');

    $donnees=$req->fetchAll(PDO::FETCH_ASSOC);
    //debug($donnees, 2);

}

echo $content;
/*if(isset($_GET['action']) && $_GET['action']=="modification"){ ?>  
<div class="container">
    <div class="jumbotron">
        <form id="form" method="post" action="#">
            <div class="row">
                <div class="col-md-6">
                    <label for="titre">Titre: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></div><input class="form-control" type="text" name="titre" id="titre" placeholder="Titre">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="motscles">Mots Clés: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></div><input class="form-control" type="text" name="motscles" id="motscles" placeholder="Mots Clés" >
                    </div>
                </div>
            </div>
            <br>

            <input type="submit" name="inscriSubmit" id="inscriSubmit" class="btn btn-info center-block" value="Modifier">

        </form>
    </div>
</div>*/

/*$req=$bdd->prepare("select * from commentaire where id_=:id");
    $req->bindValue('id', $_GET['id'], PDO::PARAM_INT);
    $req->execute();

    $donnees=$req->fetchAll(PDO::FETCH_ASSOC);
    //debug($donnees);

    foreach($donnees as $value){

        //debug($value);
    }

    if(isset($_POST['inscriSubmit'])){

        $maj=$bdd->prepare("update categorie set motscles=:mcles, titre=:titre where id_categorie=:id");
        $maj->bindValue(':id', $_GET['id'], PDO::PARAM_INT);   
        $maj->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
        $maj->bindValue(':mcles', $_POST['motscles'], PDO::PARAM_STR);      
        $maj->execute();

        $content .='<div class="alert alert-success col-md-8 col-md-offset-2 text-center">La catégorie '.$_GET['id'].' a bien été modfiée ! </div>';
        //header('Location: gestion_categorie.php');
 }

}*/
       $req=$bdd->query('select * from note');

        $donnees=$req->fetchAll(PDO::FETCH_ASSOC);
        //debug($donnees, 2) }
?>

<div class="container">

    <table class="table table-striped" style="border: 1px solid darkblue; width:100%">
        <tr class="info">
            <th>id_note</th>
            <th>id_membre1</th>       
            <th>id_membre2</th>
            <th>Note</th>
            <th>Avis</th>
            <th>Date enregistrement</th>
            <th>Action</th>
        </tr>

        <?php 

    for ($i=0; $i<$req->rowCount(); $i++){
        debug($donnees[$i]);
        echo '</tr>';
        echo'<td>'.$donnees[$i]['id_note'].'</td>';
        echo'<td>'.$donnees[$i]['membre_id1'].'</td>';
        echo'<td>'.$donnees[$i]['membre_id2'].'</td>';
        echo'<td>'.$donnees[$i]['note'].'</td>';
        echo'<td>'.$donnees[$i]['avis'].'</td>';
        echo'<td>'.$donnees[$i]['date_enregistrement'].'</td>';
        echo'<td><a href="gestion_note.php?action=recherche&id='.$donnees[$i]['id_note'].'"><span class="glyphicon glyphicon-search">&nbsp;</span></a><a href="gestion_note.php?action=suppression&id='.$donnees[$i]['id_note'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';
        echo '<tr>';
    } 

?>

   </table>
</div>

   

 
<br><br><br><br>
<?php
    require_once('footer.php');
?>