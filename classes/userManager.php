<?php
namespace App;

class User {
    private $page;

    public function __construct($page) {
        $this->page = $page;
    }

    public function updatePassword($email, $newPassword) {
        // Vous devrez peut-être ajouter une validation supplémentaire du mot de passe ici
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Met à jour le mot de passe dans la base de données
        $this->page->update('users', [
            'password' => $hashedPassword,
        ], 'email = :email', ['email' => $email]);
    }
}
?>
