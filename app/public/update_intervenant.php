<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;
$title = "Register";
// Récupérer les données de l'utilisateur depuis la base de données
$userData = $page->Session->get('user');
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($page->Session->asRole('Standardiste')||$page->Session->asRole('Admin')) {
        
        if (!isset($_GET['intervention_id']) || !isset($_GET['standardiste_id'])) {
            echo "manque id";
            exit();
        }
        
        $interventionId = $_GET['intervention_id'];
        $standardisteId = $_GET['standardiste_id'];

        // Vérification des clés dans $_POST
        if (!isset($_POST['statusId']) || !isset($_POST['suiviId'])) {
            echo "données manquantes.";
            exit();
        }

        $statusId = $_POST['statusId'];
        $suiviId = $_POST['suiviId'];

        $user = $page->Session->get('user');
      
            // Mise à jour de l'intervention
            $sqlUpdateIntervention = "UPDATE intervention 
                                SET Id_statuts = :statusId, date = :dateInput, heure = :timeInput
                                WHERE Id = :id";
            $stmtUpdateIntervention = $page->pdo->prepare($sqlUpdateIntervention);

            $stmtUpdateIntervention->execute([
                ":statusId" => $statusId,
                ":id" => $interventionId,
                ":dateInput" => $_POST['dateInput'],
                ":timeInput" => $_POST['timeInput'],
            ]);

            // Mise à jour du suivi de l'intervention
            $sqlUpdateSuivi = "UPDATE intervention 
                          SET Id_Suivi = :suiviId 
                          WHERE Id = :idIntervention";
            $stmtUpdateSuivi = $page->pdo->prepare($sqlUpdateSuivi);

            $stmtUpdateSuivi->execute([':suiviId' => $suiviId, ':idIntervention' => $interventionId]);

            if (!empty($_POST['commentaire'])) {
                // Récupération de l'intervention de l'intervenant
                $sql = "SELECT intervention.Id 
                    FROM intervention
                    JOIN intervention_intervenant i ON intervention.Id = i.Id_intervention
                    WHERE Id_intervenant = :int";
                $stmt = $page->pdo->prepare($sql);
                $stmt->execute([':int' => $user['Id']]);
                $intervention = $stmt->fetch(PDO::FETCH_ASSOC);

              
            }


            
        $sql = "UPDATE  commentaire SET commentaire=:commentaire WHERE Id_intervention=:id_intervention ";
       
        $stmt = $page->pdo->prepare($sql);
        
        $stmt->execute([
            ":commentaire" => $_POST['commentaire'],
            ":id_intervention" =>$interventionId 
           
        ]);
        $msg = "Ajout réussi";

        header('Location: ' . $_SERVER['HTTP_REFERER'] . '?msg=' . $msg); // Pour renvoyer à la page précédente
        exit;
       

     
   
    } else {
        $msg = "Standardiste non connecté";
    }
}

echo $page->render('modif_intervenant.html.twig', ['msg' => $msg,'userData' => $userData,'title' => $title]);
?>
