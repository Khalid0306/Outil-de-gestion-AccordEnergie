<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($page->Session->asRole('Standardiste')) {
        // Récupère l'id de l'utilisateur actuel
        $user = $page->Session->get('user');

        // Récupère le rôle de l'id entré
        $sql = "SELECT Role FROM user WHERE Id = :id_client";
        $stmt = $page->pdo->prepare($sql);
        $stmt->execute([
            ":id_client" => $_POST['id_intervenant']
        ]);

        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifie si le rôle est "Intervenant"
        if ($role && $role['Role'] == 'Intervenant') {
            // Insertion de l'intervention
            $sql = "INSERT INTO intervention (id_client, id_standardiste) 
                    VALUES (:id_client, :id_standardist)";
            $stmt = $page->pdo->prepare($sql);

            $stmt->execute([
                ":id_standardist" => $user['Id'],
                ":id_client" => $_POST['id_client']
            ]);














//----------------------------------------------------------------------------------------------CREATION DE COMME

$idIntervention = $page->pdo->lastInsertId();





//recuperation de l'id de l'intervenant 



$sql = "INSERT INTO intervention_intervenant (id_intervenant, id_intervention) 
VALUES (:id_client, :id_intervention)";
$stmt = $page->pdo->prepare($sql);

$stmt->execute([
":id_intervention" => $idIntervention,
":id_client" => $_POST['id_intervenant']
]);



















// Insertion du commentaire
$sqlComment = "INSERT INTO commentaire (commentaire, id_user, id_intervention) 
    VALUES (:commentaire, :id_user, :id_intervention)";
$stmtComment = $page->pdo->prepare($sqlComment);

$stmtComment->execute([
    ":commentaire" => $_POST['commentaire'],
    ":id_intervention" => $idIntervention,
    ":id_user" => $user['Id']
]);



//------------------------------------------------------------------------------------------CREATION DE STATUT


// Mise à jour de la table intervention
$sqlUpdateIntervention = "UPDATE intervention SET Id_statuts = :statusId WHERE Id_Standardiste = :userId and Id =:id";
$stmtUpdateIntervention = $page->pdo->prepare($sqlUpdateIntervention);

$stmtUpdateIntervention->execute([
    ":statusId" => $_POST['statusId'],
    ":userId"   => $user['Id'],
    ":id"      =>$idIntervention
]);












        /*$sql = "UPDATE intervention i 
        SET i.id_statuts = :statusId
        WHERE   i.id_standardiste = :id";*/

      




//-----------------------------------------------CREATION DE SUIVI


 // Récupère l'ID de l'intervention depuis le formulaire
 $suiviId = $_POST['suiviId'];
 

 
     // Si l'intervention existe, effectue une mise à jour
     $sqlUpdate = "UPDATE intervention SET Id_Suivi = :suiviId WHERE Id = :idIntervention";
     $stmtUpdate = $page->pdo->prepare($sqlUpdate);
     $stmtUpdate->execute([':suiviId' => $suiviId, ':idIntervention' => $idIntervention]);
 

 exit();




















        } else {
            echo "Standardiste non connecté";
        }
    } else {
        echo "<script>alert('Cette Id ne correspond à aucun intervenant');</script>";
    }
}

echo $page->render('intervention.html.twig', []);
?>
