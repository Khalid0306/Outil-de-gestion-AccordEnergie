<?php
require_once '../vendor/autoload.php';

use App\Page;
use App\Repository\UserRepository;

$page = new Page();
$userRepo = new UserRepository($page->pdo);
$msg = false;
$title = "Change Password";

if (isset($_POST['send'])) {
    
    try {
<<<<<<< HEAD
<<<<<<< HEAD
        $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $newPassword_cfh = password_hash($_POST['password_cfh'], PASSWORD_DEFAULT);

        if (empty($newPassword) || empty($newPassword_cfh)) {
            throw new \InvalidArgumentException('Invalid input');
        }

        // Valider l'adresse email
        $email = filter_var($userData['email'], FILTER_VALIDATE_EMAIL);

        if ($email === false) {
            throw new \InvalidArgumentException('Adresse e-mail invalide');
        }
=======
        $newPassword = $_POST['password'];
        $newPassword_cfh = $_POST['password_cfh'];
>>>>>>> Calendar
=======
        $newPassword = $_POST['password'];
        $newPassword_cfh = $_POST['password_cfh'];
>>>>>>> Calendar

        $userData = $page->Session->get('user');
        $emailUser = $userData['AdresseMail'];

        $userRepo->updatePassword($newPassword, $newPassword_cfh, $emailUser);
    } catch (\PDOException $e) {
        $msg = 'Erreur lors de la mise à jour du mot de passe: ' . $e->getMessage();
    } catch (\InvalidArgumentException $e) {
        $msg = 'Erreur: ' . $e->getMessage();
    }
}

echo $page->render('pass_forgot.html.twig', [
    'msg' => $msg,
    'title' => $title
]);
