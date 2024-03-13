<?php
require '../vendor/autoload.php';
require '../classes/Date/Month.php';

use App\Date\Month;
use App\Page;

$page = new Page();
$msg = false;
$Date = new Month();

// if (!isset($_SESSION['user'])){
//     header('Location: index.php');
// }

try {
    $month = new Month(month: $_GET['month'] ?? null, year: $_GET['year'] ?? null);
    
    $testStart = [];

    $start = $month->getStartingDay()->modify('Last monday');

    for ($i = 0; $i < $month->getWeeks(); $i++) { 
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
    'start' => $start,
    'testStart' => $testStart
]);

