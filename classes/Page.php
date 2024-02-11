<?php

namespace App;

class Page
{
    private \Twig\Environment $twig;
    private $link;
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
            $this->link = new \PDO('mysql:host=mysql; dbname=projet', "root", "");
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            die();
        }
    }

    public function insert(string $table_name, array $data)
    {
        $sql = 'INSERT INTO ' . $table_name . ' (email, password) VALUES (:email, :password)';
        $sth = $this->link->prepare($sql, [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);
        $sth->execute($data);
    }

    

    public function getUserByEmail(array $data)
    {
        // Utilisation de la propriété $link plutôt que d'appeler la fonction connect()
        $sql = "SELECT * FROM users WHERE `email` = :email;";
        $sth = $this->link->prepare($sql,[\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]);

        if (!$sth) {
            die("Erreur lors de la préparation de la requête : " . $this->link->errorInfo()[2]);
        }

        $sth->execute($data);

        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

    public function render(string $name, array $data): string
    {
        return $this->twig->render($name, $data);
    }
}
