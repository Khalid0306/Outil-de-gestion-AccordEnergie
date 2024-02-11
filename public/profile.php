<?php
require_once '../vendor/autoload.php';
use App\Page;
$msg=false;
$page = new Page();
if (!isset($_SESSION['user'])){
    header('Location: index.php');
}

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['user'])) {
    // Récupérer les données de l'utilisateur depuis la base de données
    $userData = $page->Session->get('user');
    
    // Vérifier si l'utilisateur existe
    if ($userData) {
        echo $page->render('profil.html.twig', ['msg' => $msg, 'userData' => $userData]);
        exit();
    }
}


echo $page->render('profil.html.twig', [ 'user' => $userData]);

