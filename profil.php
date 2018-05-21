<?php

require_once('init.inc.php');
require_once('fonctions.inc.php');
require_once('navbar.php');
require_once('footer.php');
?>


<?php
$req=$bdd->prepare('select * from membre where id_membre=:id');
$req->bindValue(':id', $_SESSION['id_membre'], PDO::PARAM_STR);
$req->execute();
debug($req);
$donnees=$req->fetch(PDO::FETCH_ASSOC);

?>

<?php if(isset($_GET['action']) && $_GET['action']=="modification"){ ?> 
<div class="container">
    <div class="jumbotron">
        <form id="form" method="post" action="#">
            <div class="row">
                <div class="col-md-6">
                    <label for="pseudo">Pseudo : </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div><input class="form-control" type="text" name="pseudo" placeholder="Votre pseudo" id="pseudo" value="<?= $donnees['pseudo'];?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="mdp">Mot de passe : </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div><input class="form-control" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe" >
                    </div>
                </div>  
                <div class="col-md-6">
                    <label for="mdp2">Confirmer mot de passe : </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div><input class="form-control" type="password" name="mdp2" id="mdp2" placeholder="confirmer mot de passe">
                        <?php if(isset($_POST['mdp'])){
    if($_POST['mdp2']!==$_POST['mdp']){?>
                        <div style="background-color: red" class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></div>             
                        <?php }else{ ?>
                        <div  style="background-color: green" class="input-group-addon"><span class="glyphicon glyphicon-ok"></span></div>
                        <?php } } ?>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6">
                    <label for="nom">Nom: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></div><input class="form-control" type="text" name="nom" id="nom" placeholder="Votre nom" value="<?= $donnees['nom'];?>" >
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="prenom">Prénom: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></div><input class="form-control" type="text" name="prenom" id="prenom" placeholder="Votre prenom" value="<?=$donnees['prenom'];?>"  >
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label for="telephone">Téléphone : </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></div><input class="form-control" type="tel"  name="telephone" id="telephone" placeholder="Votre téléphone" value="<?= $donnees['telephone'];?>"  >
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="mdp">Email: </label>
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div><input class="form-control" type="email" name="email" id="email" placeholder="Votre email" value="<?= $donnees['email'];?>" >
                    </div>
                </div>
            </div><br>     
            <input type="submit" name="inscriSubmit" id="inscriSubmit" class="btn btn-info center-block" value="Modifier profil">
        </form>
        <br>
        <br>
        <br>
        <?php if(isset($_POST['inscriSubmit'])){
    if(empty($_POST['mdp']) && empty($_POST['mdp2'])){     
        $maj=$bdd->prepare("replace into membre(id_membre, pseudo, nom, prenom, mdp, telephone, email, civilite, statut)values(:id, :pseudo, :nom, :prenom, :mdp, :telephone, :email, :civilite, :statut)"); 
        $maj->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
        $maj->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
        $maj->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
        $maj->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $maj->bindValue(':mdp', $donnees['mdp'], PDO::PARAM_STR);
        $maj->bindValue(':telephone', $_POST['telephone'], PDO::PARAM_INT);
        $maj->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $maj->bindValue(':civilite', $donnees['civilite'], PDO::PARAM_STR);
        $maj->bindValue(':statut', $donnees['statut'], PDO::PARAM_STR);
        $maj->execute();         
    }else{       
        if($_POST['mdp']==$_POST['mdp2']){
            $maj=$bdd->prepare("update membre set pseudo=:pseudo, nom=:nom, prenom=:prenom, mdp=:mdp, telephone=:telephone, email=:email where id_membre=:id");
            $maj->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
            $maj->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
            $maj->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
            $maj->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
            $maj->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
            $maj->bindValue(':telephone', $_POST['telephone'], PDO::PARAM_INT);
            $maj->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
            $maj->execute();
        }else{
            echo '<div style="font-size: 20px" class="alert alert-danger"><span style="color: red; font-size: 130%" class="glyphicon glyphicon-warning-sign"></span>&nbsp;&nbsp;Mots de passe differents</div>';
            echo '</div>';
            echo '</div>';

        }       
    }



}


                                                                   }

$req=$bdd->query('select * from membre where id_membre="'.$donnees['id_membre'].'"');
$donnees=$req->fetch(PDO::FETCH_ASSOC);         
?>

<h1 style="color : darkblue; text-decoration : underline; font-weight : bold; text-align : center">PROFIL</h1>
    <div class="jumbotron" >

    <p style="text-align : center"><span style="font-weight : bold; color: darkblue">Pseudo : </span> 
        <?= $_SESSION['pseudo']=$donnees['pseudo'];?></p>
    <p style="text-align : center"><span style="font-weight : bold; color: darkblue">Nom : </span> 
        <?= $_SESSION['nom']=$donnees['nom']; ?></p>
    <p style="text-align : center"><span style="font-weight : bold; color: darkblue">Prénom : </span> 
        <?= $_SESSION['prenom']=$donnees['prenom']; ?></p>
    <p style="text-align : center"><span style="font-weight : bold; color: darkblue">Email : </span> 
        <?= $_SESSION['email']=$donnees['email']; ?></p>
    <p style="text-align : center"><span style="font-weight : bold; color: darkblue">Téléphone : </span> 
        <?= $_SESSION['telephone']=$donnees['telephone']; ?></p>
    <p style="text-align : center"><span style="font-weight : bold; color: darkblue">Date d'inscription : </span>
        <?= $_SESSION['date_enregistrement']=$donnees['date_enregistrement']; ?></p><br>
    <a href="profil.php?action=modification&id=<?= $_SESSION['id_membre'];?>"><input type="button" name="submit"  id="submit" class="btn btn-info center-block" value="Modifier le profil"></a>
</div>



