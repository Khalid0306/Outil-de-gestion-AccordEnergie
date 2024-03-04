<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($page->Session->asRole('Standardiste')) {
        $user = $page->Session->get('user');





//verifer que on modififie uniquement une intervention cle














        // Vérifier si 'id_intervention' est défini dans $_GET
        if (!isset($_POST['id_intervention'])) {
            // Rediriger vers une page d'erreur ou gérer l'absence de 'id_intervention'
            echo "ID d'intervention non spécifié.";
            exit();
        }

        $interventionId = $_POST['id_intervention'];

        $sql = "UPDATE intervention  set 
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
        echo $page->render('get_int.html.twig', ['intervention' => $intervention]);
        exit();
    }
}

// Si le code arrive ici, cela signifie que les conditions précédentes n'ont pas été remplies
echo "Erreur d'autorisation ou de requête.";
exit();
?>
