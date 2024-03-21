<?php
require_once '../vendor/autoload.php';
use App\Page;

$page = new Page();

if (!isset($_SESSION['user'])){
    header('Location: index.php');
    exit(); // Assurez-vous de quitter le script après une redirection
}

$msg = false;

// Récupérer les données de l'utilisateur depuis la base de données
$userData = $page->Session->get('user');
$userData = $page->Session->get('user');
$title = "Register";

if (isset($_POST['upload'])) {
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "templates/image/" . $filename;

    // Vérifier si le fichier a été téléchargé avec succès
    if (move_uploaded_file($tempname, $folder)) {
        // Mettre à jour la photo de profil de l'utilisateur dans la base de données
        $sql = "UPDATE `user` SET `PhotoUrl` = :filename WHERE `Id` = :userId";
        $stmt = $page->pdo->prepare($sql);
        $stmt->execute([
            ':filename' => $filename,
            ':userId' => $userData['Id'] // Utilisez la bonne clé pour récupérer l'ID de l'utilisateur
        ]);
        
        // Afficher un message de réussite
        $msg = "Image uploaded successfully!";
    } else {
        // Afficher un message d'erreur
        $msg = "Failed to upload image!";
    }
}

// Afficher le formulaire et les informations de l'utilisateur
echo $page->render('profil.html.twig', ['msg' => $msg, 'userData' => $userData,'title' => $title]);
?>
<style>
    
</style>