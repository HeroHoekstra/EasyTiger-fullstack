<?php
include "../../php/connect.php";

// Just for the add new people
function uniq_id($pdo) {
    $uniq_id = hexdec(uniqid());

    $query = $pdo->prepare("SELECT `Lid_id` FROM `bandleden` WHERE `Lid_id` = :uniq_id");

    $query->bindParam(":uniq_id", $uniq_id);
    $query->execute();

    $result = $query->fetchAll();

    if ($result != NULL) {
        return uniq_id($pdo);
    } else {
        return $uniq_id;
    }
}


if (isset($_POST['edit_band'])) {
    try {
        // Get band info
        $band_id = $_POST['band_id'];
        $band_name = $_POST['band_name'];
        $genre = $_POST['genre'];
        $origin = $_POST['origin'];
        $desc = $_POST['desc'];

        // Get band member
        $bandm_id = array();
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
            } else if (strpos($key, 'band_member_id_') === 0) {
                array_push($bandm_id, $value);
            }
        }

        // Update bands
        $stmt = $pdo->prepare('UPDATE `band` SET `Naam` = :band_name, `Genre` = :genre, `Herkomst` = :origin, `Omschrijving` = :desc WHERE `Band_id` = :id');
        $stmt->bindParam(':band_name', $band_name);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':origin', $origin);
        $stmt->bindParam(':desc', $desc);
        $stmt->bindParam(':id', $band_id);
        $stmt->execute();

        $stmt->closeCursor();
        unset($stmt);

        // Update band members
        // Check if anyone has been removed
        $stmt = $pdo->prepare('SELECT `Lid_id` FROM `bandleden` WHERE Band_id = :id');
        $stmt->bindParam(':id', $band_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $stmt->closeCursor();
        unset($stmt);

        foreach ($result as $lid_id) {
            if (!in_array($lid_id, $bandm_id)) {
                $stmt = $pdo->prepare('DELETE FROM `bandleden` WHERE `Lid_id` = :id');
                $stmt->bindParam(':id', $lid_id);
                $stmt->execute();

                $stmt->closeCursor();
                unset($stmt);
            }
        }
        unset($result);

        // Do the rest
        foreach ($bandm_name as $i=>$name) {
            // Check if there are new members
            $stmt = $pdo->prepare('SELECT `Lid_id` FROM `bandleden` WHERE `Lid_id` = :id');
            $stmt->bindParam(':id', $bandm_id[$i]);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt->closeCursor();
            unset($stmt);

            // If there are no matching records, add the new member
            if (count($result) === 0) {
                $id = uniq_id($pdo);
                $stmt = $pdo->prepare("INSERT INTO `bandleden` (`Lid_id`, `Band_id`, `Naam`, `Email`, `Telefoon`) VALUES (:id, :band_id, :name, :email, :phone)");
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':band_id', $band_id);
                $stmt->bindParam(':name', $bandm_name[$i]);
                $stmt->bindParam(':email', $bandm_email[$i]);
                $stmt->bindParam(':phone', $bandm_phone[$i]);
                $stmt->execute();

                $stmt->closeCursor();
                unset($stmt);
            }

            // Finally update everything that was there before
            $stmt = $pdo->prepare('UPDATE `bandleden` SET `Naam` = :name, `Email` = :email, `Telefoon` = :phone WHERE `Lid_id` = :m_id AND `Band_id` = :b_id');
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $bandm_email[$i]);
            $stmt->bindParam(':phone', $bandm_phone[$i]);
            $stmt->bindParam(':m_id', $bandm_id[$i]);
            $stmt->bindParam(':b_id', $band_id);
            $stmt->execute();
        }
        setcookie('succ', 'Successfully updated band', time() + 3, "/");
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage();

        setcookie('err', 'Failed to update band', time() + 3, "/");
    }
} else if (isset($_POST['delete_band']) && isset($_POST['sure'])) {
    try {
        // Delete band members
        $stmt = $pdo->prepare('DELETE FROM `bandleden` WHERE `Band_id` = :id');
        $stmt->bindParam(':id', $_POST['band_id']);
        $stmt->execute();

        // Delete band
        $stmt = $pdo->prepare('DELETE FROM `band` WHERE `Band_id` = :id');
        $stmt->bindParam(':id', $_POST['band_id']);
        $stmt->execute();

        $stmt->closeCursor();
        unset($stmt);

        setcookie('succ', 'Successfully deleted ' . $_POST['band_name'] . ' from database', time() + 3, '/');
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage();

        setcookie('err', 'Failed to delete ' . $_POST['band_name'], time() + 3, '/');
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>