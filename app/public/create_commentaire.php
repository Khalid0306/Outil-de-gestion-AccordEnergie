<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($page->Session->asRole('Standardiste')) {
        // Récupère l'id de l'utilisateur actuel
        $user = $page->Session->get('user');

        // Insère dans la table commentaire
        $sql = "INSERT INTO commentaire (commentaire, id_user, id_intervention) 
                VALUES (:commentaire, :id_user, :id_intervention)";
        $stmt = $page->pdo->prepare($sql);

        $stmt->execute([
            ":commentaire" => $_POST['commentaire'],
            ":id_intervention" => $_POST['id_intervention'],
            ":id_user" => $user['Id']
        ]);

        // Requête de récupération de l'id du commentaire
        $selectcom = "SELECT id FROM commentaire WHERE id_intervention = :id_intervention AND id_user = :id_user";
        $stmtint = $page->pdo->prepare($selectcom);

        $stmtint->execute([
            ":id_user" => $user['Id'],
            ":id_intervention" => $_POST['id_intervention']
        ]);

        // Récupération de l'id du commentaire
        $res = $stmtint->fetch(\PDO::FETCH_ASSOC);


        exit();
    } else {
        echo ("Standardiste non connecté");
    }
}

echo $page->render('commentaire.html.twig', []);
?>
