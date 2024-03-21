<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;
$userData = $page->Session->get('user');
        $user = $page->Session->get('user');
        $title = "Register";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($page->Session->asRole('Standardiste')||$page->Session->asRole('Admin')) {
        // Récupérer les données de l'utilisateur depuis la base de données

        // var_dump($_GET['id_client']);
        if(isset($_GET['id_client'])) {
            // var_dump($_GET['id_client']);
            $id_client = $_GET['id_client'];

            $sql = "SELECT Role FROM user WHERE Id = :id_client";
            $stmt = $page->pdo->prepare($sql);
            $stmt->execute([
                ":id_client" => $_POST['id_intervenant']
            ]);

            $role = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifie si le rôle est "Intervenant"
            if ($role && $role['Role'] == 'Intervenant') {
                // Insertion de l'intervention
                $sql = "INSERT INTO intervention (id_client, id_standardiste, date, heure,titre) 
                        VALUES (:id_client, :id_standardiste, :date, :heure,:titre)";
                $stmt = $page->pdo->prepare($sql);

                $stmt->execute([
                    ":id_standardiste" => $user['Id'],
                    ":id_client" => $id_client,
                    ":date" => $_POST['dateInput'],
                    ":heure" => $_POST['timeInput'],
                    ":titre" => $_POST['titre']
                ]);

                // Récupération de l'ID de l'intervention nouvellement créée
                $idIntervention = $page->pdo->lastInsertId();

                // Insertion dans la table de liaison intervention_intervenant
                $sql = "INSERT INTO intervention_intervenant (id_intervenant, id_intervention) 
                        VALUES (:id_intervenant, :id_intervention)";
                $stmt = $page->pdo->prepare($sql);
                $stmt->execute([
                    ":id_intervenant" => $_POST['id_intervenant'],
                    ":id_intervention" => $idIntervention
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

                // Mise à jour du statut de l'intervention
                $sqlUpdateIntervention = "UPDATE intervention SET Id_statuts = :statusId WHERE Id = :id";
                $stmtUpdateIntervention = $page->pdo->prepare($sqlUpdateIntervention);
                $stmtUpdateIntervention->execute([
                    ":statusId" => $_POST['statusId'],
                    ":id" => $idIntervention
                ]);

                // Mise à jour du suivi de l'intervention
                $sqlUpdate = "UPDATE intervention SET Id_Suivi = :suiviId WHERE Id = :id";
                $stmtUpdate = $page->pdo->prepare($sqlUpdate);
                $stmtUpdate->execute([
                    ':suiviId' => $_POST['suiviId'],
                    ':id' => $idIntervention
                ]);
                $msg = urldecode("Une intervention a bien été créer !");
                header('Location: /calendrier.php?msg='. $msg);
                exit;

            } else {
                echo "L'utilisateur associé à l'ID fourni n'est pas un intervenant.";
            }
        } else {
            echo "L'ID du client n'a pas été fourni dans la requête GET.";
        }
    } else {
        echo "Le standardiste n'est pas connecté.";
    }
}

echo $page->render('intervention.html.twig', ['title' => $title,'userData' => $userData, 'msg'=> $msg]);
?>
