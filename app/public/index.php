<?php

require_once '../vendor/autoload.php';
use App\Page;
use App\Repository\UserRepository;

$page = new Page();
$userRepo = new UserRepository($page->pdo);
$msg = false;

if (isset($_POST['send'])) {
    $user = $userRepo->getUserByEmail([
        'AdresseMail' => $_POST['email'],
    ]);
    
    if (!$user) {
        $msg = "Email ou mot de passe incorrect";
    } else {
        if (password_verify($_POST['password'], $user['MotDePasse'])) {
            $msg = "Connexion réussie";
            
            $page->Session->add('user', $user);
            // Ajouter une vérification pour rediriger les admins vers le tableau de bord
            if ($user['Role'] == 'Admin') {
                header('Location: dashbord_admin.php');
            } else {
                header('Location: profile.php');
            }
        } else {
            $msg = "Mot de passe incorrect";
        }
    }
}

echo $page->render('index.html.twig', ['msg' => $msg]);
?>
