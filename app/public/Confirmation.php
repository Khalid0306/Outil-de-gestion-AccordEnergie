<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

if (isset($_POST['sendReset'])) {
    try {
        $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $newPassword_cfh = password_hash($_POST['password_cfh'], PASSWORD_DEFAULT);

        if (empty($newPassword) || empty($newPassword_cfh)) {
            throw new \InvalidArgumentException('Entrée invalide');
        }

        // Valider l'adresse email
        $email = filter_var($userData['email'], FILTER_VALIDATE_EMAIL);

        if ($email === false) {
            throw new \InvalidArgumentException('Adresse e-mail invalide');
        }

        $userData = $page->Session->get('user');
        
        $today = date("Y-m-d H:i:s"); 

        if ($newPassword == $newPassword_cfh) {
            $updateQuery = "UPDATE users 
                SET password = :password, updated_at = :today
                WHERE email = :email";

            $stmt = $page->pdo->prepare($updateQuery);

            $stmt->bindValue(':password', $newPassword);
            $stmt->bindValue(':today', $today);
            $stmt->bindValue(':email', $email);

            // Début de la transaction
            $page->pdo->beginTransaction();

            $stmt->execute();

            // Fin de la transaction
            $page->pdo->commit();

            if ($stmt->rowCount() > 0) {
                echo "Mot de passe mis à jour avec succès.";
            } else {
                echo "Aucune ligne correspondante trouvée pour l'e-mail donné.";
            }
        }
    } catch (\PDOException $e) {
        // Annuler la transaction en cas d'erreur
        $page->pdo->rollBack();
        die("Erreur lors de la mise à jour du mot de passe: " . $e->getMessage());
    } catch (\InvalidArgumentException $e) {
        die("Erreur: " . $e->getMessage());
    }
}

echo $page->render('pass_forgot.html.twig', []);
