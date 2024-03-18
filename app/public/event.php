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
$events= new Events($page->pdo);
$intervention_data = $events->getEventsById($_GET['Id'] ?? null);
$eventName = null; 

if (!isset($_GET['Id']) || $intervention_data === null) {
    header('location: 404.php');
 } 

foreach ($intervention_data as $key => $data) {
    $eventName = $data['titre'];
    break; 
}

$title = 'Event'.' '.$eventName;

// dd($_GET['Id']);

echo $page->render('event.html.twig', [
    'title' => $title,
    'eventName' => $eventName
]);