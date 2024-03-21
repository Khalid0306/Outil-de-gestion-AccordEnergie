<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($page->Session->asRole('Standardiste')||$page->Session->asRole('Admin')) {
        // Récupère l'id de l'utilisateur actuel
// Récupérer les données de l'utilisateur depuis la base de données
// Récupérer les données de l'utilisateur depuis la base de données
$title = "Register";
$userData = $page->Session->get('user');
        $user = $page->Session->get('user');

        if (isset($_GET['intervention_id'])) {
            $interventionId = $_GET['intervention_id'];
        } else {
            echo "manque id";
            exit();
        }




        // Insère dans la table commentaire
        $sql = "INSERT INTO commentaire (commentaire, id_user, id_intervention) 
                VALUES (:commentaire, :id_user, :id_intervention)";
        $stmt = $page->pdo->prepare($sql);

        $stmt->execute([
            ":commentaire" => $_POST['commentaire'],
            ":id_intervention" => $interventionId,
            ":id_user" => $user['Id']
        ]);

    


        exit();
    } else {
        echo ("Standardiste non connecté");
    }
}

echo $page->render('commentaire.html.twig', ['userData' => $userData,'title' => $title]);
?>
