<?php
require_once '../vendor/autoload.php';
use App\Page;
$msg=false;
$page = new Page();

if (!isset($_SESSION['user'])){
    header('Location: index.php');
}
if ($userData) {
    echo $page->render('profil.html.twig', ['msg' => $msg, 'userData' => $userData]);
    exit();    
}
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Fonction pour obtenir la liste des interventions avec leur suivi
function getSuiviInterventions($conn) {
    $sql = "SELECT * FROM suiviintervention";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Retourner les données sous forme de tableau associatif
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return array(); // Aucune intervention trouvée
    }
}

// Exemple d'utilisation de la fonction pour obtenir la liste des interventions avec leur suivi
$suiviInterventions = getSuiviInterventions($conn);

// Fermer la connexion à la base de données
$conn->close();


// Afficher la page avec Twig
echo $page->render('suivi_intervention.html.twig', ['msg' => $msg, 'suiviInterventions' => $suiviInterventions]);


