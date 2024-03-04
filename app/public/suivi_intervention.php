<?php
require_once '../vendor/autoload.php';
use App\Page;
$msg=false;
$page = new Page();

if (!isset($_SESSION['user'])){
    header('Location: index.php');
}


// Fonction pour obtenir la liste des interventions avec leur suivi
// function getSuiviInterventions($conn) {
//     $sql = "SELECT * FROM suiviintervention";
//     $result = $conn->query($sql);

  
// }
 
$sql = "SELECT * FROM suiviintervention";

// Exécution de la requête
$result = $mysqli->query($sql);

// Vérification des erreurs d'exécution de la requête
if (!$result) {
    die("Erreur lors de l'exécution de la requête : " . $mysqli->error);
}

// Affichage des données
echo "<table border='1'>
        <tr>
            <th>Id</th>
            <th>Id_intervention</th>
            <th>Suivi</th>
            <th>Created_at</th>
            <th>Updated_at</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['Id']}</td>
            <td>{$row['Id_intervention']}</td>
            <td>{$row['Suivi']}</td>
            <td>{$row['Created_at']}</td>
            <td>{$row['Updated_at']}</td>
          </tr>";
}

echo "</table>";

// Fermeture de la connexion
$mysqli->close();


// Afficher la page avec Twig
echo $page->render('suivi_intervention.html.twig', ['msg' => $msg, 'suiviInterventions' => $suiviInterventions]);
?>


