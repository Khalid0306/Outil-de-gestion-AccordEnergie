<?php

require_once '../vendor/autoload.php';
use App\Page;

$page = new Page();
$msg = false;


if (isset($_POST['send'])) {
    // var_dump($_POST);
    
    $user = $page->getUserByEmail([
        'email' => $_POST['email'],
    ]);
    

    // var_dump($user);
      
    if(!$user){
        $msg="email ou mot de passe incorrect";
    } else {
        if (password_verify($_POST['password'], $user['password'])) {
        
            $msg="email bon";
            $page->Session->add('user',$user);
        }else {
            $msg="email ou mot de passe incorrect";
        }
    }

    header('Location: profile.php');
}



echo $page->render('index.html.twig', [ 'msg' =>$msg]);

