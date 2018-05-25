<?php 
require_once ('init.inc.php');
require_once ('fonctions.inc.php');
require_once ('navbar.php');

/*Top 5 des membres les mieux notés

select n.membre_id2, concat(m.prenom,' ',m.nom) as coord, avg(n.note) as moy_note, count(n.avis) as nb_avis from membre m inner join note n on m.id_membre=n.membre_id2 group by coord order by moy_note desc limit 5;


Top 5 membre les plus actifs
select concat(m.prenom, ' ',m.nom) as coord, count(c.id_commentaire)as nb_comm from membre m inner join commentaire c on m.id_membre=c.membre_id group by coord order by nb_comm desc  limit 5;


Top 5 des annonces les plus anciennes

Top 5 des catégories contenant les plus d'annonces
select c.id_categorie, c.titre, count(a.id_annonce) as nb_annonce from annonce a inner join categorie c on a.categorie_id=c.id_categorie group by 1 order by 3 desc;

Top 5 des annonces les plus anciennes

select titre, date_enregistrement from annonce group by date_enregistrement desc;*/
?>

<div class="container">
<h1 class="text-center" style="background-color : steelblue; height : 50px;">STATISTIQUES</h1>

<h2 class="text-center">Top 5 des membres les mieux notés</h2><br>
<?php 
$req=$bdd->query("select n.membre_id2, concat(m.prenom,' ',m.nom) as coord, round(avg(n.note)) as moy_note, count(n.avis) as nb_avis from membre m inner join note n on m.id_membre=n.membre_id2 group by coord order by moy_note desc limit 5");
$donnees=$req->fetchAll(PDO::FETCH_ASSOC);

$content=" ";
$content.='<table class="table table-striped" style="border: 1px solid darkblue; width:40%; margin:auto;">';
foreach($donnees as $key=>$value){
;
        $content.='<tr>';


                $content.='<th><hr>'.$value['coord'].' <span class="badge col-md-offset-9" style="width:20%;">Note de '.$value['moy_note'].' sur '.$value['nb_avis'].'</span></th>';
        
 
        $content.='</tr>';
}
$content.='</table>'; 
echo $content;
?>
<h2 class="text-center">Top 5 membre les plus actifs</h2><br>
<?php 
$req=$bdd->query("select concat(m.prenom, ' ',m.nom) as coord, count(c.id_commentaire)as nb_comm from membre m inner join commentaire c on m.id_membre=c.membre_id group by coord order by nb_comm desc  limit 5");
$donnees=$req->fetchAll(PDO::FETCH_ASSOC);

$content=" ";
$content.='<table class="table table-striped" style="border: 1px solid darkblue; width:40%; margin:auto;">';
foreach($donnees as $key=>$value){
      
        $content.='<tr>';


                $content.='<th><hr>'.$value['coord'].' <span class="badge col-md-offset-9" style="width:20%;">'.$value['nb_comm'].' commentaires</span></th>';
        
 
        $content.='</tr>';
}
$content.='</table>'; 
echo $content;

?>

<h2 class="text-center">Top 5 des catégories contenant les plus d'annonces</h2><br>

<?php 
$req=$bdd->query("select c.id_categorie, c.titre, count(a.id_annonce) as nb_annonce from annonce a inner join categorie c on a.categorie_id=c.id_categorie group by 1 order by 3 desc limit 5");
$donnees=$req->fetchAll(PDO::FETCH_ASSOC);

$content=" ";
$content.='<table class="table table-striped" style="border: 1px solid darkblue; width:40%; margin:auto;">';
foreach($donnees as $key=>$value){
      
        $content.='<tr>';


                $content.='<th><hr>'.$value['titre'].' <span class="badge col-md-offset-9" style="width:20%;">'.$value['nb_annonce'].' annonces</span></th>';
        
 
        $content.='</tr>';
}
$content.='</table>'; 
echo $content;

?>

<h2 class="text-center">Top 5 des annonces les plus anciennes</h2><br>

<?php 
$req=$bdd->query("select titre, date_enregistrement from annonce group by date_enregistrement asc");
$donnees=$req->fetchAll(PDO::FETCH_ASSOC);

$content=" ";
$content.='<table class="table table-striped" style="border: 1px solid darkblue; width:40%; margin:auto;">';
foreach($donnees as $key=>$value){
      
        $content.='<tr>';


                $content.='<th><hr>'.$value['date_enregistrement'].' <span class="badge col-md-offset-9" style="width:20%;">'.$value['titre'].' </span></th>';
        
 
        $content.='</tr>';
}
$content.='</table>'; 
echo $content;

?>

</div>
<br>
<br>
<br>
<br>

<?php

require_once('footer.php');

?>








