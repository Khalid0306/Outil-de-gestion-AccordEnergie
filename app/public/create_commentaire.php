<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;
$title = "Register";

// Récupérer les données de l'utilisateur depuis la base de données
$userData = $page->Session->get('user');
$user = $page->Session->get('user');
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($page->Session->asRole('Client')) {
        // Récupère l'id de l'utilisateur actuel
       

        if (isset($_GET['intervention_id'])) {
            $interventionId = $_GET['intervention_id'];
        } else {
            echo "manque id";
            exit();
        }

        $sql = "UPDATE commentaire 
                SET commentaire_client = :commentaire ,
                Id_user = :id
                WHERE Id_intervention = :id_intervention";
        $stmt = $page->pdo->prepare($sql);

        $stmt->execute([
            ":commentaire" => $_POST['commentaire'],
            ":id_intervention" => $interventionId,
            ":id" => $user['Id']
        ]);

    $msg = urldecode("Ajout réussi!");
    header('Location: /calendrier.php?msg='. $msg);
    exit;

      
    } else {
        echo ("Client non connecté");
    }
}

echo $page->render('commentaire.html.twig', ['userData' => $userData,'title' => $title
]);
?>
