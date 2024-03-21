<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $idIntervention = $_POST['idIntervention'];
    $newStatut = $_POST['newStatut'];
    $newSuivi = $_POST['newSuivi'];
    $newCommentaire = $_POST['newCommentaire'];

    // Mise à jour du statut dans la table intervention
    $sqlUpdateStatut = "UPDATE intervention SET id_statuts = :newStatut WHERE Id = :idIntervention";
    $stmtUpdateStatut = $page->pdo->prepare($sqlUpdateStatut);
    $stmtUpdateStatut->execute([':newStatut' => $newStatut, ':idIntervention' => $idIntervention]);

    // Mise à jour du suivi dans la table intervention
    $sqlUpdateSuivi = "UPDATE intervention SET id_Suivi = :newSuivi WHERE Id = :idIntervention";
    $stmtUpdateSuivi = $page->pdo->prepare($sqlUpdateSuivi);
    $stmtUpdateSuivi->execute([':newSuivi' => $newSuivi, ':idIntervention' => $idIntervention]);

    // Mise à jour du commentaire dans la table commentaire
    $sqlUpdateCommentaire = "UPDATE commentaire SET commentaire = :newCommentaire WHERE Id_intervention = :idIntervention";
    $stmtUpdateCommentaire = $page->pdo->prepare($sqlUpdateCommentaire);
    $stmtUpdateCommentaire->execute([':newCommentaire' => $newCommentaire, ':idIntervention' => $idIntervention]);

    $msg = "Intervention mise à jour avec succès!";
}

// Rediriger vers la page principale

exit();
?>
