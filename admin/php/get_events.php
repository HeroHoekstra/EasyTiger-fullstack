<?php
include "../../php/connect.php";

// Get events
$events;
$performances;

try {
    // Get events
    $stmt = $pdo->prepare('SELECT * FROM `evenementen`');
    $stmt->execute();
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->closeCursor();
    unset($stmt);

    // Get performances
    $stmt = $pdo->prepare('SELECT * FROM `optredens`');
    $stmt->execute();
    $performances = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->closeCursor();
    unset($stmt);
} catch (Exception $e) {
    echo "Error!: " . $e->getMessage();
}

// Put perfomances into events
foreach ($events as $i=>$event) {
    $events[$i]['performance'] = [];
}

foreach ($performances as $performance) {
    foreach ($events as $i=>$event) {
        if ($performance['Event_id'] == $event['Event_id']) {
            $events[$i]['performance'][count($events[$i]['performance'])] = $performance;
        }
    }
}

session_start();
$_SESSION['events'] = $events;

$json_data = json_encode($events);
header("Content-Type: application/json");
echo $json_data;
?>