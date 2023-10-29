<?php
include "../../../php/connect.php";

if (!isset($admin) || !$admin) {
    header('Location: ../../home');
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add bands</title>
    <!--Favicon-->
    <link href="../../../assets/webp/favicon.webp" rel="icon">

    <!-- Stylesheets -->
    <link href="../../generic/main.css" rel="stylesheet" type="text/css">
    <link href="../../generic/gradient.css" rel="stylesheet" type="text/css">
    <link href="../main.css" rel="stylesheet" type="text/css">
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
                <a href="#" class="nav-anchor home-button" tabindex="0">
                    <img src="../../../assets/svg/nav/laptop.svg" alt="admin icon" class="user-icon">
                    Admin
                    <label for="stay_opened_2">
                        <img src="../../../assets/svg/misc/caret-right-fill.svg" alt="arrow" class="img-arrow">
                    </label>
                </a>
            </div>

            <?php if (isset($_COOKIE['login'])) { ?>
                <div class="nav-item login">
                    <a href="../user/edit"><img src="../../../assets/svg/nav/person-circle.svg" alt="user icon" class="user-icon"> <?php echo $_COOKIE['login'] ?></a>

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
        <!-- Add band menu -->
        <div class="main-item">
            <input type="checkbox" id="open_band_menu" class="open_menu_button">
            <label for="open_band_menu" aria-label="Open create band menu" tabindex="0">
                <h1 class="open_menu_text">Create a new band <img src="../../../assets/svg/misc/caret-right-fill.svg" alt="open menu button" class="open_menu_img"></h1>
            </label>

            <div class="menu_content menu_openable">
                <form action="../php/add_band.php" method="post">
                    <ul>
                        <li>
                            <h3 class="item_title">Band name:</h3>
                            <input type="text" name="band_name" aria-label="Textbox for the bands name" tabindex="0" maxlength="250" required>
                        </li>
                        <li>
                            <h3 class="item_title">Genre:</h3>
                            <input type="text" name="genre" aria-label="Textbox for band genre" tabindex="0" maxlength="250" required>
                        </li>
                        <li>
                            <h3 class="item_title">Origin:</h3>
                            <input type="text" name="origin" aria-label="Textbox for band origin" tabindex="0" maxlength="250" required>
                        </li>
                        <li>
                            <h3 class="item_title">Description:</h3>
                            <textarea  name="desc" aria-label="Bigger textbox for band discription" tabindex="0" maxlength="65535" required></textarea>
                        </li>
                        <br>

                        <li>
                            <div class="add_people">
                                <h3 class="item_title">Add person to band list</h3>
                                <input type="checkbox" id="add_people" class="add_item">
                                <label for="add_people" aria-label="Add a person to band list" tabindex="0">
                                    <img src="../../../assets/svg/misc/plus-circle.svg" alt="add button">
                                </label>
                                <input type="checkbox" id="remove_people_0" class="remove_item">
                                <label for="remove_people_0" aria-label="Remove a person to band list" tabindex="0">
                                    <img src="../../../assets/svg/misc/dash-circle.svg" alt="remove button">
                                </label>
                                <input type="checkbox" id="open_band_member_menu" class="open_menu_button open_band_member_menu">
                                <label for="open_band_member_menu" aria-label="Open create band menu" tabindex="0">
                                    <img src="../../../assets/svg/misc/caret-right-fill.svg" alt="open menu button" class="open_menu_member_img open_menu_img">
                                </label>
                            </div>
                            <ul class="people menu_openable">

                            </ul>
                        </li>

                        <br>

                        <input type="submit" name="add_band" value="Create band" aria-label="Add band to database">
                    </ul>
                </form>
            </div>
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
    <script src="../js/main.js"></script>
    <script src="../js/change_values.js"></script>
</body>
</html>