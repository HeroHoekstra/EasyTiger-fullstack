<?php
include '../../php/connect.php';

if (isset($_POST['add_event'])) {
    try {
        // Get event data
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
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage();

        setcookie('err', 'Failed to add event', time() + 3, '/');
    }
}
?>