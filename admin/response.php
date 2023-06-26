<?php
include '../connect.php';

try {
    $query = $pdo->prepare(INSERT INTO band 
        (Band_id, Naam, Genre, Herkomst, Omschrijving)
        VALUES ())
} catch (Exception $e) {
    print("Error!: <br>" . $e->getMessage() . "<br>");
}
?>