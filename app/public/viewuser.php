<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Repository\UserRepository;


$page = new Page();
$userRepo = new UserRepository($page->pdo);





if (!isset($_SESSION['user'])){
    header('Location: index.php');
}



// Récupérer la liste des clients
$clientList = $userRepo->getUsersByRole();

// Afficher la liste des clients
echo $page->render('viewuser.html.twig', ['clientList' => $clientList]);
?>
