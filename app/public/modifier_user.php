<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

$msg = false;
$userData = $page->Session->get('user');
$title = "Register";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_GET['user_id'])) {
        $id = $_GET['user_id'];
     
        
        // Vérifier l'existence de l'utilisateur
        $user = $page->pdo->query("SELECT * FROM user WHERE Id = $id")->fetch();
        if (!$user) {
            echo "L'utilisateur avec l'ID spécifié n'existe pas.";
            exit();
        }

        // Si le formulaire a été soumis, procéder à la mise à jour
        if (isset($_POST['send'])) {
            $nom = $_POST['Nom'];
            $prenom = $_POST['Prenom'];
            $numeroTel = $_POST['NumeroTel'];
            $adresse = $_POST['Adresse'];

            // Préparation et exécution de la requête SQL d'UPDATE
            $sql = "UPDATE user 
                    SET Nom = :nom, Prenom = :prenom, NumeroTel = :numeroTel, Adresse = :adresse 
                    WHERE Id = :id";
            $stmt = $page->pdo->prepare($sql);
            $stmt->execute([
                ':nom' => $nom,
                ':prenom' => $prenom,
                ':numeroTel' => $numeroTel,
                ':adresse' => $adresse,
                ':id' => $id
            ]);

            // Vérification si la mise à jour a réussi
            if ($stmt->rowCount() > 0) {
                $msg = "Les informations de l'utilisateur ont été mises à jour avec succès.";
            } else {
                $msg = "Erreur lors de la mise à jour des informations de l'utilisateur.";
            }
        } else {
            $msg = "Le formulaire n'a pas été soumis correctement.";
        }
    } else {
        echo "Le paramètre 'user_id' est manquant.";
        exit();
    }
}

echo $page->render('modif_user.html.twig', ['msg' => $msg,'userData' => $userData,'title' => $title]);
?>
