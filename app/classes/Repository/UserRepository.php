<?php

namespace App\Repository;

class UserRepository
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Fonction pour changer le mot de passe
    public function updatePassword(string $newPassword, string $newPassword_cfh, string $userMail): void
    {
        $today = date("Y-m-d H:i:s");
        $email = filter_var($userMail, FILTER_VALIDATE_EMAIL);

        if (empty($newPassword) || empty($userMail) || empty($newPassword_cfh)) {
            throw new \InvalidArgumentException('Invalid input');
        }

        if (!is_string($newPassword)) {
            throw new \InvalidArgumentException('$newPassword doit être une chaîne de caractères');
        }

        if ($newPassword !== $newPassword_cfh) {
            throw new \InvalidArgumentException('Veuillez vérifier votre mot de passe.');
        }

        if ($email == false) {
            throw new \InvalidArgumentException('Adresse e-mail invalide');
        }

        $updateQuery = "UPDATE user SET MotDePasse = :password, Updated_at = :today WHERE AdresseMail = :email";

        $stmt = $this->pdo->prepare($updateQuery);

        $stmt->bindValue(':password', password_hash($newPassword, PASSWORD_DEFAULT));
        $stmt->bindValue(':today', $today);
        $stmt->bindValue(':email', $email);

        $this->executeUpdate($stmt);

        header('Location: index.php');
        exit();
    }

    // Fonction pour exécuter une mise à jour avec gestion de la transaction
    private function executeUpdate(\PDOStatement $stmt): void
    {
        $this->pdo->beginTransaction();

        try {
            $stmt->execute();
            $this->pdo->commit();
        } catch (\PDOException $e) {
            $this->pdo->rollBack();
            throw new \RuntimeException('Erreur lors de l\'exécution de la mise à jour: ' . $e->getMessage());
        }
    }

    // Fonction pour gérer les exceptions

    //Fonction pour créer un User
    public function insertUser(string $table_name, array $data): void
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table_name ($columns) VALUES ($placeholders)";
        $sth = $this->pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
    }


    public function getAllstatuts(array $data): array
    {
        try {
            $sql = "SELECT * FROM c WHERE `AdresseMail` = :AdresseMail;";
            $sth = $this->pdo->prepare($sql);

            if (!$sth) {
                throw new \RuntimeException("Error preparing the query: " . $this->pdo->errorInfo()[2]);
            }

            foreach ($data as $key => $value) {
                $sth->bindValue(":$key", $value);
            }

            if (!$sth->execute()) {
                throw new \RuntimeException("Error executing the query: " . $sth->errorInfo()[2]);
            }

            return $sth->fetch(\PDO::FETCH_ASSOC) ?: [];
        } catch (\PDOException $e) {
            throw new \RuntimeException("Error fetching user by email: " . $e->getMessage());
        }
    }

    //Fonction pour récuper l'user par son Email
    public function getUserByEmail(array $data): array
    {
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
    try {
        $sql = "SELECT * FROM user WHERE `AdresseMail` = :email;";
        $sth = $this->pdo->prepare($sql);
=======
        try {
            $sql = "SELECT * FROM user WHERE `AdresseMail` = :AdresseMail;";
            $sth = $this->pdo->prepare($sql);
>>>>>>> Calendar
=======
        try {
            $sql = "SELECT * FROM user WHERE `AdresseMail` = :AdresseMail;";
            $sth = $this->pdo->prepare($sql);
>>>>>>> Calendar
=======
        try {
            $sql = "SELECT * FROM user WHERE `AdresseMail` = :AdresseMail;";
            $sth = $this->pdo->prepare($sql);
>>>>>>> Calendar
=======
        try {
            $sql = "SELECT * FROM user WHERE `AdresseMail` = :AdresseMail;";
            $sth = $this->pdo->prepare($sql);
>>>>>>> Calendar

            if (!$sth) {
                throw new \RuntimeException("Error preparing the query: " . $this->pdo->errorInfo()[2]);
            }

            foreach ($data as $key => $value) {
                $sth->bindValue(":$key", $value);
            }

            if (!$sth->execute()) {
                throw new \RuntimeException("Error executing the query: " . $sth->errorInfo()[2]);
            }

            return $sth->fetch(\PDO::FETCH_ASSOC) ?: [];
        } catch (\PDOException $e) {
            throw new \RuntimeException("Error fetching user by email: " . $e->getMessage());
        }
    }

    public function getUsersByRole()
    {
        $sql = "SELECT * FROM user WHERE Role = 'Client'";
        $sth = $this->pdo->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }
}
