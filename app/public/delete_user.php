<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

$msg = false;

if (!isset($_SESSION['user'])){
    header('Location: index.php');
}

// Vérification de l'existence de 'user_Id' dans $_GET
if (isset($_GET['user_id'])) {
    $Id = $_GET['user_id'];
  
} else {
    echo "manque user_Id";
    exit();
}

// Delete related records in the intervention_intervenant table
$sqlDeleteIntervenant = "DELETE FROM intervention_intervenant WHERE Id_intervention IN (SELECT Id FROM intervention WHERE Id_Client = :id)";
$stmtDeleteIntervenant = $page->pdo->prepare($sqlDeleteIntervenant);
$stmtDeleteIntervenant->execute([":id" => $Id]);

// Delete related records in the intervention table
$sqlDeleteInterventions = "DELETE FROM intervention WHERE Id_Client = :id";
$stmtDeleteInterventions = $page->pdo->prepare($sqlDeleteInterventions);
$stmtDeleteInterventions->execute([":id" => $Id]);

// Update the Id_Standardiste column in the intervention table to NULL or another appropriate value
$sqlUpdateIntervention = "UPDATE intervention SET Id_Standardiste = NULL WHERE Id_Standardiste = :id";
$stmtUpdateIntervention = $page->pdo->prepare($sqlUpdateIntervention);
$stmtUpdateIntervention->execute([":id" => $Id]);

// Now you can proceed with deleting the user
$sqlDeleteUser = "DELETE FROM user WHERE Id = :id";
$stmtDeleteUser = $page->pdo->prepare($sqlDeleteUser);
$stmtDeleteUser->execute([":id" => $Id]);

// Terminer le script après la mise à jour du rôle
$msg = urldecode("Opération réussi!");
    header('Location: /calendrier.php?msg='. $msg);
    exit;

?>
