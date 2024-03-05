<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Repository\UserRepository;

$page = new Page();
$userRepo = new UserRepository($page->pdo);

if (isset($_POST['send'])) {
    $data = [
        'Nom'         => $_POST['Nom'],
        'Prenom'      => $_POST['Prenom'],
        'AdresseMail' => $_POST['email'],
        'NumeroTel'   => $_POST['NumeroTel'],
        'Adresse'   => $_POST['Adresse'],
        'MotDePasse'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'Role'        => 'Client',
        'Created_at'  => date('Y-m-d H:i:s'),
        'Updated_at'  => date('Y-m-d H:i:s'),
    ];
    
    // $password = $_POST['password'];
    // var_dump($password);

    $userRepo->insertUser('user', $data);

    header('Location: index.php');
}

echo $page->render('register.html.twig', []);
