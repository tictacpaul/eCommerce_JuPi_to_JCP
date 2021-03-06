<?php
session_start();
require 'model.php';

if(!isset($_SESSION['connect']) || $_SESSION['connect'] != true)
    header('Location: index.php?action=adminaccess.php');

$title = 'ajouter un produit';

if (isset($_POST['name']) AND !empty($_POST['name'])
  AND isset($_POST['desc']) AND !empty($_POST['desc'])
  AND isset($_POST['price']) AND !empty($_POST['price'])
  AND isset($_POST['size']) AND !empty($_POST['size'])
  AND isset($_POST['color']) AND !empty($_POST['color'])
  AND isset($_FILES['img']) AND ($_FILES['img']['error'] == 0)
  AND ($_FILES['img']['size'] < 1000000)) {


    $name = htmlspecialchars($_POST['name']);
    $descr = htmlspecialchars($_POST['desc']);
    $price = htmlspecialchars($_POST['price']);
    $size = htmlspecialchars($_POST['size']);
    $color = htmlspecialchars($_POST['color']);
    $img = htmlspecialchars($_FILES['img']['name']);
    $infoimg = pathinfo($_FILES['img']['name']);
    $extension = $infoimg['extension'];

    if($extension == "png" OR $extension == "jpg") {
        if (is_numeric($price) AND is_numeric($size)) {

            addProduct($name, $descr, $price, $size, $color, $img);
            move_uploaded_file($_FILES['img']['tmp_name'], 'img/'.$img);
        }

        else {
            $err = 'veuillez entrer des chiffres dans les champs "prix" et "taille" ';
        }
    }

    else {
        $err = 'le fichier doit être au format jpg ou png';
    }
}

include 'include/header.php';

if(!isset($err)){
    echo "Votre produit a été enregistré.";
  }

else{
    echo "Erreur; <a href='index.php?action=adminPage'> Retour à la page précédente</a>";
}

include 'include/footer.html';
