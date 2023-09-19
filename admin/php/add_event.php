<?php
include '../../php/connect.php';

// Generate new event id
function uniq_id($pdo) {
    $uniq_id = hexdec(uniqid());

    $query = $pdo->prepare("SELECT `Event_id` FROM `evenementen` WHERE `Event_id` = :uniq_id");

    $query->bindParam(":uniq_id", $uniq_id);
    $query->execute();

    $result = $query->fetchAll();

    if ($result != NULL) {
        return uniq_id($pdo);
    } else {
        return $uniq_id;
    }
}

if (isset($_POST['add_event'])) {
    try {
        // Get event data
        $event_id = uniq_id($pdo);
        $name = $_POST['event_name'];
        $price = $_POST['price'];
        $date = $_POST['date'];
        $start_time = $_POST['start_time'];

        // Get band data
        $band_id = array();
        $sets = array();
        $start_timeb = array();
        $end_timeb = array();
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'band_id_') === 0) {
                array_push($band_id, $value);
            } else if (strpos($key, 'sets_') === 0) {
                array_push($sets, $value);
            } else if (strpos($key, 'start_time_') === 0) {
                array_push($start_timeb, $value);
            } else if (strpos($key, 'end_time_') === 0) {
                array_push($end_timeb, $value);
            }
        }

        if (count($band_id) == 0) {
            setcookie('err', 'You need to add bands to hold an event', time() + 3, '/');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Create event
        $stmt = $pdo->prepare('INSERT INTO `evenementen` (`Event_id`, `Datum`, `Starttijd`, `Entreegeld`) VALUES (:id, :date, :start_time, :price)');
        $stmt->bindParam(':id', $event_id);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':start_time', $start_time);
        $stmt->bindParam(':price', $price);
        $stmt->execute();

        $stmt->closeCursor();
        unset($stmt);

        // Add performances to the event
        foreach ($band_id as $i=>$id) {
            $stmt = $pdo->prepare('INSERT INTO `optredens` (`Optreden_id`, `Event_id`, `Band_id`, `Sets`, `Starttijd`, `Eindtijd`) VALUES (:op_id, :ev_id, :ba_id, :sets, :start_time, :end_time)');
            $stmt->bindParam(':op_id', uniq_id($pdo));
            $stmt->bindParam(':ev_id', $event_id);
            $stmt->bindParam(':ba_id', $id);
            $stmt->bindParam(':sets', $sets[$i]);
            $stmt->bindParam(':start_time', $start_timeb[$i]);
            $stmt->bindParam(':end_time', $end_timeb[$i]);
            $stmt->execute();

            $stmt->closeCursor();
            unset($stmt);
        }

        setcookie('succ', 'Successfully added event', time() + 3, '/');
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage();

        setcookie('err', 'Failed to add event', time() + 3, '/');
    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>