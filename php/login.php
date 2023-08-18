<?php
// Err1: sign up, passes are not the same
// Err2: sign up, email already exists
// Err3: login, incorrect email or password

include 'connect.php';

function user_id($pdo) {
    $user_id = hexdec(uniqid());

    $query = $pdo->prepare("SELECT `bezoeker_id` FROM `bezoeker` WHERE `bezoeker_id` = :user_id");
    $query->bindparam(":user_id", $user_id);
    $query->execute();

    $result = $query->fetchAll();

    if ($result != NULL) {
        user_id();
    } else {
        return $user_id;
    }
}

try {
    if ($_POST['submit'] == 'Log in') {
        // Get data with $_POST
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        // Get data from database
        $stmt = $pdo->prepare('SELECT `Email`, `Pass` FROM `bezoeker` WHERE `Email` = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetchAll();

        // Check if email exists
        if (empty($user)) {
            setcookie('err3', true, time() + 3, '/');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Check if the correct password is used
        if (!password_verify($pass, $user[0]['Pass'])) {
            setcookie('err3', true, time() + 3, '/');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
        
        // We passed all checks :)
        // Create cookie that makes us stay logged in
        setcookie('logged_in', true, time() + (3600 * 24) * 30, '/');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else if ($_POST['submit'] == 'Sign up'){
        // If the 2 passes are not the same
        // return (L typing)
        if ($_POST['pass'] != $_POST['pass_con']) {
            setcookie('err1', true, time() + 3, '/');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Get user data with $_POST
        $user_id = user_id($pdo);
        $username = $_POST['username'];
        $email = $_POST['email'];
        $pc = $_POST['pc'];

        // hash pass w/ salt
        $unhashed = $_POST['pass'];
        $pass = password_hash($unhashed, PASSWORD_BCRYPT);

        // Check if email exists
        $stmt = $pdo->prepare('SELECT `Email` FROM `bezoeker` WHERE `Email` = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if (!empty($result)) {
            setcookie('err2', true, time() + 3, '/');
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }

        // Clear statement
        unset($result);
        $stmt->closeCursor();
        unset($stmt);

        // Passed all checks
        // Insert into database
        $stmt = $pdo->prepare('INSERT INTO `bezoeker` (`Bezoeker_id`, `Username`, `Email`, `Postcode`, `Pass`, `Is_Admin`) VALUES (:id, :username, :email, :zip, :pass, :is_admin)');
        $stmt->bindParam(':id', $user_id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':zip', $pc);
        $stmt->bindParam(':pass', $pass);
        $stmt->bindParam(':is_admin', 0);
        $stmt->execute();

        $lastInsertId = $pdo->lastInsertId(); // Retrieve the last inserted ID

        $stmt->closeCursor();
        unset($stmt);

        setcookie('logged_in', $user_id, time() + 3600 * 720, "/");

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        echo "Something unexpected happend";
    }
} catch (Exception $e) {
    echo "Error!: <br>" . $e->gerMessage();
}
?>