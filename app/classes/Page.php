<?php

namespace App;

use App\Repository\UserRepository;

class Page
{
    private \Twig\Environment $twig;
    public \PDO $pdo;
    public $Session;
    private UserRepository $userRepository;

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


    public function render(string $name, array $data): string
    {
        return $this->twig->render($name, $data);
    }
}
