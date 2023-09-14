<?php
include "../../php/connect.php";

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

        // Update band menu
        $stmt = $pdo->prepare('UPDATE `band` SET `Naam` = :band_name, `Genre` = :genre, `Herkomst` = :origin, `Omschrijving` = :desc WHERE `Band_id` = :id');
        $stmt->bindParam(':band_name', $band_name);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':origin', $origin);
        $stmt->bindParam(':desc', $desc);
        $stmt->bindParam(':id', $band_id);
        $stmt->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage();
    }
}
?>