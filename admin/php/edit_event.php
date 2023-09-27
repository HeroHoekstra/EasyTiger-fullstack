<?php
include "../../php/connect.php";

function uniq_id($pdo) {
    $uniq_id = hexdec(uniqid());

    $query = $pdo->prepare("SELECT `Optreden_id` FROM `optredens` WHERE `Optreden_id` = :uniq_id");

    $query->bindParam(":uniq_id", $uniq_id);
    $query->execute();

    $result = $query->fetchAll();

    if ($result != NULL) {
        return uniq_id($pdo);
    } else {
        return $uniq_id;
    }
}


if (isset($_POST['edit_event'])) {
    try {
        // Get all the data
        $id = $_POST['event_id'];
        $name = $_POST['event_name'];
        $price = $_POST['price'];
        $date = $_POST['date'];
        $start_time = $_POST['start_time'];

        // Get all the band data
        $performance_id = array();
        $band_id = array();
        $band_start_time = array();
        $band_end_time = array();
        $band_sets = array();

        foreach ($_POST as $key=>$value) {
            if (strpos($key, 'band_id_') === 0) {
                array_push($band_id, $value);
            } elseif (strpos($key, 'start_time_') === 0) {
                array_push($band_start_time, $value);
            } elseif (strpos($key, 'end_time_') === 0) {
                array_push($band_end_time, $value);
            } elseif (strpos($key, 'sets_') === 0) {
                array_push($band_sets, $value);
            } elseif (strpos($key, 'performance_id_') === 0) {
                array_push($performance_id, $value);
            }
        }

        // Update the event
        $stmt = $pdo->prepare('UPDATE `evenementen` SET `Naam` = :name, `Datum` = :date, `Starttijd` = :start_time, `Entreegeld` = :price WHERE `Event_id` = :id');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':start_time', $start_time);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Unset query
        $stmt->closeCursor();
        unset($stmt);

        // Update bands
        // Check if anyone has been removed
        $stmt = $pdo->prepare('SELECT `Optreden_id` FROM `optredens` WHERE `Event_id` = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $stmt->closeCursor();
        unset($stmt);

        foreach ($result as $current_id) {
            if (!in_array($current_id, $performance_id)) {
                $stmt = $pdo->prepare('DELETE FROM `optredens` WHERE `Optreden_id` = :per_id');
                $stmt->bindParam(':per_id', $current_id);
                $stmt->execute();

                $stmt->closeCursor();
                unset($stmt);
            }
        }

        unset($result);

        // Do the rest
        foreach ($band_id as $i=>$b_id) {
            // Check for new performances
            $stmt = $pdo->prepare('SELECT `Optreden_id` FROM `optredens` WHERE `Optreden_id` = :id');
            $stmt->bindParam(':id', $performance_id[$i]);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt->closeCursor();
            unset($stmt);

            // There are no records of this performance, so add it
            if (count($result) === 0) {
                $per_id = uniq_id($pdo);

                $stmt = $pdo->prepare('INSERT INTO `optredens` (`Optreden_id`, `Event_id`, `Band_id`, `Sets`, `Starttijd`, `Eindtijd`) VALUES (:per_id, :ev_id, :band_id, :sets, :start_time, :end_time)');
                $stmt->bindParam(':per_id', $per_id);
                $stmt->bindParam(':ev_id', $id);
                $stmt->bindParam(':band_id', $b_id);
                $stmt->bindParam(':sets', $band_sets[$i]);
                $stmt->bindParam(':start_time', $band_start_time[$i]);
                $stmt->bindParam(':end_time', $band_end_time[$i]);
                $stmt->execute();

                $stmt->closeCursor();
                unset($stmt);
            }

            // Finally update the rest
            $stmt = $pdo->prepare('UPDATE `optredens` SET `Sets` = :sets, `Starttijd` = :start_time, `Eindtijd` = :end_time WHERE `Optreden_id` = :id');
            $stmt->bindParam(':sets', $band_sets[$i]);
            $stmt->bindParam(':start_time', $band_start_time[$i]);
            $stmt->bindParam(':end_time', $band_end_time[$i]);
            $stmt->bindParam(':id', $performance_id[$i]);
            $stmt->execute();

            $stmt->closeCursor();
            unset($stmt);
        }

        setcookie('succ', 'Successfully edited event', time() + 3, '/');
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage();

        setcookie('err', 'Failed to update event', time() + 3, '/');
    }
} else if (isset($_POST['delete_event']) && isset($_POST['sure_ev'])) {
    try {
        // Delete performances
        $stmt = $pdo->prepare('DELETE FROM `optredens` WHERE `Event_id` = :id');
        $stmt->bindParam(':id', $_POST['event_id']);
        $stmt->execute();

        $stmt->closeCursor();
        unset($stmt);

        // Delete event
        $stmt = $pdo->prepare('DELETE FROM `evenementen` WHERE `Event_id` = :id');
        $stmt->bindParam(':id', $_POST['event_id']);
        $stmt->execute();

        $stmt->closeCursor();
        unset($stmt);

        setcookie('succ', 'Successfully deleted ' . $_POST['event_name'] . ' from database', time() + 3, '/');
    } catch(Exception $e) {
        echo "Error!: " . $e->getMessage();

        setcookie('err', 'Failed to delete ' . $_POST['event_name'], time() + 3, '/');
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);