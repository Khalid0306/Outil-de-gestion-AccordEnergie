<?php

namespace App;

class Page
{
    private \Twig\Environment $twig;
    public \PDO $pdo;
    public $Session;

    public function __construct()
    {
        $this->Session = new Session();
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => '../var/cache/compilation_cache',
            'debug' => true
        ]);

        try {
            $dsn = 'mysql:host=mysql;dbname=projet';
            $username = 'root';
            $password = '';

            $this->pdo = new \PDO($dsn, $username, $password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            die("Error connecting to the database");
        }
    }
    public function update($table, $newPassword, $email)
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
    

    public function insert(string $table_name, array $data)
    {
        $sql = 'INSERT INTO ' . $table_name . ' (email, password) VALUES (:email, :password)';
        $sth = $this->pdo->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->execute($data);
    }

    public function getUserByEmail(array $data)
    {
        // Utilisation de la propriété $pdo plutôt que d'appeler la fonction connect()
        $sql = "SELECT * FROM users WHERE `email` = :email;";
        $sth = $this->pdo->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);

        if (!$sth) {
            die("Error preparing the query: " . $this->pdo->errorInfo()[2]);
        }

        $sth->execute($data);

        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

    public function render(string $name, array $data): string
    {
        return $this->twig->render($name, $data);
    }
}
