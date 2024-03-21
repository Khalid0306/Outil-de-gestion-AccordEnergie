<?php

require '../vendor/autoload.php';
require '../classes/Date/Month.php';
require '../classes/Date/Events.php';
require '../public/debug.php';

use Date\Month;
use Date\Events;
use App\Page;


$page = new Page();
$msg = false;
$Date = new Month();
$events = new Events($page->pdo, $page);
$title = 'About Us';

// dd($_GET['Id']);

echo $page->render('aboutUs.html.twig', [
    'title' => $title,
    'msg' => $msg
]);
