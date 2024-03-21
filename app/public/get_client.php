<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;


    if ($page->Session->asRole('Standardiste')||$page->Session->asRole('Admin')) {
        $user = $page->Session->get('user');
        $title = "Register";
        // Récupérer les données de l'utilisateur depuis la base de données
$userData = $page->Session->get('user');
        // Vérifier si 'id_intervention' est défini dans $_GET
       


        $sql = "SELECT * FROM user WHERE Role='Client' "; 
                

        $stmt = $page->pdo->prepare($sql);

        $stmt->execute();
        $interventions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Récupérer les résultats de la requête
       

        // Passer les données au template
        echo $page->render('client.html.twig', ['interventions' => $interventions,'title' => $title,'userData' => $userData]);
        exit();
    }


// Si le code arrive ici, cela signifie que les conditions précédentes n'ont pas été remplies
echo "Erreur d'autorisation ou de requête.";
exit();
?>
