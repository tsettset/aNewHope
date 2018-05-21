<?php
require_once('init.inc.php');
require_once('fonctions.inc.php');
require_once('navbar.php');


$req=$bdd->query('select * from categorie');

$donnees=$req->fetchAll(PDO::FETCH_ASSOC);




if(isset($_GET['action'])&& $_GET['action']=="suppression"){

    $del=$bdd->prepare('delete from categorie where id_categorie=:id');
    $del->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $del->execute();


    $content .='<div class="alert alert-success col-md-8 col-md-offset-2 text-center">La catégorie '.$_GET['id'].' a bien été supprimée ! </div>';


    $req=$bdd->query('select * from categorie');

    $donnees=$req->fetchAll(PDO::FETCH_ASSOC);
    //debug($donnees, 2);

}

echo $content;
if(isset($_GET['action']) && $_GET['action']=="modification"){ ?>  
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
</div>

<?php $req=$bdd->prepare("select * from categorie where id_categorie=:id");
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
?>




<?php }

}
?>
    
    <div class="container">
    <div class="jumbotron">
    <form method="post" action="#">
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
                <div class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></div><input class="form-control" type="text" name="motscles" id="motscles" placeholder="Mots Clés"  >
            </div>
        </div>
    </div>
    <br>
    <input type="submit" name="catSubmit" id="catSubmit" class="btn btn-info center-block" value="Insérer">
</form>
</div>
</div>
    
   <?php if(isset($_POST["catSubmit"])){

            $ins=$bdd->prepare('insert into categorie (titre, motscles)values(:titre, :motscles)');
            $ins->bindValue(':titre', $_POST['titre']);
            $ins->bindValue(':motscles', $_POST['motscles']);
            $ins->execute();
            $content .='<div class="alert alert-success col-md-8 col-md-offset-2 text-center">La catégorie '.$_POST['titre'].' a bien été insérer ! </div>';
        }

        echo $content;

        $req=$bdd->query('select * from categorie');

        $donnees=$req->fetchAll(PDO::FETCH_ASSOC);
        //debug($donnees, 2) }
?>






<script>
    /*document.getElementById('inscriSubmit').addEventListener('click',function(){
       var test= document.getElementById('form').style.display="none";
    console.log(test);

});*/

</script>
<?php 

        //header('Location:gestion_membre');
    



?>








<div class="container">

    <table class="table table-striped" style="border: 1px solid darkblue; width:100%">
        <tr class="info">
            <th>Titre</th>
            <th>Mots Clés</th>       
            <th>Action</th>
        </tr>

        <?php 

    for ($i=0; $i<$req->rowCount(); $i++){

        echo '</tr>';
        echo'<td>'.$donnees[$i]['titre'].'</td>';
        echo'<td>'.$donnees[$i]['motscles'].'</td>';
        echo'<td><a href="gestion_categorie.php?action=recherche&id='.$donnees[$i]['id_categorie'].'"><span class="glyphicon glyphicon-search">&nbsp;</span></a><a href="gestion_categorie.php?action=modification&id='.$donnees[$i]['id_categorie'].'"><span class="glyphicon glyphicon-edit">&nbsp;</span></a><a href="gestion_categorie.php?action=suppression&id='.$donnees[$i]['id_categorie'].'"><span class="glyphicon glyphicon-trash"></span></a></td>';
        echo '<tr>';
    } 





        ?>

    </table>
</div>
<br><br><br><br>
<?php
    require_once('footer.php');
?>

