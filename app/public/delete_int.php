<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

if(isset($_GET['intervention_id'])) {
    $intervention_id = $_GET['intervention_id'];
    
    // Supprimer d'abord les références dans la table intervention_intervenant
    $sql_delete_references = "DELETE FROM intervention_intervenant WHERE Id_intervention = :intervention_id";
    $stmt_delete_references = $page->pdo->prepare($sql_delete_references);
    $stmt_delete_references->execute([':intervention_id' => $intervention_id]);
    
    // Ensuite, supprimer l'intervention
    $sql_delete_intervention = "DELETE FROM intervention WHERE Id = :intervention_id";
    $stmt_delete_intervention = $page->pdo->prepare($sql_delete_intervention);
    
    if($stmt_delete_intervention->execute([':intervention_id' => $intervention_id])) {
        header("Location: calendrier.php?msg=Intervention supprimée avec succès");
        exit();
    } else {
        echo "Erreur lors de la suppression de l'intervention";
    }
} else {
    echo "ID de l'intervention non spécifié";
}
?>
