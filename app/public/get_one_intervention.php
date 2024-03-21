<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;










$user = $page->Session->get('user');
$title = "Register";
// Récupérer les données de l'utilisateur depuis la base de données
$userData = $page->Session->get('user');

$id=$_GET['Id'];
// Récupérer le paramètre de requête sort
$sort = $_GET['sort'] ?? 'asc'; // Par défaut, tri par ordre croissant
if ($page->Session->asRole('Standardiste')|| $page->Session->asRole('Admin')) {
// Ajouter la clause ORDER BY à votre requête SQL en fonction du paramètre de tri
$sql = "SELECT intervention.Id, statusintervention.Label, commentaire.commentaire, suiviintervention.Labele, Nom, Id_client, Id_intervenant, date, heure, Id_Standardiste,titre 
        FROM intervention
        JOIN statusintervention ON intervention.id_statuts = statusintervention.Id
        JOIN suiviintervention ON intervention.id_Suivi = suiviintervention.Id
        JOIN user ON  user.Id = intervention.Id_client
        JOIN intervention_intervenant i ON  intervention.Id = i.Id_intervention
        JOIN commentaire ON intervention.Id = commentaire.Id_intervention
        WHERE intervention.Id=:id ORDER BY intervention.Id $sort  "; // Colonne de tri et ordre (asc ou desc)

$stmt = $page->pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$interventions = $stmt->fetchAll(PDO::FETCH_ASSOC);







echo $page->render('get_one_admin.html.twig', [
    'msg' => $msg,
    'interventions' => $interventions,
  
    'user' => $user, 
    'userData' => $userData,
    'title' => $title// Passer la variable $user au modèle Twig
]);


}else{

    echo("vous pas standardiste");
}
?>
