<?php
require_once '../vendor/autoload.php';

use App\Page;
$page = new Page();
class GestionnaireUtilisateur {
    private $page;

    public function __construct() {
        $this->page = new Page();
    }

    public function mettreAJourMotDePasse($email, $nouveauMotDePasse) {
        // Implémentez votre logique de mise à jour du mot de passe ici
        $this->page->update('users', [
            'password' => $nouveauMotDePasse,
        ], 'email = :email', ['email' => $email]);
    }
}

class MiseAJourMotDePasse {
    private $gestionnaireUtilisateur;

    public function __construct() {
        $this->gestionnaireUtilisateur = new GestionnaireUtilisateur();
    }

    public function mettreAJourMotDePasseDepuisFormulaire($donneesFormulaire) {
        // Validez les données du formulaire et extrayez les informations nécessaires
        $email = $_SESSION['user']['email'];
        $nouveauMotDePasse = $donneesFormulaire['password'];

        // Mettez à jour le mot de passe en utilisant le GestionnaireUtilisateur
        $this->gestionnaireUtilisateur->mettreAJourMotDePasse($email, $nouveauMotDePasse);
    }
}

$msg = false;
$miseAJourMotDePasse = new MiseAJourMotDePasse();

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
}

// Vérifie si le formulaire est soumis
if (isset($_POST['sendReset'])) {
    // Met à jour le mot de passe en utilisant la classe MiseAJourMotDePasse
    $miseAJourMotDePasse->mettreAJourMotDePasseDepuisFormulaire($_POST);
}

echo $page->render('pass_forgot.html.twig', []);
?>
