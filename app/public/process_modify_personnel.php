<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Repository\UserRepository;

$page = new Page();
$userRepo = new UserRepository($page->pdo);


if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

// Vérifie si un formulaire de modification a été soumis
if (isset($_POST['update'])) {
    $userId = $_POST['Id'];

    // Collecte les données à mettre à jour
    $data = [
        'Nom'         => $_POST['Nom'],
        'Prenom'      => $_POST['Prenom'],
        'AdresseMail' => $_POST['email'],
        'NumeroTel'   => $_POST['NumeroTel'],
        'Adresse'     => $_POST['Adresse'],
        'Updated_at'  => date('Y-m-d H:i:s'),
    ];

    // Effectue la mise à jour de l'utilisateur
    if ($userRepo->updateUser('user', $data, ['Id' => $userId])) {
        // Redirige vers le tableau de bord après la modification réussie
        header('Location: dashbord_admin.php');
        exit();
    } else {
        // Gestion des erreurs de mise à jour, redirigez vers une page d'erreur ou affichez un message
        echo "Erreur lors de la mise à jour de l'utilisateur.";
    }
}

// Récupère les détails de l'utilisateur à partir de l'ID passé dans l'URL
if (isset($_GET['Id'])) {
    $userId = $_GET['Id'];
    $userDetails = $userRepo->getUserById('user', $userId);

    if ($userDetails) {
        echo $page->render('Modify_personnel.html.twig', ['userDetails' => $userDetails]);
    } else {
        // Gestion des erreurs si l'ID n'est pas valide, redirigez vers une page d'erreur ou affichez un message
        echo "ID d'utilisateur non valide.";
    }
} else {
    // Redirige vers une page d'erreur ou une autre page appropriée si l'ID n'est pas fourni
    header('Location: erreur.php');
    exit();
}
?>
