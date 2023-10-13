<?php
include "../../php/connect.php";

// Get event info
try {
    $stmt = $pdo->prepare('SELECT 
        evenementen.Event_id AS Event_id, evenementen.Naam AS Event_Name, evenementen.Datum AS Event_Date, evenementen.Starttijd AS Event_Starttime, evenementen.Entreegeld AS Event_Price,
        optredens.Band_id AS Band_id, optredens.Sets AS Per_Sets, optredens.Starttijd AS Per_Starttime, optredens.Eindtijd AS Per_Endtime,
        band.Naam AS Band_Name, band.Genre AS Band_Genre, band.Herkomst AS Band_Origin, band.Omschrijving AS Band_Desc
    FROM evenementen
    LEFT JOIN optredens ON evenementen.Event_id = optredens.Event_id
    LEFT JOIN band ON optredens.Band_id = band.Band_id
    WHERE evenementen.Datum > CURRENT_DATE()');
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $grouped_events = array();

    foreach ($result as $row) {
        $event_id = $row['Event_id'];

        if (!isset($grouped_events[$event_id])) {
            $grouped_events[$event_id] = array();
        }

        $grouped_events[$event_id][] = $row;
    }

    $stmt->closeCursor();
    unset($stmt);
    unset($result);
} catch (Exception $e) {
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
    <title>Easy Tiger Patio</title>
    <!-- Favicon -->
    <link href="../../assets/webp/favicon.webp" rel="icon">

    <!-- Main CSS for nav and footer -->
    <link href="main.css" rel="stylesheet" type="text/css">
    <link href="home.css" rel="stylesheet" type="text/css">
    <link href="show%20case.css" rel="stylesheet" type="text/css">
</head>
<body>
    <nav>
        <div class="nav-bar" id="nav_bar">
            <div class="nav-item home">
                <input type="checkbox" id="stay_opened">
                <div class="nav-sub-item home-list">
                    <!-- Page subsections (if it has them) -->
                    <ul>
                        <li class="select-page-section">
                            <!--suppress HtmlUnknownAnchorTarget -->
                            <a href="#item_1">About us</a>
                        </li>
                        <li class="select-page-section">
                            <!--suppress HtmlUnknownAnchorTarget -->
                            <a href="#item_2">Our events</a>
                        </li>
                        <li class="select-page-section">
                            <!--suppress HtmlUnknownAnchorTarget -->
                            <a href="#item_3">Tickets & admission</a>
                        </li>
                        <li class="select-page-section">
                            <!--suppress HtmlUnknownAnchorTarget -->
                            <a href="#item_4">Experience & enjoyment</a>
                        </li>
                        <li class="select-page-section">
                            <!--suppress HtmlUnknownAnchorTarget -->
                            <a href="#item_5">Stay connected</a>
                        </li>
                    </ul>
                </div>
                <a href="#" class="nav-anchor home-button" tabindex="0">
                    <label for="stay_opened">
                        Home <!-- Page title -->
                        <img src="../../assets/svg/misc/caret-right-fill.svg" alt="arrow" class="img-arrow">
                    </label>
                </a>
            </div>
        </div>

        <div class="page-section">
            <a href="#" class="nav-section-select" id="section_up">
                <img src="../../assets/svg/misc/caret-right-fill.svg" alt="Section up">
            </a>

            <a href="#" class="nav-section-select" id="section_down">
                <img src="../../assets/svg/misc/caret-right-fill.svg" alt="Section down">
            </a>
        </div>
    </nav>

    <div class="follow-gradiant">
        <div class="background-gradiant"></div>
        <div class="gradiant" id="gradiant"></div>
    </div>

    <header class="main-item">
        <div class="header-title-container" id="header-container">
            <div class="header-background" id="header_bg"> </div>
            <h1 class="header-title" id="header_title">
                <b class="company-name">Welcome to EasyTiger Patio:</b>
                Where Music Comes To Life!
            </h1>
        </div>
    </header>

    <main>
        <div class="main-item">
            <h2 class="subsection-title" aria-level="2">About Us:</h2>
            <p class="subsection-text" aria-label="About Us Text">
                Easy Tiger Patio is a unique cafe and music theater that brings together great music and a cozy atmosphere. We are passionate about hosting unforgettable music nights featuring talented bands from various genres. Our mission is to provide a platform for artists to showcase their skills and for music enthusiasts to immerse themselves in a vibrant and engaging experience.
            </p>
        </div>

        <div class="main-item">
            <h2 class="subsection-title" aria-level="2">Our Events:</h2>
            <p class="subsection-text" aria-label="our events text">
                At Easy Tiger Patio, we curate an exciting lineup of bands and musicians who deliver outstanding performances. From electrifying headlining acts to talented supporting bands, our events cater to diverse musical tastes. On special occasions, we also organize festivals where multiple headlining acts captivate the audience throughout the day or evening.
                <br>
                Join us for a night filled with exceptional live music, energetic performances, and a warm, inviting ambiance. Whether you're a die-hard fan or just looking for a memorable evening out, Easy Tiger Patio is the place to be.
            </p>
        </div>

        <div class="main-item tickets-and-admission">
            <h2 class="subsection-title" aria-level="2">Tickets and Admission:</h2>
            <p class="subsection-text" aria-label="tickets and admission text">
                While some of our events offer free admission, many require purchasing tickets to ensure the best experience for our guests. We believe in supporting the artists, and their performances come at a price. Stay tuned for upcoming events and ticket availability, as we bring you the best in live music entertainment.
                <br>
                Here are some peeks at our upcoming events:
            </p>

            <!--<div class="show-case-background"></div>
            <div class="show-case-gradiant"></div>
            <div class="show-case">
                 <?php /*
                 if (count($grouped_events) > 3) {
                     for ($i = 0; $i < 3; $i++) {
                         showcaseDisplay($grouped_events[$i]);
                     }
                 } else {
                     foreach ($grouped_events as $event) {
                         showcaseDisplay($event);
                     }
                 }

                 function showcaseDisplay($event) {
                     echo "
                    <div class='showcase-item'>
                        <div class='event-name'>
                            <h2>" . $event[0]['Event_Name'] . "</h2>
                        </div>
                        <div class='event-date'>
                            <h3>" . $event[0]['Event_Date'] . "</h3>
                        </div>
                        
                        <!-- Display all bands partaking -->
                        <div class='band-showcase'>
                            ";

                    foreach ($event as $band) {
                        echo "
                        <div class='band-showcase-item'>
                            <h3 class='band-name'>" . $band['Band_Name'] . "</h3>
                            <h4 class='band-start'>" . $band['Per_Starttime'] . "</h4>
                            <h4 class='band-end'>" . $band['Per_Endtime'] . "</h4>
                         </div>
                        ";
                    }
                    echo "</div></div>";
                 }*/
                 ?>
            </div>-->
        </div>

        <div class="main-item">
            <h2 class="subsection-title" aria-level="2">Experience and Enjoyment:</h2>
            <p class="subsection-text" aria-label="experience and enjoyment text">
                Easy Tiger Patio isn't just about the music; it's about creating a memorable experience for every visitor. With a friendly and attentive staff, comfortable seating, and an inviting ambiance, we strive to make your time with us truly enjoyable. Sit back, relax, and let the music transport you to a place of pure bliss.
            </p>
        </div>

        <div class="main-item">
            <h2 class="subsection-title" aria-level="2">Stay Connected:</h2>
            <p class="subsection-text" aria-label="stay connected text">
                To stay up to date with the latest news, upcoming events, and special offers, join our mailing list or follow us on social media. Don't miss out on the exciting performances and exclusive promotions happening at Easy Tiger Patio.
                <br>
                Join us at Easy Tiger Patio, where music comes alive and memories are made. We look forward to welcoming you to our vibrant music community.
            </p>
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

    <script>
        // Header background
        const background = document.getElementById('header_bg');
        const title = document.getElementById('header_title');

        function fitBackground() {
            const width = title.offsetWidth;
            const height = title.offsetHeight;

            const padding = parseInt(window.getComputedStyle(title).padding);

            background.style.width = `${width - padding}px`;
            background.style.height = `${height - padding}px`;
        }

        window.addEventListener('load', () => {
            fitBackground();
        });

        window.addEventListener('resize', fitBackground);
    </script>
    <script src="./js/nav.js"></script>
</body>
</html>