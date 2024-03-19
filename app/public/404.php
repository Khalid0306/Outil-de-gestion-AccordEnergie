<?php

require '../vendor/autoload.php';
require '../classes/Date/Month.php';
require '../classes/Date/Events.php';

use Date\Month;
use Date\Events;
use App\Page;

http_response_code(404);

$page = new Page();
$msg = false;
$title = "404 Error";


echo $page->render('404.html.twig', [
    'title' => $title,
]);