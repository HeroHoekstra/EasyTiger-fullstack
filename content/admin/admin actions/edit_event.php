<?php
include "../../../php/connect.php";

if (!isset($admin) || !$admin) {
    header('Location: ../../home');
    exit();
}

// Get bands
ob_start();
require('../php/get_bands.php');
session_start();
$bands = $_SESSION['bands'];
ob_end_clean();

// Get events
ob_start();
require('../php/get_events.php');
session_start();
$events = $_SESSION['events'];
ob_end_clean();

header('Content-Type: text/html');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit events</title>
    <!--Favicon-->
    <link href="../../../assets/webp/favicon.webp" rel="icon">

    <!-- Stylesheets -->
    <link href="../../generic/main.css" rel="stylesheet" type="text/css">
    <link href="../css/buttons.css" rel="stylesheet" type="text/css">
    <link href="../css/layout.css" rel="stylesheet" type="text/css">
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
                <a href="../../admin/admin%20actions/add_band.php" class="nav-anchor home-button" tabindex="0">
                    <img src="../../../assets/svg/nav/laptop.svg" alt="admin icon" class="user-icon">
                    Admin
                    <label for="stay_opened_2">
                        <img src="../../../assets/svg/misc/caret-right-fill.svg" alt="arrow" class="img-arrow">
                    </label>
                </a>
            </div>

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
    <div class="main-item edit_event">
        <input type="checkbox" id="open_edit_event" class="open_menu_button">
        <label for="open_edit_event" aria-label="Open create edit event menu" tabindex="0">
            <h1 class="open_menu_text">Edit existing event <img src="../../../assets/svg/misc/caret-right-fill.svg" alt="open menu button" class="open_menu_img"></h1>
        </label>

        <div class="menu_content menu_openable">
            <ul>
                <li>
                    <ul>
                        <h3>Select band:</h3>
                        <small class="found_display"></small>
                        <br>
                        <input type="text" class="search" aria-label="Search band by name" tabindex="0" autocomplete="off">
                    </ul>

                    <div id="event_add">
                        <?php
                        foreach ($events as $event) {
                            echo "
                                <div class=\"edit_band_band\" data-event_id=\"" . $event['Event_id'] . "\">
                                    <p class=\"band_title\" data-name=\"" . $event['Naam'] . "\"><b>" . $event['Naam'] . "</b></p>
                                    <ul class=\"band_attributes\">
                                        <li>Date: " . $event['Datum'] . "</li>
                                        <li>Price: €" . $event['Entreegeld'] . "</li>
                                        <li>Start time: " . $event['Starttijd'] . "</li>
                                        <li>" . count($event['performance']) . " performances</li>
                                    </ul>
                                    <p class=\"edit\">[Edit]</p>
                                </div>
                                ";
                        }
                        ?>
                    </div>
                </li>
                <li>
                    <form action="../php/edit_event.php" method="post" id="edit_events">
                        <ul class="form_list">
                            <li>
                                <h3 class="item_title">Event name:</h3>
                                <input type="text" name="event_name" aria-label="Input field for the event name" tabindex="0" required>
                            </li>
                            <li>
                                <h3 class="item_title">Price:</h3>
                                <input type="number" name="price" aria-label="Input field for the event'script price" tabindex="0" step="0.01" required>
                            </li>
                            <li>
                                <h3 class="item_title">Date:</h3>
                                <input type="date" name="date" aria-label="Input field for the event date" tabindex="0" required>
                            </li>
                            <li>
                                <h3 class="item_title">Start time:</h3>
                                <input type="time" name="start_time" aria-label="Input field for the event's start time" tabindex="0" required>
                            </li>
                            <li>
                                <ul>
                                    <h3>Select band:</h3>
                                    <small class="found_display"></small>
                                    <br>
                                    <input type="text" class="search" aria-label="Search band by name" tabindex="0" autocomplete="off">
                                </ul>

                                <div id="event_edit">
                                    <?php
                                    foreach ($bands as $band) {
                                        echo "
                                            <div class=\"edit_band_band\" data-band_id=\"" . $band['Band_id'] . "\">
                                                <p class=\"band_title\" data-name=\"" . $band['Naam'] . "\"><b>" . $band['Naam'] . "</b></p>
                                                <ul class=\"band_attributes\">
                                                    <li>Genre: " . $band['Genre'] . "</li>
                                                    <li>Origin: " . $band['Herkomst'] . "</li>
                                                    <li>" . count($band['members']) . " band members</li>
                                                </ul>
                                                <p class=\"add edit\">[Add]</p>
                                            </div>
                                            ";
                                    }
                                    ?>
                                </div>
                            </li>
                            <li>
                                <div class="added_bands" id="added_bands">

                                </div>
                            </li>
                        </ul>

                        <input type="submit" name="edit_event" value="Add event" aria-label="Submit the event to the database">
                        <br>
                        <input type="checkbox" name="sure_ev" aria-label="Are you sure you want to delete this band">
                        <input type="submit" name="delete_event" value="Delete Event" aria-label="Delete event">

                        <p class="cancel_edit">[Cancel]</p>
                        <input type="hidden" name="event_id" id="edit_event_id">
                    </form>
                </li>
            </ul>
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
<script src="../js/get_bands.js"></script>
<script src="../js/get_events.js"></script>
</body>
</html>