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


