<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$data = []; // Define an empty array or provide the necessary data

echo $page->render('dash.html.twig', $data);
?>
