<?php
if (!isset($_COOKIE['login'])) {
    header('Location: ../../home/');
    exit();
}

include "../../../php/connect.php";

try {
    $stmt = $pdo->prepare('SELECT `Bezoeker_id`, `Username`, `Email`, `Postcode`, `Pass`, `Is_Admin` FROM `bezoeker` WHERE `Username` = :name');
    $stmt->bindParam(':name', $_COOKIE['login']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt->closeCursor();
    unset($stmt);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit account</title>
    <!-- Favicon -->
    <link href="../../../assets/webp/favicon.webp" rel="icon">

    <!-- CSS -->
    <link href="../../generic/main.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php  if (isset($_COOKIE['succ'])) { ?>
        <div class="msg" style="background-color: green">
            <p><?php echo $_COOKIE['succ'] ?></p>
        </div>
    <?php } else if (isset($_COOKIE['err'])) { ?>
        <div class="msg" style="background-color: red">
            <p><?php echo $_COOKIE['err'] ?></p>
        </div>
    <?php } ?>

    <nav>
        <div class="nav-bar" id="nav_bar">
            <div class="nav-item home">
                <input type="checkbox" id="stay_opened_0" class="stay_opened">
                <div class="nav-sub-item home-list">
                    <!-- Page subsections (if it has them) -->
                    <ul>
                        <li class="select-page-section">
                            <!--suppress HtmlUnknownAnchorTarget -->
                            <a href="../../home#items_1">About us</a>
                        </li>
                        <li class="select-page-section">
                            <!--suppress HtmlUnknownAnchorTarget -->
                            <a href="../../home#items_2">Our events</a>
                        </li>
                        <li class="select-page-section">
                            <!--suppress HtmlUnknownAnchorTarget -->
                            <a href="../../home#items_3">Tickets & admission</a>
                        </li>
                        <li class="select-page-section">
                            <!--suppress HtmlUnknownAnchorTarget -->
                            <a href="../../home#items_4">Experience & enjoyment</a>
                        </li>
                        <li class="select-page-section">
                            <!--suppress HtmlUnknownAnchorTarget -->
                            <a href="../../home#items_5">Stay connected</a>
                        </li>
                    </ul>
                </div>
                <a href="../../home" class="nav-anchor home-button" tabindex="0">
                    <img src="../../../assets/svg/nav/house-fill.svg" alt="home icon" class="user-icon">
                    Home
                    <label for="stay_opened_0">
                        <img src="../../../assets/svg/misc/caret-right-fill.svg" alt="arrow" class="img-arrow">
                    </label>
                </a>
            </div>

            <div class="nav-item">
                <a href="../../events" class="nav-anchor" tabindex="0">
                    <img src="../../../assets/svg/nav/calendar-event.svg" alt="event icon" class="user-icon">
                    Events
                </a>
            </div>

            <?php if (isset($admin) && $admin) { ?>
                <div class="nav-item home">
                    <input type="checkbox" id="stay_opened_2" class="stay_opened">
                    <div class="nav-sub-item home-list">
                        <!-- Page subsections (if it has them) -->
                        <ul>
                            <li class="select-page-section">
                                <a href="../../admin/admin%20actions/add_band.php">Add bands</a>
                            </li>
                            <li class="select-page-section">
                                <a href="../../admin/admin%20actions/edit_band.php">Edit bands</a>
                            </li>
                            <li class="select-page-section">
                                <a href="../../admin/admin%20actions/add_event.php">Add events</a>
                            </li>
                            <li class="select-page-section">
                                <a href="../../admin/admin%20actions/edit_event.php">Edit events</a>
                            </li>
                        </ul>
                    </div>
                    <a href="../../admin/admin%20actions/add_band.php" class="nav-anchor home-button" tabindex="0">
                        <img src="../../../assets/svg/nav/laptop.svg" alt="admin icon" class="user-icon">
                        Admin
                        <label for="stay_opened_2">
                            <img src="../../../assets/svg/misc/caret-right-fill.svg" alt="arrow" class="img-arrow">
                        </label>
                    </a>
                </div>
            <?php } else {echo "<br>";} ?>

            <?php if (isset($_COOKIE['login'])) { ?>
                <div class="nav-item login">
                    <a href="../../user/edit"><img src="../../../assets/svg/nav/person-circle.svg" alt="user icon" class="user-icon"> <?php echo $_COOKIE['login'] ?></a>

                    <a href="../../user/login/php/logout.php"><img src="../../../assets/svg/nav/box-arrow-right.svg" alt="log out" class="user-icon"> Log out</a>
                </div>
            <?php } else { ?>
                <div class="nav-item login">
                    <a href="../../user/login/index.php?login=Login">Login</a>

                    <a href="../../user/login/index.php?login=Sign%20up">Sign up</a>
                </div>
            <?php } ?>
        </div>
    </nav>

    <main>
        <div class="main-item">
            <form method="post" action="edit.php">
                <label>
                    Username:
                    <input type="text" name="name" value="<?php echo $result[0]['Username'] ?>">
                </label>
                <br>

                <label>
                    Email:
                    <input type="email" name="email" value="<?php echo $result[0]['Email'] ?>">
                </label>
                <br>

                <label>
                    Postal code:
                    <input type="text" name="pc" value="<?php echo $result[0]['Postcode'] ?>">
                </label>
                <br>

                <p id="change_pass">Change password</p>
                <label id="form" style="display: none">
                    Old password: <input type="password" name="old_pass">
                    <br>
                    New password: <input type="password" name="new_pass">
                    <br>
                    Confirm password: <input type="password" name="new_pass_c">
                </label>

                <input type="hidden" name="id" value="<?php echo $result[0]['Bezoeker_id'] ?>">
                <input type="submit" name="edit">
            </form>

            <?php if ($result[0]['Is_Admin'] == 1) { ?>
            <br>
            <br>
            <form action="./addAdmin.php" method="post">
                <label>
                    <select name="set_status">
                        <option value="true">Add</option>
                        <option value="false">Remove</option>
                    </select>
                </label>
                <br>

                <label>
                    Enter username to edit admin status:
                    <input type="text" name="name">
                </label>
                <br>

                <input type="submit" name="addmin">
            </form>
            <?php } ?>

            <br>
            <br>
            <form action="./delete.php" method="post">
                <label>
                    To delete account type your pass and submit and confirm:
                    <input type="password" name="confirm">
                    <br>

                    Confirm:
                    <input type="checkbox" name="confirm_box">
                </label>
                <br>
                <input type="hidden" name="id" value="<?php echo $result[0]['Bezoeker_id'] ?>">
                <input type="submit" name="delete">
            </form>
        </div>
    </main>

    <footer>
        <!-- Contact -->
        <div class="contact">
            <h4><b>Contact us:</b></h4>
            <ul>
                <li>Easy Tiger Patio</li>
                <li>123 Main Street, City ville</li>
                <li>Phone: 555-123-4567</li>
                <li>Email: info@easy-tiger.com</li>
            </ul>
        </div>

        <!-- Socials -->
        <div class="socials">
            <h4><b>Find us on social media:</b></h4>
            <ul>
                <li>
                    <a href="https://youtu.be/ee6DUqNarek" target="_blank">
                        <img src="../../../assets/svg/social/youtube.svg" alt="youtube icon"> Youtube
                    </a>
                </li>
                <li>
                    <a href="https://twitter.com/KFC_ES" target="_blank">
                        <img src="../../../assets/svg/social/twitter.svg" alt="twitter icon"> Twitter
                    </a>
                </li>
                <li>
                    <a href="https://www.tumblr.com/charlottan/718874362310246400" target="_blank">
                        <img src="../../../assets/svg/social/tumblr.svg" alt="tumblr icon"> Tumblr
                    </a>
                </li>
            </ul>
        </div>

        <!-- Disclaimer -->
        <div class="disclaimer">
            <ul>
                <li>Terms of Service | Privacy Policy | Copyright © 2023 Easy Tiger Patio</li>
                <li>Disclaimer: This website is a fictional creation for educational purposes only.</li>
            </ul>
        </div>
    </footer>

    <script src="../../generic/nav.js"></script>
    <script>
        const button = document.getElementById('change_pass');
        const pass_form = document.getElementById('form');
        let opened = false;

        button.addEventListener('click', () => {
            opened = !opened;

            pass_form.style.display = opened ? 'block' : 'none';
        });
    </script>
</body>
</html>