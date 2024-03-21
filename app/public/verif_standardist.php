<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($page->Session->asRole('standardiste')) { 
        // Récupère l'id du standardiste
        //$queryStand = "SELECT id FROM USER WHERE id=:id";
        //$stmtStand = $page->pdo->prepare($queryStand);

        // Redirige vers create_int.php
        header('Location: create_int.php');
        exit();  // N'oubliez pas d'ajouter cette ligne pour arrêter l'exécution du script après la redirection
    }
}

echo $page->render('connect_standard.html.twig', []);
?>