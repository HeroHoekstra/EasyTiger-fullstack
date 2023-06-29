<?php
include '../php/connect.php';

function band_id($pdo) {
    $band_id = hexdec(uniqid());

    $query = $pdo->prepare("SELECT `band_id` FROM `band` WHERE `band_id` = :band_id");
    $query->bindparam(":band_id", $band_id);
    $query->execute();

    $result = $query->fetchAll();

    if ($result != NULL) {
        band_id();
    } else {
        return $band_id;
    }
}

try {
    $band_id = band_id($pdo);
    $name = $_POST['name'];
    $genre = $_POST['genre'];
    $origin = $_POST['origin'];
    $desc = $_POST['desc'];

    $query = $pdo->prepare("INSERT INTO `band` 
        (`Band_id`, `Naam`, `Genre`, `Herkomst`, `Omschrijving`)
        VALUES (:band_id, :name, :genre, :origin, :desc)");
    $query->bindparam(":band_id", $band_id);
    $query->bindparam(":name", $name);
    $query->bindparam(":genre", $genre);
    $query->bindparam(":origin", $origin);
    $query->bindparam(":desc", $desc);
    $query->execute();
} catch (Exception $e) {
    print("Error!: <br>" . $e->getMessage() . "<br>");
}
?>