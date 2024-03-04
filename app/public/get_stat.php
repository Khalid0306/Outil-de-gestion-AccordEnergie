<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

// Récupérer les données depuis la base de données avec une seule requête JOIN
$sql = "SELECT intervention.Id, statusintervention.Label,commentaire.commentaire,suiviintervention.Labele ,Nom ,Id_client 
        FROM intervention
        JOIN statusintervention ON intervention.id_statuts = statusintervention.Id
        JOIN suiviintervention ON intervention.id_Suivi = suiviintervention.Id
        JOIN user ON  user.Id = intervention.Id_client
        
        JOIN commentaire ON intervention.Id = commentaire.Id_intervention";
$stmt = $page->pdo->prepare($sql);
$stmt->execute();
$interventions = $stmt->fetchAll(PDO::FETCH_ASSOC);





echo $page->render('get_stat.html.twig', [
    'msg' => $msg,
    'interventions' => $interventions,
  

]);
?>
