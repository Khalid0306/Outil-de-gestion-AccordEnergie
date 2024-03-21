<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

if ($page->Session->asRole('Standardiste') || $page->Session->asRole('Admin')) {
    // Récupère l'id de l'utilisateur actuel

    $user = $page->Session->get('user');
    // Récupérer les données de l'utilisateur depuis la base de données
$userData = $page->Session->get('user');
$title = "Register";

    if (isset($_GET['intervention_id'], $_GET['intervenant_id'])) {
        $interventionId = $_GET['intervention_id'];
        $intervenantId = $_GET['intervenant_id'];
    } else {
        echo "ID manquant";
        exit();
    }

    // Vérifie d'abord si une entrée avec ces valeurs existe déjà
    $sqlCheck = "SELECT COUNT(*) FROM intervention_intervenant 
                 WHERE id_intervention = :intervention_id AND id_intervenant = :intervenant_id";
    $stmtCheck = $page->pdo->prepare($sqlCheck);
    $stmtCheck->execute([
        ":intervention_id" => $interventionId,
        ":intervenant_id" => $intervenantId
    ]);
    $count = $stmtCheck->fetchColumn();

    if ($count > 0) {
        // Si une entrée existe déjà, mettez à jour les valeurs
        $sql = "UPDATE intervention_intervenant 
                SET id_intervenant = :id_intervenant 
                WHERE id_intervention = :id_intervention AND id_intervenant = :id_intervenant";
        $stmt = $page->pdo->prepare($sql);
        $stmt->execute([
            ":id_intervention" => $interventionId,
            ":id_intervenant" => $intervenantId
        ]);
        $msg = urldecode("Déjà mise à jour");
    } else {
        // Si aucune entrée n'existe, insérez une nouvelle ligne
        $sql = "INSERT INTO intervention_intervenant (id_intervention, id_intervenant) 
                VALUES (:id_intervention, :id_intervenant)";
        $stmt = $page->pdo->prepare($sql);
        $stmt->execute([
            ":id_intervention" => $interventionId,
            ":id_intervenant" => $intervenantId
        ]);
    }

    $msg = urldecode("Ajout réussi!");
    header('Location: /calendrier.php?msg='. $msg);
    exit;

} else {
    echo "Standardiste non connecté";
}
?>
