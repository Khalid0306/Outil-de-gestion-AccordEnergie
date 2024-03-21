<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;
$user = $page->Session->get('user');
$title = "Register";
// Récupérer les données de l'utilisateur depuis la base de données
$userData = $page->Session->get('user');
$date=$_GET['date'];
// Récupérer les données depuis la base de données avec une seule requête JOIN
if ($page->Session->asRole('Client')||$page->Session->asRole('Admin')) {
    $sql = "SELECT DISTINCT intervention.Id, statusintervention.Label, commentaire.commentaire_client, suiviintervention.Labele, Id_client, date, heure, Id_intervenant, Nom, commentaire, commentaire_intervenant
        FROM intervention
        JOIN statusintervention ON intervention.id_statuts = statusintervention.Id
        JOIN suiviintervention ON intervention.id_Suivi = suiviintervention.Id
        JOIN user ON  user.Id = intervention.Id_client
        JOIN intervention_intervenant i ON  intervention.Id = i.Id_intervention
        JOIN commentaire ON intervention.Id = commentaire.Id_intervention
        WHERE intervention.Id_client = :id and date=:date
       ";
    
    $stmt = $page->pdo->prepare($sql);
    $stmt->execute([":id" => $user['Id'],
    ":date" => $date


]);
    $interventions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo $page->render('get_bydateclient.html.twig', [
        'msg' => $msg,
        'interventions' => $interventions,
        'title' => $title,
        'userData' => $userData

    ]);
} else {
    echo("Vous n'êtes pas un client.");
}
?>
