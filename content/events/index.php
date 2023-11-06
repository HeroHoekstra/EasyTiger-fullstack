<?php
include "../../php/connect.php";

try {
    $queryCondition = "";
    if (isset($_GET['filter']) && $_GET['filter'] == "future") {
        $queryCondition = "WHERE `Datum` > CURDATE()";
    } else if (isset($_GET['filter']) && $_GET['filter'] == "past") {
        $queryCondition = "WHERE `Datum` < CURDATE()";
    }

    $stmt = $pdo->prepare("SELECT evenementen.Event_id AS Event_id, evenementen.Naam AS Event_Name, evenementen.Datum AS Event_Date, evenementen.Starttijd AS Event_Starttime, evenementen.Entreegeld AS Event_Price,
        optredens.Band_id AS Band_id, optredens.Sets AS Per_Sets,
        band.Naam AS Band_Name, band.Genre AS Band_Genre, band.Herkomst AS Band_Origin, band.Omschrijving AS Band_Desc,
        CASE WHEN evenementen.Datum > CURDATE() THEN 'no' ELSE 'yes' END AS past
    FROM evenementen
    LEFT JOIN optredens ON evenementen.Event_id = optredens.Event_id
    LEFT JOIN band ON optredens.Band_id = band.Band_id" . $queryCondition);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $grouped_events = array();

    foreach ($result as $row) {
        $event_id = $row['Event_id'];

        if (!isset($grouped_events[$event_id])) {
            $grouped_events[$event_id] = array(
                'Event_id' => $event_id,
                'Per' => array(),
            );
        }

        $grouped_events[$event_id]['Per'][] = $row;
    }

    $stmt->closeCursor();
    unset($stmt);
    unset($result);
} catch (PDOException $e) {
    echo "Error!: " . $e->getMessage();
}

function ticketItem($event, $past) {
    $set = false;
    if (isset($_COOKIE['login'])) {
        $set = true;
    }

    $msg = "";
    if (!$past) {
        $msg = "Get your tickets here!";
    } else {
        $msg = "This event already happened, <br>but you can still attend others!";
    }

    $link = "#";
    if (!$past) {
        if ($set) {
            $link = "./tickets/index.php?event_id=" . $event['Event_id'];
        } else {
            $link = "../user/login";
        }
    } else {
        $link = "?filter=Upcoming";
    }

    echo "
    <div class='showcase-item'>
        <div class='event-name'>
            <h2>" . $event['Per'][0]['Event_Name'] . "</h2>
        </div>
        <div class='event-date'>
            <h3>" . $event['Per'][0]['Event_Date'] . "</h3>
            <h4 class='price'>€" . $event['Per'][0]['Event_Price'] . "</h4>
            <a href='" . $link . "'><i>" . $msg . "</i></a>
        </div>
        
        <div class='band-showcase'>
    ";

    foreach ($event['Per'] as $band) {
        echo "
            <div class='band-showcase-item'>
                <h3>These bands will be perfroming:</h3>
                <h3 class='band-name'>" . $band['Band_Name'] . "</h3>
             </div>
        ";
    }
    echo "</div></div>";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Events</title>
    <link href="../../assets/webp/favicon.webp" rel="icon">

    <link href="../generic/main.css" rel="stylesheet" type="text/css">
    <link href="./main.css" rel="stylesheet" type="text/css">
    <link href="../home/css/show%20case.css" rel="stylesheet" type="text/css">
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
                            <a href="../home#items_1">About us</a>
                        </li>
                        <li class="select-page-section">
                            <!--suppress HtmlUnknownAnchorTarget -->
                            <a href="../home#items_2">Our events</a>
                        </li>
                        <li class="select-page-section">
                            <!--suppress HtmlUnknownAnchorTarget -->
                            <a href="../home#items_3">Tickets & admission</a>
                        </li>
                        <li class="select-page-section">
                            <!--suppress HtmlUnknownAnchorTarget -->
                            <a href="../home#items_4">Experience & enjoyment</a>
                        </li>
                        <li class="select-page-section">
                            <!--suppress HtmlUnknownAnchorTarget -->
                            <a href="../home#items_5">Stay connected</a>
                        </li>
                    </ul>
                </div>
                <a href="../home" class="nav-anchor home-button" tabindex="0">
                    <img src="../../assets/svg/nav/house-fill.svg" alt="home icon" class="user-icon">
                    Home
                    <label for="stay_opened_0">
                        <img src="../../assets/svg/misc/caret-right-fill.svg" alt="arrow" class="img-arrow">
                    </label>
                </a>
            </div>

            <div class="nav-item">
                <a href="../events" class="nav-anchor" tabindex="0">
                    <img src="../../assets/svg/nav/calendar-event.svg" alt="event icon" class="user-icon">
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
                                <a href="../admin/admin%20actions/add_band.php">Add bands</a>
                            </li>
                            <li class="select-page-section">
                                <a href="../admin/admin%20actions/edit_band.php">Edit bands</a>
                            </li>
                            <li class="select-page-section">
                                <a href="../admin/admin%20actions/add_event.php">Add events</a>
                            </li>
                            <li class="select-page-section">
                                <a href="../admin/admin%20actions/edit_event.php">Edit events</a>
                            </li>
                        </ul>
                    </div>
                    <a href="../admin/admin%20actions/add_band.php" class="nav-anchor home-button" tabindex="0">
                        <img src="../../assets/svg/nav/laptop.svg" alt="admin icon" class="user-icon">
                        Admin
                        <label for="stay_opened_2">
                            <img src="../../assets/svg/misc/caret-right-fill.svg" alt="arrow" class="img-arrow">
                        </label>
                    </a>
                </div>
            <?php } else {echo "<br>";} ?>

            <?php if (isset($_COOKIE['login'])) { ?>
                <div class="nav-item login">
                    <a href="../user/edit"><img src="../../assets/svg/nav/person-circle.svg" alt="user icon" class="user-icon"> <?php echo $_COOKIE['login'] ?></a>

                    <a href="../user/login/php/logout.php"><img src="../../assets/svg/nav/box-arrow-right.svg" alt="log out" class="user-icon"> Log out</a>
                </div>
            <?php } else { ?>
                <div class="nav-item login">
                    <a href="../user/login/index.php?login=Login">Login</a>

                    <a href="../user/login/index.php?login=Sign%20up">Sign up</a>
                </div>
            <?php } ?>
        </div>
    </nav>

    <main>
        <div class="filter">
            <p>Filter: <?php if (isset($_GET['filter'])) { echo $_GET['filter']; } else { echo "None"; } ?></p>
            <div id="filter-items" style="display: none">
                <a href="./index.php?filter=None">None</a> <br>
                <a href="./index.php?filter=Upcoming">Upcoming</a> <br>
                <a href="./index.php?filter=Past">Past</a> <br>
            </div>
        </div>

        <div class="main-item">
            <?php if (!isset($_GET['filter']) || $_GET['filter'] != "Past") { ?>
                <div class="border-parent">
                    <h2 class="border-title">Upcoming</h2>
                    <span class="line"></span>
                </div>

                <div class="show-case" id="show_case">
                    <?php
                        $hasItem = false;
                        foreach ($grouped_events as $event) {
                            if ($event['Per'][0]['past'] == 'no') {
                                ticketItem($event, false);
                                $hasItem = true;
                            }
                        }

                        if (!$hasItem) {
                            echo "<small><i><b>It seems there are no results for this</b></i></small>";
                        }

                        echo "</div>";
                    }
                    ?>

            <?php if (!isset($_GET['filter']) || $_GET['filter'] != "Upcoming") { ?>
                <div class="border-parent">
                    <h2 class="border-title">Past</h2>
                    <span class="line"></span>
                </div>

                <div class="show-case" id="show_case">
                    <?php
                        $hasItem = false;
                        foreach ($grouped_events as $event) {
                            if ($event['Per'][0]['past'] == 'yes') {
                                ticketItem($event, true);
                                $hasItem = true;
                            }
                        }

                        if (!$hasItem) {
                            echo "<small><i><b>It seems there are no results for this</b></i></small>";
                        }

                        echo "</div>";
                    }
                ?>
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
                        <img src="../../assets/svg/social/youtube.svg" alt="youtube icon"> Youtube
                    </a>
                </li>
                <li>
                    <a href="https://twitter.com/KFC_ES" target="_blank">
                        <img src="../../assets/svg/social/twitter.svg" alt="twitter icon"> Twitter
                    </a>
                </li>
                <li>
                    <a href="https://www.tumblr.com/charlottan/718874362310246400" target="_blank">
                        <img src="../../assets/svg/social/tumblr.svg" alt="tumblr icon"> Tumblr
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

    <script src="../generic/nav.js"></script>
    <script src="../home/showcase.js"></script>
    <script>
        // Filter
        const parent = document.querySelector('.filter');
        const filterItems = document.getElementById('filter-items');
        let isOpen = false;

        parent.addEventListener('click', () => {
            filterItems.style.display = isOpen ? 'none' : 'block';

            isOpen = !isOpen;
        });
    </script>
</body>
</html>