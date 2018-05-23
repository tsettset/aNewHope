<div class="row">
  <div class="col-xs-8 col-xs-offset-2 text-center">
  <h2>Commentaires</h2>
  </div>
</div>
<?php

if (empty($_SESSION['id_membre'])){?>
  <div class="row">
    <div class="col-xs-8 col-xs-offset-2 text-center">
      Connectez-vous pour laisser un commentaire.
    </div>
  </div>
  <?php
}else{?>
  <form method="POST" id="ajoutComm">
    <div class="row form-group">
      <div class="col-xs-8 col-xs-offset-2 text-center form-group">
        <?php
        if (!empty($annonce['comm_msg'])){
          echo '<p>';
          echo $annonce['comm_msg'];
          echo '</p>';
        }
        ?>
        <textarea class="form-control" name="post_comment" id="post_comment" placeholder="Ecrire un commentaire..."></textarea>
        <button type="submit" class="btn btn-default">Envoyer</button>
      </div>
    </div>
  </form>
  <?php
}


if (!empty($annonce['commentaires'])){
  foreach ($annonce['commentaires'] as $value) {?>
    <div class="row">
      <div class="col-xs-2 col-xs-offset-4 text-center">
        <?php echo getPseudoMembre($value['membre_id']);?>
      </div>
      <div class="col-xs-2 text-center">
        <?php echo $value['date_enregistrement'].'<br>';?>
      </div>

      <div class="col-xs-8 col-xs-offset-2 text-center">
        <?php echo $value['commentaire'].'<br>';?>
      </div>
      <div class="col-xs-8 col-xs-offset-2 text-center">
        <?php
        if (isset($_SESSION['id_membre'])){
          echo '<form method="post">';
          if ($_SESSION['id_membre'] == $value['membre_id']){
            echo '<button type="submit" class="btn btn-danger">Supprimer votre message</button>';
          } elseif ($_SESSION['statut'] == 1) {
            echo '<button type="submit" class="btn btn-danger">Supprimer le message de ce membre</button>';
          }
          echo '</form>';
        }
        ?>
      </div>
    </div>
    <?php
  }
}
