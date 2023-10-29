<?php
include "../../../../php/connect.php";

$name = $_POST['name'];
$pass = $_POST['pass'];

try {
    // Check if email exists
    $stmt = $pdo->prepare('SELECT `Username`, `Pass` FROM `Bezoeker` WHERE `Username` = :name');
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->closeCursor();
    unset($stmt);

    if (empty($result) || !password_verify($pass, $result[0]['Pass'])) {
        setcookie('err', 'Incorrect username or password', time() + 3, '/');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // This account exists;
    $time = 3600 * 24;
    if (isset($_POST['remember'])) {
        $time = (3600 * 24) * 120;
    }

    setcookie('succ', 'Successfully Logged in!', time() + 3, '/');
    setcookie('login', $name, time() + $time, '/');
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
    setcookie('err', 'Something went wrong, please try again later', time() + 3, '/');
}

header('Location: ../../../home');