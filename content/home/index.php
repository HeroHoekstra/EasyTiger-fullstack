<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Easy Tiger Patio</title>

    <!-- Main CSS for nav and footer -->
    <link href="main.css" rel="stylesheet" type="text/css">
    <link href="home.css" rel="stylesheet" type="text/css">
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
                            <a href="#about_us">About us</a>
                        </li>
                        <li class="select-page-section">
                            <a href="#our_events">Our events</a>
                        </li>
                        <li class="select-page-section">
                            Tickets & admission
                        </li>
                        <li class="select-page-section">
                            Experience & enjoyment
                        </li>
                        <li class="select-page-section">
                            Stay connected
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
            <div class="nav-section-select" id="section_up">
                <img src="../../assets/svg/misc/caret-right-fill.svg" alt="Section up">
            </div>

            <div class="nav-section-select" id="section_down">
                <img src="../../assets/svg/misc/caret-right-fill.svg" alt="Section down">
            </div>
        </div>
    </nav>

    <header>
        <div class="header-title-container" id="header-container">
            <div class="header-background" id="header_bg"> </div>
            <h1 class="header-title" id="header_title">
                <b class="company-name">Welcome to EasyTiger Patio:</b>
                Where Music Comes To Life!
            </h1>
        </div>
    </header>

    <main>
        <div class="main-item" id="about_us">

        </div>

        <div class="main-item" id="our_events">

        </div>

        <div class="main-item">

        </div>

        <div class="main-item">

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
        // Nav
        const nav = document.getElementById('nav_bar');
        const shrinkOffset = 100;

        function shrinkNav() {
            if (window.scrollY > shrinkOffset) {
                nav.style.height = '30px';
            } else {
                nav.style.height = '45px';
            }
        }

        window.addEventListener('scroll', shrinkNav);

        shrinkNav();

        // Header background
        const background = document.getElementById('header_bg');
        const title = document.getElementById('header_title');
        const container = document.getElementById('header-container');

        function fitBackground() {
            const width = title.offsetWidth;
            const height = title.offsetHeight;

            const padding = parseInt(window.getComputedStyle(title).padding);
            const margin = parseInt(window.getComputedStyle(container).margin);

            background.style.width = `${parseInt(width - padding)}px`;
            background.style.height = `${parseInt(height - padding)}px`;
            background.style.top = `${padding / 2 + margin}px`;
        }

        window.addEventListener('load', () => {
            fitBackground();
        });

        window.addEventListener('resize', fitBackground);
    </script>
</body>
</html>