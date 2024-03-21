<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();


$msg = false;
$userData = $page->Session->get('user');
$title = "Register";
if ($_SERVER["REQUEST_METHOD"] === "POST") {


    // Vérification de l'existence de 'user_Id' dans $_GET
    if (isset($_GET['user_id'])) {
        $Id = $_GET['user_id'];

        
    } else {
        echo "manque user_Id";
        exit();
    }
     
    // Vérification de l'existence de 'newRole' dans $_POST
    if (!isset($_POST['newRole'])) {
        echo "manque newRole";
        exit();
    }
     
    // Récupération de la valeur 'newRole' depuis $_POST
    $newRole = $_POST['newRole'];
    
    // Mise à jour du rôle dans la table user
    $sqlUpdaterole = "UPDATE user SET Role=:role WHERE Id = :id";

    // Utilisation d'une requête préparée pour éviter les problèmes de sécurité
    $stmtUpdaterole = $page->pdo->prepare($sqlUpdaterole);

    $stmtUpdaterole->execute([
        ":id" => $Id,
        ":role" => $newRole
    ]);
  
    // Redirection vers viewuser.php après la mise à jour du rôle
    // header("Location: viewuser.html.twig");
    // exit();
}

echo $page->render('modif.html.twig', ['msg' => $msg,'userData' => $userData,'title' => $title]);

?>
