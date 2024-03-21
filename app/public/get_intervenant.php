<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;
$user = $page->Session->get('user');
$title = "Register";
// Récupérer les données de l'utilisateur depuis la base de données
$userData = $page->Session->get('user');
// Récupérer les données depuis la base de données avec une seule requête JOIN

if ($page->Session->asRole('Intervenant')||$page->Session->asRole('Admin')) {
    $sql = "SELECT DISTINCT intervention.Id, statusintervention.Label, commentaire.commentaire, suiviintervention.Labele, Nom, Id_client, Id_intervenant, date, heure, commentaire_client, commentaire_intervenant 
        FROM intervention
        JOIN statusintervention ON intervention.id_statuts = statusintervention.Id
        JOIN suiviintervention ON intervention.id_Suivi = suiviintervention.Id
        JOIN user ON user.Id = intervention.Id_client
        JOIN intervention_intervenant i ON intervention.Id = i.Id_intervention     
        JOIN commentaire ON intervention.Id = commentaire.Id_intervention
        WHERE Id_intervenant = :int
      ";
    
    $stmt = $page->pdo->prepare($sql);
    $stmt->execute([':int' => $user['Id']]);
    $interventions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo $page->render('get_intervenant.html.twig', [
        'msg' => $msg,
        'interventions' => $interventions,'userData' => $userData,'title' => $title
    ]);
} else {
    echo("Vous n'êtes pas un intervenant.");
}
?>
