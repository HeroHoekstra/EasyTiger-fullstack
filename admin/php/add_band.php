<?php
include '../../php/connect.php';

function uniq_id($pdo, $needed_id) {
    $uniq_id = hexdec(uniqid());

    if ($needed_id == 'band') {
        $query = $pdo->prepare("SELECT `Band_id` FROM `band` WHERE `Band_id` = :uniq_id");
    } else {
        $query = $pdo->prepare("SELECT `Lid_id` FROM `bandleden` WHERE `Lid_id` = :uniq_id");
    }

    $query->bindParam(":uniq_id", $uniq_id);
    $query->execute();

    $result = $query->fetchAll();

    if ($result != NULL) {
        return uniq_id($pdo, $needed_id);
    } else {
        return $uniq_id;
    }
}


if (isset($_POST['add_band'])) {
    // Get band info
    $band_id = uniq_id($pdo, 'band');
    $band_name = $_POST['band_name'];
    $genre = $_POST['genre'];
    $origin = $_POST['origin'];
    $desc = $_POST['desc'];

    // Get band member info
    $bandm_name = array();
    $bandm_email = array();
    $bandm_phone = array();
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'band_name_') === 0) {
            array_push($bandm_name, $value);
        } else if (strpos($key, 'band_email_') === 0) {
            array_push($bandm_email, $value);
        } else if (strpos($key, 'band_phone_') === 0) {
            array_push($bandm_phone, $value);
        }
    }

    $bandm_id = array();
    foreach ($bandm_name as $member => $index) {
        array_push($bandm_id, uniq_id($pdo, 'member'));
    }

    try {
        // Fill in band info
        // Insert data
        $stmt = $pdo->prepare("INSERT INTO `band` (`Band_id`, `Naam`, `Genre`, `Herkomst`, `Omschrijving`) VALUES (:id, :name, :genre, :origin, :desc)");
        $stmt->bindParam(':id', $band_id);
        $stmt->bindParam(':name', $band_name);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':origin', $origin);
        $stmt->bindParam(':desc', $desc);
        $stmt->execute();

        // Close query
        $stmt->closeCursor();
        unset($stmt);

        // Fill in band member info
        // Insert data
        foreach ($bandm_id as $i => $member) {
            $stmt = $pdo->prepare("INSERT INTO `bandleden` (`Lid_id`, `Band_id`, `Naam`, `Email`, `Telefoon`) VALUES (:id, :band_id, :name, :email, :phone)");
            $stmt->bindParam(':id', $bandm_id[$i]);
            $stmt->bindParam(':band_id', $band_id);
            $stmt->bindParam(':name', $bandm_name[$i]);
            $stmt->bindParam(':email', $bandm_email[$i]);
            $stmt->bindParam(':phone', $bandm_phone[$i]);
            $stmt->execute();

            // Close query
            $stmt->closeCursor();
            unset($stmt);
        }

        // For some reason the query that adds members also adds one empty member
        // This will remove that empty member
        $stmt = $pdo->prepare("DELETE FROM `bandleden` WHERE `Naam` IS NULL");
        // And of course close the query :)
        $stmt->execute();
        $stmt->closeCursor();
        unset($stmt);

        setcookie('succ', 'Successfully added band', time() + 3, "/");
    } catch (Exception $e) {
        echo "Error!: <br>" . $e->getMessage();

        setcookie('err', 'Failed adding band', time() + 3, "/");
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>