<?php
require_once '../vendor/autoload.php';
use App\Page;
$msg=false;
$page = new Page();

use App\Repository\UserRepository;

$userRepo = new UserRepository($page->pdo);

if (!isset($_SESSION['user'])){
    header('Location: index.php');
}

$userData = $page->Session->get('user');
$title = "Register";

$sqluser = "SELECT COUNT(*) AS total FROM user";
$sthuser = $page->pdo->prepare($sqluser);
$sthuser->execute();

$sqlmail = "SELECT COUNT(DISTINCT AdresseMail) AS total FROM user
";
$sthmail = $page->pdo->prepare($sqlmail);
$sthmail->execute();


$sthintervention = "SELECT COUNT(*) AS total FROM intervention";
$sthintervention = $page->pdo->prepare($sthintervention);
$sthintervention->execute();
$userData = $page->Session->get('user');

echo $page->render('dashboard.html.twig', [
    'totalUsers' => $sthuser->fetch(PDO::FETCH_ASSOC)['total'],
    'totalMail' => $sthmail->fetch(PDO::FETCH_ASSOC)['total'],
    'totalIntervention' => $sthintervention->fetch(PDO::FETCH_ASSOC)['total'],
    'msg' => $msg, 'userData' => $userData,'title' => $title
    
]);
