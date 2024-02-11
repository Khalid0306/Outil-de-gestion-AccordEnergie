<?php
namespace App;

class Password {
    private $userManager;

    public function __construct($userManager) {
        $this->userManager = $userManager;
    }

    public function updatePasswordFromForm($formData, $userEmail) {
        // Validez les données du formulaire
        if (isset($formData['password']) && !empty($formData['password'])) {
            // Met à jour le mot de passe en utilisant le UserManager
            $this->userManager->updatePassword($userEmail, $formData['password']);
            // Ajoutez ici un message de réussite si nécessaire
        } else {
            // Ajoutez ici un message d'erreur si le champ de mot de passe est vide
        }
    }
}
?>
