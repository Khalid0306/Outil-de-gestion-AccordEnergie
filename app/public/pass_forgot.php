<?php
require_once '../vendor/autoload.php';
use App\Page;
use App\Repository\UserRepository;

$msg = false;
$page = new Page();
$userRepo = new UserRepository($page->pdo);

if (isset($_POST['sendRequest'])) {
    //On vérifie si l'email est valide 
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if (!$email) {
        // Gestion d'erreur pour l'adresse email invalide
        $msg = "Veuillez fournir une adresse email valide.";
    } else {
        $userData = $userRepo->getUserByEmail(['email' => $email]);

        if ($userData) {
            $page->Session->add('user', $userData);
            header('Location: Confirmation.php', true, 302);
            exit();
        } else {
            // Gestion d'erreur pour l'adresse email non trouvée
            $msg = "Aucun utilisateur trouvé avec cette adresse email.";
        }
    }
}

echo $page->render('email_verify.html.twig', ['msg' => $msg]);
