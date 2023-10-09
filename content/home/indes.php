<?php
include "../../php/connect.php";

// Get event data
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


    $stmt->closeCursor();
    unset($stmt);
} catch (Exception $e) {
    echo "Error!: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/webp/favicon.webp" type="image/x-icon" rel="icon">
    <title>Easy Tiger Patio</title>

    <!-- Main CSS -->
    <link href="css/style.css" type="text/css" rel="stylesheet">
    <!-- CSS for this page -->
    <link href="css/home.css" type="text/css" rel="stylesheet">
    <!-- CSS for the menu and login menu -->
    <link href="css/menu.css" type="text/css" rel="stylesheet">

    <script src="../../js/theme.js" type="text/javascript"></script>
</head>

<body>
    <nav>
        <!-- Open menu button -->
        <input type="checkbox" id="open_menu">
        <label for="open_menu" aria-label="Open the menu" tabindex="0" class="menu-icon">
            <img src="../../assets/svg/misc/list.svg" alt="Menu button" class="menu-icon">
        </label>

        <!-- Menu and menu content -->
        <div id="menu" class="menu-background">
            <div id="menu_content">
            <!-- Close menu button -->
            <label for="open_menu" aria-label="Close the menu" tabindex="0">
                <img src="../../assets/svg/misc/x-lg.svg" alt="Close menu button" class="menu-close">
            </label>

            <!-- Theme -->
            <input type="checkbox" id="theme">
            <label for="theme" aria-label="Change website theme" tabindex="0">
                <img src="../../assets/svg/theme/brightness-high-fill.svg" id="light_mode">
                <img src="../../assets/svg/theme/moon-stars-fill.svg" id="dark_mode">
            </label>
            </div>
        </div>

        <a href="../admin">admin</a>

        <!-- Login and signup -->
        <input type="checkbox" id="login_button">
        <label for="login_button" class="login" aria-label="Open login menu" tabindex="0">
            <img src="../../assets/svg/user/person-circle.svg" alt="Login button"> Login
        </label>
    </nav>


    <!-- Login menu -->
    <div id="login_menu" class="menu-background" aria-label="Login menu">
        <div id="login_menu_content">
            <!-- Close menu -->
            <button id="login_button" aria-label="Close login menu" tabindex="0">
                <img src="../../assets/svg/misc/x-lg.svg" alt="Close login menu button" class="menu-close">
            </button>
        
            <!-- Logo -->
            <div class="logo">
                <img src="../../assets/webp/tiger%20logo.webp" alt="Easy Tiger logo">
            </div>
        
            <!-- Login form -->
            <form method="post" action="../../php/login.php" class="login-form" id="login" aria-label="Login form">
                <label for="email"><b>Email:</b></label>
                <div class="input">
                    <input type="email" id="email" name="email" required maxlength="320" aria-required="true" aria-label="Email input field">
                    <div class="input-border"></div>
                </div>
        
                <label for="pass"><b>Password:</b></label>
                <div class="input">
                    <input type="password" id="pass" name="pass" required aria-required="true" aria-label="Password input field">
                    <div class="input-border"></div>
                </div>
        
                <input type="submit" name="submit" value="Log in" aria-label="Submit login information button">
            </form>

            <form method="post" action="../../php/login.php" class="login-form" id="sign_up" aria-label="Login form">
                <label for="username"><b>Username:</b></label>
                <div>
                    <input type="text" id="username" name="username" required maxlength="320" aria-required="true" aria-label="username input field">
                    <div class="input-border"></div>
                </div>

                <label for="email"><b>Email:</b></label>
                <div class="input">
                    <input type="email" id="email" name="email" required maxlength="320" aria-required="true" aria-label="Email input field">
                    <div class="input-border"></div>
                </div>

                <label for="pc"><b>Zip code:</b></label>
                <div class="input">
                    <input type="text" id="pc" name="pc" required maxlength="15" aria-required="true" aria-label="zip code input field">
                    <div class="input-border"></div>
                </div>
        
                <label for="pass"><b>Password:</b></label>
                <div class="input">
                    <input type="password" id="pass" name="pass" required aria-required="true" aria-label="Password input field">
                    <div class="input-border"></div>
                </div>

                <label for="pass_con"><b>Confirm Password:</b></label>
                <div class="input">
                    <input type="password" id="pass" name="pass_con" required aria-required="true" aria-label="confirm password input field">
                    <div class="input-border"></div>
                </div>

                <input type="submit" name="submit" value="Sign up" aria-label="Submit login information button">
            </form>
            <button id="switch_login_mode" aria-label="switch to sign up">Don't have an account?</button>
            <script type="text/javascript">
                const butn = document.getElementById('switch_login_mode');
                const login_form = document.getElementById('login');
                const sign_up_form = document.getElementById('sign_up');

                let login = true;
                function set_login_form(login) {
                    login ? login_form.style.display = "grid" : login_form.style.display = "none";
                    login ? sign_up_form.style.display = "none" : sign_up_form.style.display = "grid";
                    login ? butn.innerText = "Don't have an account?" : butn.innerText = "Already have an account?";
                }

                set_login_form(login);

                butn.addEventListener('click', () => {
                    login ? login = false : login = true;
                    set_login_form(login);
                });
            </script>
        </div>
    </div>
  

    <header>
        <div class="title">
          <h1>Welcome to Easy Tiger Patio: Where Music Comes To Life</h1>
          <img src="../../assets/webp/concert.webp" class="title-image" alt="Concert with orange spotlights" aria-label="Concert with orange spotlights">
        </div>
    </header>  

    <main>
        <!-- About us -->
        <div class="subsection" aria-label="about us section">
            <h2 class="subsection-title" aria-level="2">About Us:</h2>
            <p class="subsection-text" aria-label="About Us Text">
              Easy Tiger Patio is a unique cafe and music theater that brings together great music and a cozy atmosphere. We are passionate about hosting unforgettable music nights featuring talented bands from various genres. Our mission is to provide a platform for artists to showcase their skills and for music enthusiasts to immerse themselves in a vibrant and engaging experience.
            </p>
        </div>

        <!-- Our events -->       
        <div class="subsection" aria-label="our events section">
            <h2 class="subsection-title" aria-level="2">Our Events:</h2>
            <p class="subsection-text" aria-label="our events text">
                At Easy Tiger Patio, we curate an exciting lineup of bands and musicians who deliver outstanding performances. From electrifying headlining acts to talented supporting bands, our events cater to diverse musical tastes. On special occasions, we also organize festivals where multiple headlining acts captivate the audience throughout the day or evening.
                <br>
                Join us for a night filled with exceptional live music, energetic performances, and a warm, inviting ambiance. Whether you're a die-hard fan or just looking for a memorable evening out, Easy Tiger Patio is the place to be.
            </p>
        </div>

        <!-- Band showcase -->
        <div class="subsection" aria-label="band showcase section">
            <h2 class="subsection-title" aria-level="2">Band Showcase:</h2>
            <p class="subsection-text" aria-label="band showcase text">
                We take pride in showcasing incredible bands and their unique talents. Get to know the bands that grace our stage, their music genres, origins, and captivating descriptions. You'll find a diverse range of artists, each with their own distinct style and sound.
            </p>
        </div>

        <!-- Tickets and admission -->
        <div class="subsection" aria-label="tickets and admission">
            <h2 class="subsection-title" aria-level="2">Tickets and Admission:</h2>
            <p class="subsection-text" aria-label="tickets and admission text">
                While some of our events offer free admission, many require purchasing tickets to ensure the best experience for our guests. We believe in supporting the artists, and their performances come at a price. Stay tuned for upcoming events and ticket availability, as we bring you the best in live music entertainment.
            </p>
        </div>

        <!-- Experience and enjoyment -->
        <div class="subsection" aria-label="experience and enjoyment">
            <h2 class="subsection-title" aria-level="2">Experience and Enjoyment:</h2>
            <p class="subsection-text" aria-label="experience and enjoyment text">
                Easy Tiger Patio isn't just about the music; it's about creating a memorable experience for every visitor. With a friendly and attentive staff, comfortable seating, and an inviting ambiance, we strive to make your time with us truly enjoyable. Sit back, relax, and let the music transport you to a place of pure bliss.
            </p>
        </div>

        <!-- Future events and prices -->
        <div class="subsection upcoming" aria-label="upcoming events information">
            <div class="upcoming-content">
                <!-- Set these in a for loop in php -->
                <div class="upcoming-event">
                    <h2 class="event-title" aria-level="2">[event title]</h2>
                    <h3 class="event-date">[date]</h3>
                    <h4 class="event-genre">[genre]</h4>
                    <h5 class="tickets-left">There are [amount] tickets left</h5>
                </div>
                <?php
                // Make the events be the correct amount
                $event_ids = array();
                foreach ($result as $event) {
                    if (!in_array($event['Event_id'], $event_ids)) {
                        array_push($event_ids, $event['Event_id']);
                    }
                }

                // Print each event
                $already_added = array();
                foreach ($event_ids as $event_id) {
                    foreach ($result as $event) {
                        if ($event_id == $event['Event_id'] && !in_array($event['Event_id'], $already_added)) {
                            echo "
                            <div class='upcoming-event'>
                                <h2 class='event-title'>" . $event['Event_Name'] . "</h2>
                                <h3 class='event-date'>" . $event['Event_Date'] . "</h3>
                            </div>
                            ";
                            array_push($already_added, $event['Event_id']);
                        }
                    }
                }
                ?>
            </div>
        </div>

        <!-- Stay connected -->
        <div class="subsection" ariab-label="stay connected">
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
        <ul>
            <p><b>Contact us:</b></p>
            <li>Easy Tiger Patio</li>
            <li>123 Main Street, City ville</li>
            <li>Phone: 555-123-4567</li>
            <li>Email: info@easytiger.com</li>
        </ul>

        <!-- Links -->
        <ul class="links">
            <p><b>Follow us:</b></p>
            <li>
            <a href="https://youtu.be/ee6DUqNarek" target="_blank" class="footer-link" tabindex="0" aria-label="Visit our YouTube channel">
                <img src="../../assets/svg/social/youtube.svg" alt="YouTube logo"> Youtube
            </a>
            </li>
            <li>
            <a href="https://twitter.com/KFC_ES" target="_blank" class="footer-link" tabindex="0" aria-label="Visit our Twitter profile">
                <img src="../../assets/svg/social/twitter.svg" alt="Twitter logo"> Twitter
            </a>
            </li>
            <li>
            <a href="https://www.tumblr.com/charlottan/718874362310246400" target="_blank" class="footer-link" tabindex="0" aria-label="Visit our Tumblr blog">
                <img src="../../assets/svg/social/tumblr.svg" alt="Tumblr logo"> Tumblr
            </a>
            </li>
        </ul>

        <!-- Disclaimer -->
        <ul class="disclaimer">
            <li>Terms of Service | Privacy Policy | Copyright © 2023 Easy Tiger Patio</li>
            <li>Disclaimer: This website is a fictional creation for educational purposes only.</li>
        </ul>
    </footer>

    <!-- Get all javascript files -->
    <script src="../../js/a11y.js" type="text/javascript" defer> </script>
    <script src="../../js/menu_animations.js" type="text/javascript" defer> </script>
    <script src="../../js/set_theme.js" type="text/javascript" defer> </script>
</body>
</html>