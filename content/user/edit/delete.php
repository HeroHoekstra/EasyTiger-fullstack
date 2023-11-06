<?php
include "../../../php/connect.php";

try {
    $stmt = $pdo->prepare('SELECT `Pass` FROM `bezoeker` WHERE `Bezoeker_id` = :id');
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->closeCursor();
    unset($stmt);

    if (password_verify($_POST['confirm'], $result[0]['Pass']) && $_POST['confirm_box']) {
        // Remove all tickets bought
        $stmt = $pdo->prepare('DELETE FROM `bezoekers_events` WHERE `Bezoeker_id` = :id');
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->execute();

        $stmt->closeCursor();

        // Remove user
        $stmt = $pdo->prepare('DELETE FROM `bezoeker` WHERE `Bezoeker_id` = :id');
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->execute();

        $stmt->closeCursor();

        setcookie('succ', 'Deleted your account', time() + 3, '/');
    } else {
        setcookie('err', 'Incorrect password given or confirm wasn\'t active', time() + 3, '/');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
    setcookie('err', 'Something went wrong, please try again later', time() + 3, '/');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

header('Location: ../login/php/logout.php');