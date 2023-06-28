<?php
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
        echo 'you used log in';
    } else if ($_POST['submit'] == 'Sign up'){
        if ($_POST['pass'] != $_POST['pass_con']) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }

        $user_id = user_id($pdo);
        $username = $_POST['username'];
        $email = $_POST['email'];
        $pc = $_POST['pc'];

        // hash pass w/ salt
        $unhashed = $_POST['pass'];
        $pass = password_hash($unhashed, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare('INSERT INTO `bezoeker` ()')
    } else {
        echo "Something unexpected happend";
    }
} catch (Exception $e) {
    echo "Error!: <br>" . $e->gerMessage();
}
?>