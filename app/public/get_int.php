<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if ($page->Session->asRole('Standardiste')||$page->Session->asRole('Admin')) {
        $user = $page->Session->get('user');
        $title = "Register";
        // Récupérer les données de l'utilisateur depuis la base de données
$userData = $page->Session->get('user');
        // Vérifier si 'id_intervention' est défini dans $_GET
        if (!isset($_GET['id_intervention'])) {
            // Rediriger vers une page d'erreur ou gérer l'absence de 'id_intervention'
            echo "ID d'intervention non spécifié.";
            exit();
        }

        $interventionId = $_GET['id_intervention'];

        $sql = "SELECT * FROM intervention 
                JOIN statusintervention ON intervention.id_statuts = statusintervention.Id
                WHERE intervention.id = :interventionid AND intervention.id_standardiste = :userId";

        $stmt = $page->pdo->prepare($sql);

        $stmt->execute([
            ":interventionid" => $interventionId,
            ":userId" => $user['Id']
        ]);

        // Récupérer les résultats de la requête
        $intervention = $stmt->fetch();

        // Passer les données au template
        echo $page->render('get_stat.html.twig', ['intervention' => $intervention,'title' => $title,'userData' => $userData]);
        exit();
    }
}

// Si le code arrive ici, cela signifie que les conditions précédentes n'ont pas été remplies
echo "Erreur d'autorisation ou de requête.";
exit();
?>
