<?php
include "../../../../php/connect.php";

// If pass confirm was incorrect
if ($_POST['pass'] != $_POST['pass_c']) {
    setcookie('err', 'Passwords don\'t match', time() + 3, '/');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

function user_id($pdo) {
    $user_id = hexdec(uniqid());

    $query = $pdo->prepare("SELECT `bezoeker_id` FROM `bezoeker` WHERE `bezoeker_id` = :user_id");
    $query->bindparam(":user_id", $user_id);
    $query->execute();

    $result = $query->fetchAll();

    if ($result != NULL) {
        user_id($pdo);
    } else {
        return $user_id;
    }
}

$id = user_id($pdo);
$name = $_POST['name'];
$email = $_POST['email'];
$pc = $_POST['pc'];
$pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);

try {
    // Check if the username / email exists
    $data = [
        ':name' => $name,
        ':email' => $email
    ];

    $stmt = $pdo->prepare('SELECT `Username`, `Email` FROM `bezoeker` WHERE `Username` = :name OR `Email` = :email');
    $stmt->execute($data);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->closeCursor();
    unset($stmt);
    unset($data);

    if (count($result) > 0) {
        foreach ($result as $row) {
            if ($row['Username'] === $name) {
                setcookie('err', 'This username is already in use', time() + 3, '/');
                break;
            } else if ($row['Email'] === $email) {
                setcookie('err', 'This email is already in use', time() + 3, '/');
                break;
            }
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    unset($result);

    // Passed all checks
    $data = [
        ':id' => $id,
        ':name' => $name,
        ':email' => $email,
        ':pc' => $pc,
        ':pass' => $pass
    ];
    $stmt = $pdo->prepare('INSERT INTO `bezoeker` (`Bezoeker_id`, `Username`, `Email`, `Postcode`, `Pass`) VALUES (:id, :name, :email, :pc, :pass)');
    $stmt->execute($data);
    $stmt->closeCursor();

    $time = 3600 * 24;
    if (isset($_POST['remember'])) {
        $time = (3600 * 24) * 120;
    }

    setcookie('succ', 'Successfully signed up!', time() + 3, '/');
    setcookie('login', $name, time() + $time, '/');
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
    setcookie('err', 'Something went wrong, please try again later', time() + 3, '/');
}

header('Location: ../../../home');