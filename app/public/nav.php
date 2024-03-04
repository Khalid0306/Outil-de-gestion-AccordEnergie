<?php

require_once '../vendor/autoload.php';

if ($page->Session->isConnected()) {
    // L'utilisateur est connecté
    $userData = $page->Session->get('user');
} else {
    // Redirection vers la page d'index ou de connexion
    header('Location: index.php');
    exit; // Assurez-vous de terminer l'exécution du script après la redirection
}

echo $page->render('navbar.html.twig', ['user' => $userData]);
