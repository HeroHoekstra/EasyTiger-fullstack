<?php
include "../../../php/connect.php";

// Check if pass needs to change
$passes = [
    $_POST['old_pass'],
    $_POST['new_pass'],
    $_POST['new_pass_c']
];

$is_filled = false;

foreach ($passes as $pass) {
    if ($pass != "") {
        $is_filled = true;
    }

    if ($is_filled && $pass == "") {
        setcookie('err', 'Please fill in your old password and the new password', time() + 3, '/');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

try {
    $stmt = $pdo->prepare('SELECT `Pass` FROM `bezoeker` WHERE `Bezoeker_id` = :id');
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->closeCursor();
    unset($stmt);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
    setcookie('err', 'Something went wrong, please try again later', time() + 3, '/');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

if ($is_filled && !password_verify($passes[0], $result[0]['Pass'])) {
    setcookie('err', 'Old password does not match up', time() + 3, '/');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

if ($passes[1] != $passes[2]) {
    setcookie('err', 'New password does not match up', time() + 3, '/');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

// Check for Username and email
// Check if the username / email exists
try {
    $data = [
        ':name' => $_POST['name'],
        ':email' => $_POST['email']
    ];

    $stmt = $pdo->prepare('SELECT `Username`, `Email`, `Postcode`, `Pass` FROM `bezoeker` WHERE `Username` = :name OR `Email` = :email');
    $stmt->execute($data);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->closeCursor();
    unset($stmt);
    unset($data);

    $posts = [
        $_POST['name'],
        $_POST['email'],
        $_POST['pc'],
    ];

    $changed = false;
    foreach ($result[0] as $i=>$item) {
        if ($i > count($posts)) {
            break;
        }
        if ($posts[$i] != $item) {
            echo $posts[$i];
        }
    }

    if (!$changed) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    if (count($result) > 0) {
        foreach ($result as $row) {
            if ($row['Username'] === $_POST['name']) {
                setcookie('err', 'This username is already in use', time() + 3, '/');
                break;
            } else if ($row['Email'] === $_POST['email']) {
                setcookie('err', 'This email is already in use', time() + 3, '/');
                break;
            }
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
    setcookie('err', 'Something went wrong, please try again later', time() + 3, '/');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}


// Do the edit
try {
    $pass;
    if ($is_filled) {
        $pass = $passes[1];
    } else {
        $pass = $result[0]['Pass'];
    }

    $data = [
        ':id' => $_POST['id'],
        ':name' => $_POST['name'],
        ':email' => $_POST['email'],
        ':pc' => $_POST['pc'],
        ':pass' => password_hash($pass, PASSWORD_BCRYPT)
    ];

    $stmt = $pdo->prepare('UPDATE `bezoeker` SET `Username` = :name, `Email` = :email, `Postcode` = :pc, `Pass` = :pass WHERE `Bezoeker_id` = :id');
    $stmt->execute($data);
    $stmt->closeCursor();
    unset($stmt);

    setcookie('succ', 'Successfully edited your profile', time() + 3, '/');
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
    setcookie('err', 'Something went wrong, please try again later', time() + 3, '/');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

header('Location: ' . $_SERVER['HTTP_REFERER']);