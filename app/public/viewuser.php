<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Repository\UserRepository;

$page = new Page();
$userRepo = new UserRepository($page->pdo);
$title = "Register";
// Récupérer les données de l'utilisateur depuis la base de données
$userData = $page->Session->get('user');
if (!isset($_SESSION['user'])){
    header('Location: index.php');
    exit(); // Make sure to exit after redirection
}

// Check if the sorting direction is provided in the URL and sanitize the input
if (isset($_GET['Id'])) {
    // Si le paramètre 'Id' est présent dans l'URL, trier par ID
    $sortDirection = $_GET['Id'];
    $userlist = $userRepo->trier_id($sortDirection);
    
    // var_dump($userlist);
} elseif (isset($_GET['nom'])) {
    // Si le paramètre 'nom' est présent dans l'URL, trier par nom
    $sortNom = $_GET['nom'];
    $userlist = $userRepo->trier_nom($sortNom);
    // var_dump($userlist);
} else {
    // Si aucun paramètre de tri n'est présent, afficher tous les utilisateurs (ou une autre action par défaut)
    $userlist = $userRepo->getUsersByRole();
    // var_dump($userlist);
}

// Retrieve sorted user data based on the provided or default sorting direction
// $userlist = $userRepo->getUsersByRole();

// Render the user data using Twig or any other template engine
echo $page->render('viewuser.html.twig', ['userlist' => $userlist,'title' => $title,'user' => $userData]);
?>
