<?php
require_once '../vendor/autoload.php';
use App\Page;
$msg=false;
$page = new Page();

// On verifie qu'on récupére le formulaire
if (isset($_POST['sendResquest'])){
    // On récupére le mail
    ;

    $userData = $page->getUserByEmail([
        'email' => $_POST['email'],
    ]);


    

    if ($userData) {
        $page->Session->add('user',$userData);
       header('Location: Confirmation.php');

         
        exit();
    }

    // header('Location: index.php');
}

echo $page->render('email_verify.html.twig', []);

