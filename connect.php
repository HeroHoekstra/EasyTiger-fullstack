<?php
$server = "localhost";
$dbname = "easy_tiger_patio";
$user = "easy_tiger_test";
$pass = "$2y$12\$TMt/dqFQFxrmVqtExlWkZuR9oACC5q7LukWFitkse5FLd4C9983i6";

try {
    $pdo = new PDO('mysql:host=' . $server . ';dbname=' . $dbname, $user, $pass);
} catch (PDOException $e) {
    print("Error!: <br>" . $e->getMessage() . "<br>");
}
?>