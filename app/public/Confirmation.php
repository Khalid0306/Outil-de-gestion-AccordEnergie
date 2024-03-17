<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Repository\UserRepository;

$page = new Page();
$userRepo = new UserRepository($page->pdo);
$msg = false;

if (isset($_POST['send'])) {
    
    try {
        $newPassword = $_POST['password'];
        $newPassword_cfh = $_POST['password_cfh'];

        $userData = $page->Session->get('user');
        $emailUser = $userData['AdresseMail'];

        $userRepo->updatePassword($newPassword, $newPassword_cfh, $emailUser);
    } catch (\PDOException $e) {
        $msg = 'Erreur lors de la mise à jour du mot de passe: ' . $e->getMessage();
    } catch (\InvalidArgumentException $e) {
        $msg = 'Erreur: ' . $e->getMessage();
    }
}

echo $page->render('pass_forgot.html.twig', ['msg' => $msg]);
