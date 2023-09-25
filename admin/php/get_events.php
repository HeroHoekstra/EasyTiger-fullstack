<?php
include "../../php/connect.php";

// Get events
$events;
$performances;
$_bands = [];

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

    // Get band name
    $band_ids = implode(',', array_column($performances, 'Band_id'));
    $stmt = $pdo->prepare('SELECT `Band_id`, `Naam` FROM band WHERE `Band_id` IN (' . $band_ids . ')');
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Create a sub-array for each band
        $bandInfo = [
            'Band_id' => $row['Band_id'],
            'Naam' => $row['Naam'],
        ];

        $_bands[] = $bandInfo;
    }

    $stmt->closeCursor();
    unset($stmt);
} catch (Exception $e) {
    echo "Error!: " . $e->getMessage();
}

// Put band_name into performance
foreach ($performances as $i => $per) {
    $performances[$i]['band_name'] = [];
}

foreach ($performances as $i => $per) {
    foreach ($_bands as $band) {
        if ($band['Band_id'] == $per['Band_id']) {
            $performances[$i]['band_name'] = $band['Naam'];
        }
    }
}

// Put performances into events
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
