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
$events= new Events($page->pdo, $page);
$intervention_data = $events->getEventsById($_GET['Id'] ?? null);
$standardisteId = [];
foreach ($intervention_data as $key => $data) {
    $eventName = $data['titre'];
    $standardisteId = $data['Id_Standardiste'];
    break; 
}
$userData = $page->Session->get('user');
$userId = $userData['Id'];
// var_dump($userId, $standardisteId);die();

$eventName = null;

    if ($userId !== $standardisteId) {
        $msg = urlencode("Vous ne pouvez pas intéragir avec cette intervention");
        header('Location: /calendrier.php?msg=' . $msg);
        exit;
    } else {
        foreach ($intervention_data as $key => $data) {
            $eventName = $data['titre'];
            break; 
        }
        
        $title = 'Event'.' '.$eventName;
        
        // dd($_GET['Id']);
        
        echo $page->render('event.html.twig', [
            'title' => $title,
            'userData' => $userData,
            'eventName' => $eventName,
            'msg'=> $msg
        ]);
    }

   


