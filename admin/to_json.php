<?php
// Get data
include "../php/connect.php";

$bands;
$members;

try {
    // Get bands
    $stmt = $pdo->prepare('SELECT * FROM `band`');
    $stmt->execute();
    $bands = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close query
    $stmt->closeCursor();
    unset($stmt);

    // Get band members
    $stmt = $pdo->prepare('SELECT * FROM `bandleden`');
    $stmt->execute();
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error!: " . $e->getMessage();
}

foreach ($bands as $i=>$band) {
    $bands[$i]['members'] = [];
}

foreach ($members as $member) {
    foreach ($bands as $i=>$band) {
        if ($member['Band_id'] == $band['Band_id']) {
            $bands[$i]['members'][count($bands[$i]['members'])] = $member;
        }
    }
}

session_start();
$_SESSION['bands'] = $bands;

$json_data = json_encode($bands);
header("Content-Type: application/json");
echo $json_data;
?>