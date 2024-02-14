<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$msg = false;

        if (isset($_POST['sendReset'])) {
            $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $newPassword_cfh=password_hash($_POST['password_cfh'], PASSWORD_DEFAULT);

            if (isset($_SESSION['user'])) {
                // Récupérer les données de l'utilisateur depuis la base de données
                $userData = $page->Session->get('user');
            }

            $email = $userData['email'];
            var_dump($email);

            try {
                if (empty($newPassword) || empty($email)) {
                    throw new \InvalidArgumentException('Invalid input');
                }

                if (!is_string($newPassword)) {
                    throw new \InvalidArgumentException('$newPassword doit être une chaîne de caractères');
                }
                
                var_dump($newPassword);

              

                $today = date("Y-m-d H:i:s"); 
                if($newPassword== $newPassword_cfh){
                $updateQuery = "UPDATE users 
                SET password = :password, updated_at = :today
                WHERE email = :email";

                $stmt = $page->pdo->prepare($updateQuery);

                $stmt->bindValue(':password', $newPassword);
                $stmt->bindValue(':today', $today);
                $stmt->bindValue(':email', $email);

                $stmt->execute();
                }
                if ($stmt->rowCount() > 0) {
                    echo "Password updated successfully.";
                } else {
                    echo "No matching rows found for the given email.";
                }
            } catch (\PDOException $e) {
                die("Error updating password: " . $e->getMessage());
            } catch (\InvalidArgumentException $e) {
                die("Error: " . $e->getMessage());
            }


       


        



        }


echo $page->render('pass_forgot.html.twig', []);
?>
