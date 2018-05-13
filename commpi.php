<?php

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
    </div>
    <?php
  }
}
