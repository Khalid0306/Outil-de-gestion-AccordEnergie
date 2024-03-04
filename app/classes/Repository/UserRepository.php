<?php

namespace App\Repository;

class UserRepository
{
    private \PDO $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    //Fonction pour changer le mot de passe
    public function updatePassword(string $table, string $newPassword, string $email): void
    {
        try {
            
            if (empty($table) || empty($newPassword) || empty($email)) {
                throw new \InvalidArgumentException('Invalid ');
            }
    
           
            if (!is_string($newPassword)) {
                throw new \InvalidArgumentException('$newPassword doit etre stringue');
            }
    
        
            $updateQuery = "UPDATE $table SET password = :password WHERE email = :email";
    
            $stmt = $this->pdo->prepare($updateQuery);
    
            $stmt->bindValue(':password', $newPassword);
            $stmt->bindValue(':email', $email);
    
            $stmt->execute();
    
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

// get id commementaire



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
    try {
        $sql = "SELECT * FROM user WHERE `AdresseMail` = :AdresseMail;";
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

}

