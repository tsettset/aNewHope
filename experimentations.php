<head>
</head>
<script>

$(document).ready(function(){
  _prefix_img = 'img_';//globale, sera utilisee pour retrouver les id des images
  _prefix_file = 'file_';//globale, sera utilisee pour retrouver les id de l'interface d'upload de fichier
  _prefix_suppr = 'suppr_';//globale, sera utilisee pour retrouver les id des liens de suppression

  <?php  for ($i=1; $i < 6 ; $i++) {
    echo "var imgId = _prefix_img + `photo` + $i;";
    echo "var fileUploadId = _prefix_file + 'photo' + $i;";
    echo "var suppLinkId = _prefix_suppr + 'photo' + $i;";
    echo "console.log('imgId : ' + imgId + ' - fileUploadId : ' + fileUploadId + ' - suppLinkId : ' + suppLinkId);";
  }?>
}

</script>
