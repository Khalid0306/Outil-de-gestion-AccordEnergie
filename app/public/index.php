<?php

    require_once '../vendor/autoload.php';

    use App\Twig;
    
    $twig = new Twig();

    echo $twig->render('index.html.twig', ['name' => 'Fabien']);