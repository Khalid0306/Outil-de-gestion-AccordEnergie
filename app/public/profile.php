<?php
require_once '../vendor/autoload.php';
use App\Page;
$msg=false;
$page = new Page();

if (!isset($_SESSION['user'])){
    header('Location: index.php');
}

 // Récupérer les données de l'utilisateur depuis la base de données
 $userData = $page->Session->get('user');
    
 // Vérifier si l'utilisateur existe
 if ($userData) {
     echo $page->render('profil.html.twig', ['msg' => $msg, 'userData' => $userData]);
     exit();    
 }

echo $page->render('profil.html.twig', [ 'user' => $userData]);

<<<<<<< HEAD
=======



>>>>>>> 6d1a8a0bd7b83efb35465b8a78f2ecac4c50a37d
if (isset($_POST['sends'])) {
    header('Location: suivi_intervention.php');
    exit(); // Assurez-vous de terminer le script après une redirection
}
echo $page->render('suivi_intervention.php', [ 'msg' =>$msg]);
<<<<<<< HEAD
=======

>>>>>>> 6d1a8a0bd7b83efb35465b8a78f2ecac4c50a37d
