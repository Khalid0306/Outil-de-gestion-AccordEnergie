<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($page->Session->asRole('Standardiste')) {
        // Récupère l'id du standardiste
        //$queryStand = "SELECT id FROM USER WHERE id=:id";
        //$stmtStand = $page->pdo->prepare($queryStand);


        

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











        /*$sql = "UPDATE intervention i 
        SET i.id_statuts = :statusId
        WHERE   i.id_standardiste = :id";*/

        exit();
    } else {
        echo ("Standardiste non connecté");
    }
}

$intervenants = $page->getAllIntervenants();
$suivis = 
$status = 

echo $page->render('staetut.html.twig', [
    'suivis' = $suivis,

]);
?>
