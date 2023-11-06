<?php
include "../../../php/connect.php";

try {
    $data = [
        ':b_id' => $_POST['user_id'],
        ':ev_id' => $_POST['event_id'],
        ':amount' => $_POST['amount']
    ];
    $stmt = $pdo->prepare('INSERT INTO `bezoekers_events` (`Bezoeker_id`, `Event_id`, `Aantal`) VALUES (:b_id, :ev_id, :amount)');
    $stmt->execute($data);
    $stmt->closeCursor();
    unset($stmt);

    setcookie('succ', 'Successfully bought your tickets', time() + 3, '/');
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    setcookie('err', 'Something went wrong, please try again later', time() + 3, '/');
}

header('Location: ../');