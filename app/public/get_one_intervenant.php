<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

$user = $page->Session->get('user');
$title = "Register";
$userData = $page->Session->get('user');

$id_intervenant = $_GET['Id_intervenant'];
$id = $_GET['Id']; // Assurez-vous que vous récupérez correctement la valeur de 'id' depuis la requête GET.

$sort = $_GET['sort'] ?? 'asc'; // Par défaut, tri par ordre croissant
if ($page->Session->asRole('Intervenant') || $page->Session->asRole('Admin')) {
    // Ajouter la clause ORDER BY à votre requête SQL en fonction du paramètre de tri
    $sql = "SELECT intervention.Id, statusintervention.Label, commentaire_client, Commentaire, commentaire_intervenant, suiviintervention.Labele, Nom, Id_client, Id_intervenant, date, heure, Id_Standardiste, titre 
            FROM intervention
            JOIN statusintervention ON intervention.id_statuts = statusintervention.Id
            JOIN suiviintervention ON intervention.id_Suivi = suiviintervention.Id
            JOIN user ON user.Id = intervention.Id_client
            JOIN intervention_intervenant i ON intervention.Id = i.Id_intervention
            JOIN commentaire ON intervention.Id = commentaire.Id_intervention
            WHERE intervention.Id = :id  ";

    $stmt = $page->pdo->prepare($sql);
    // Assurez-vous de lier correctement les paramètres dans la requête préparée
    $stmt->execute([':id' => $id]); // Supprimez l'espace après 'intervenant_id'

    $interventions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo $page->render('get_intervenant.html.twig', [
        'msg' => $msg,
        'interventions' => $interventions,
        'user' => $user, 
        'userData' => $userData,
        'title' => $title
    ]);
} else {
    echo "Vous n'êtes pas intervenant";
}
?>
