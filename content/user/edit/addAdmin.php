<?php
include "../../../php/connect.php";

try {
    $status = 0;
    if ($_POST['set_status'] == "true") {
        $status = 1;
    } else {
        $status = 0;
    }

    $data = [
        ':status' => $status,
        ':name' => $_POST['name']
    ];

    $stmt = $pdo->prepare('UPDATE `bezoeker` SET `Is_Admin` = :status WHERE `Username` = :name');
    $stmt->execute($data);
    $stmt->closeCursor();

    if ($status == 1) {
        setcookie('succ', 'Added ' . $_POST['name'] . ' as an admin', time() + 3, '/');
    } else {
        setcookie('succ', 'Removed ' . $_POST['name'] . '\'s admin status', time() + 3, '/');
    }
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
    setcookie('err', 'Something went wrong, please try again later', time() + 3, '/');
}

header('Location: ' . $_SERVER['HTTP_REFERER']);