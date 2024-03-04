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
        'Adresse'     => $_POST['Adresse'],
        'MotDePasse'  => password_hash($_POST['password'], PASSWORD_DEFAULT),
        'Role'        => $_POST['role'], 
        'Created_at'  => date('Y-m-d H:i:s'),
        'Updated_at'  => date('Y-m-d H:i:s'),
    ];

    $userRepo->insertUser('user', $data);

    header('Location: dashbord_admin.php');
}

echo $page->render('Add_personnel.html.twig', []);
?>
