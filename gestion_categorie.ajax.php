<?php
require_once('init.inc.php');

if (isset($_GET['action'])) {

  if(!isset($_SESSION)){
    session_start();
  }

  $tab_retour = array();
  $tab_retour['valide'] = 1;

  switch ($_GET['action']) {

    case 'suppression':
    if (isset($_POST['id_categorie'])){
      if (!supprCategorie(intval($_POST['id_categorie']))){
        $tab_retour['categorie'] = 0;
      } else {
        $tab_retour['categorie'] = 1;
      }
    }
    break;

    case 'modif' :
      if (isset($_POST['titre'])){
        if (!empty($_POST['titre'])){
          saveCategorie($_POST);
        } else {
          $tab_retour['valide']=0;
          $tab_retour['err_message'] = 'Le titre ne peut pas etre vide';
        }
      }
      break;

      case 'liste':
      $tab_retour['categorie'] = getCategories();
      if (isset($_POST['catmod']) && !empty($_POST['catmod'])){
        $tab_retour['catmod'] = $_POST['catmod'];
      }
      break;

      case 'orderBy':
      if(isset($_SESSION['categories']['orderBy']) && isset($_POST['orderBy'])){
        $_SESSION['categories']['orderBy'] = $_POST['orderBy'];
      } else {
        $tab_retour['valide'] = 0;
      }
      break;

      default:
      $tab_retour['valide'] = 0;
      break;
    }

    echo json_encode($tab_retour);

  }


  function getCategories(){
    global $bdd;
    if(isset($_SESSION['categories']['orderBy'])){
      $orderBy = $_SESSION['categories']['orderBy'];
    } else {
      $orderBy = 'ASC';
    }

    $req_cat = $bdd->query("SELECT * FROM categorie ORDER BY titre $orderBy");
    if ($req_cat && $req_cat->rowCount() > 0){
      return $req_cat->fetchAll(PDO::FETCH_ASSOC);
    } else return 0;
  }

  function supprCategorie($id_categorie){
    global $bdd;
    $req_supp = $bdd->query("DELETE FROM categorie WHERE id_categorie= $id_categorie");
    return $req_supp;
  }

  function saveCategorie($post){
    global $bdd;
    $req_update=$bdd->prepare("UPDATE categorie SET titre = :titre, motscles=:motscles WHERE id_categorie= :id_categorie");
    $req_update->bindValue(':titre', $post['titre'], PDO::PARAM_STR);
    $req_update->bindValue(':motscles', $post['motscles'], PDO::PARAM_STR);
    $req_update->bindValue(':id_categorie', $post['id_categorie'], PDO::PARAM_STR);
    $req_update->execute();
  }
  ?>
