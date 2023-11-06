<?php
$server = "localhost";
$dbname = "easy_tiger_patio";
$user = "easy_tiger_test";
$pass = "\$2y\$12\$TMt/dqFQFxrmVqtExlWkZuR9oACC5q7LukWFitkse5FLd4C9983i6";

try {
    $pdo = new PDO('mysql:host=' . $server . ';dbname=' . $dbname, $user, $pass);

    // Get admin status
    if (isset($_COOKIE['login'])) {
        $stmt = $pdo->prepare('SELECT `Is_Admin` FROM `bezoeker` WHERE `Username` = :name');
        $stmt->bindParam(':name', $_COOKIE['login']);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt->closeCursor();
        unset($stmt);

        if (isset($result[0]) && $result[0]['Is_Admin'] == 1) {
            $admin = true;
        }

        unset($result);
    }
} catch (PDOException $e) {
    print("Error!: " . $e->getMessage());
}