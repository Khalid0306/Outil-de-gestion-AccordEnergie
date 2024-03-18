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
$title = "Calendrier";


// if (!isset($_SESSION['user'])){
//     header('Location: index.php');
// }

try {

    $month = new Month(month: $_GET['month'] ?? null, year: $_GET['year'] ?? null);
    
    $testStart = [];
    $weeks = $month->getWeeks();
    $start = $month->getStartingDay();
    $start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('Last monday');
    $end = (clone $start)->modify('+' . (6 + 7 * ($weeks -1)) . ' days' );
    $eventsByday = $events->getEventsByDay($start, $end);
    $events_result = $events->getEvents($start, $end);
    // var_dump($events_result);

    for ($i = 0; $i < $weeks; $i++) { 
        foreach ($month->days as $key => $day) {
            $modifiedDate = (clone $start)->modify("+" . ($key + $i * 7) . "days");
            $test[$i][] = $modifiedDate->format('d');
        }
    }
    
    $testStart = $test;

} catch (Exception $e) {
    $msg = 'An error occurred: ' . $e->getMessage();
}

echo $page->render('calendrier.html.twig', [
    'msg' => $msg,
    'month' => $month,
    'weeks'=> $weeks,
    'start' => $start,
    'events' => $eventsByday,
    'events_result' => $events_result,
    'testStart' => $testStart,
    'title' => $title

]);

