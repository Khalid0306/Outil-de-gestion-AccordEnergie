<?php

    require_once '../vendor/autoload.php';

    use App\Page;

    $page = new Page();

    $page->Session->destroy();

    header('Location : index.php?msg=Vous avez été déconnecté');

