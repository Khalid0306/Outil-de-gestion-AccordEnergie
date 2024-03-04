<?php

require_once '../vendor/autoload.php';
use App\Page;
use App\Repository\UserRepository;

$page = new Page();
$userRepo = new UserRepository($page->pdo);
$msg = false;


if (isset($_POST['send'])) {
    // var_dump($_POST);
    
    $user = $userRepo->getUserByEmail([
        'AdresseMail' => $_POST['email'],
    ]);
    
      
    if(!$user){
        $msg="email ou mot de passe incorrect";
    } else {
        if (password_verify($_POST['password'], $user['MotDePasse'])) {       
            $msg="email bon";
            $page->Session->add('user',$user);
        }
    }

    header('Location: profile.php');
}

echo $page->render('index.html.twig', [ 'msg' =>$msg]);

