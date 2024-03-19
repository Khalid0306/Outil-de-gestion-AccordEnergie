<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($page->Session->asRole('Standardiste')) {
        // Récupère l'id de l'utilisateur actuel
        $user = $page->Session->get('user');

        // Récupère l'ID de l'intervention depuis le formulaire
        $suiviId = $_POST['suiviId'];
        $idIntervention = $_POST['id_intervention'];

        // Vérifie si l'intervention avec cet ID existe
        $sqlCheck = "SELECT Id FROM intervention WHERE Id = :idIntervention";
        $stmtCheck = $page->pdo->prepare($sqlCheck);
        $stmtCheck->execute([':idIntervention' => $idIntervention]);
        $existingIntervention = $stmtCheck->fetch(\PDO::FETCH_ASSOC);

        if ($existingIntervention) {
            // Si l'intervention existe, effectue une mise à jour
            $sqlUpdate = "UPDATE intervention SET Id_Suivi = :suiviId WHERE Id = :idIntervention";
            $stmtUpdate = $page->pdo->prepare($sqlUpdate);
            $stmtUpdate->execute([':suiviId' => $suiviId, ':idIntervention' => $idIntervention]);
        } else {
            // Sinon, insère une nouvelle intervention
            $sqlInsert = "INSERT INTO intervention (Id_Suivi, Id_Standardiste) VALUES (:suiviId, :userId)";
            $stmtInsert = $page->pdo->prepare($sqlInsert);
            $stmtInsert->execute([':suiviId' => $suiviId, ':userId' => $user['Id']]);
        }

        exit();
    } else {
        echo ("Standardiste non connecté");
    }
}

// Assurez-vous de définir la variable $suivis avant d'utiliser la méthode render.
$suivis = array(); // Vous devrez définir ce tableau en fonction de votre logique.

echo $page->render('suivi.html.twig', [
    'suivis' => $suivis,
]);
?>
