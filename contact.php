<?php require_once ('init.inc.php');
require_once ('fonctions.inc.php');
require_once ('navbar.php');
?>

<div class="container" style="width : 100%; height : 100px; background-color : lightgrey">
    <br>
    <p style="font-size : 30px; text-align : center">Contactez-nous</p>
</div>
<br>
<div class="container" style="height : 200px; width : 30%; background-color : steelblue;">
    <span class="glyphicon glyphicon-lock" style="font-weight : bold; margin: 20px; font-size : 20px;">
        Engagement confidentialité</span>
    <p style="margin: 20px; font-size : 20px; text-align : justify">Troc s’engage à protéger vos données personnelles relatives à votre vie privée et à ne pas les diffuser à des fins commerciales</p>
</div>
<br>

<div class="container">
    <div class="jumbotron">
        <form class="form-inline" method="post" action="#">
            <h3 style="text-decoration : underline">Identité</h3>
            <br>
            <div class="form-group">
                <input type="text" class="form-control" name="nom" placeholder="Nom">
            </div>&nbsp;&nbsp;
            <div class="form-group">
                <input type="text" class="form-control" name="prenom" placeholder="Prénom">
            </div>&nbsp;&nbsp;
            <div class="form-group">
                <input type="text" class="form-control" name="recommande" placeholder="Recommandé par">
            </div>
            <h3 style="text-decoration : underline">Coordonnées</h3>
            <br>
            <div class="form-group">
                <input type="text" class="form-control" name="telephone" placeholder="Téléphone">
            </div>&nbsp;&nbsp;
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Courriel">
            </div>
            <br>
            <h3 style="text-decoration : underline">Commentaire</h3>
            <div class="form-group">
                <textarea  style="width : 450px;" class="form-control" name="commentaire" placeholder="Saisir votre commentaire" rows="5"></textarea>
            </div>
            <br>
            <br>
            <button type="submit" name="submit" class="btn btn-info"><span class="glyphicon glyphicon-envelope"></span> Envoyer</button>
        </form>
    </div>
</div>
<br>
<br>

<?php if(isset($_POST['submit'])){

    $message='Mail de : '.$_POST['nom'].' '.$_POST['prenom'].'<br><p>'.$_POST['commentaire'].'</p>';
  

    mail('andy_14@hotmail.fr', 'Mon premier mail test', $message);
}

?>


































<?php
require_once ('footer.php');
?>