<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($page->Session->asRole('Standardiste')) {
        // Récupère l'id de l'utilisateur actuel
        $user = $page->Session->get('user');

        // Insère dans la table intervention
        $sql = "INSERT INTO intervention (Id_statuts, Id_Standardiste ) 
                VALUES (:statusId, :userId )";
        $stmt = $page->pdo->prepare($sql);

        $stmt->execute([
            "statusId"      => $_POST['statusId'],
            "userId"        => $user['Id']
        ]);

        // Additional logic can be added here if needed

        // The following line exits the script, which might not be necessary
        exit();
    } else {
        echo "Standardiste non connecté";
    }
}


// $intervenants = $page->getAllIntervenants();


echo $page->render('staetut.html.twig', []);

