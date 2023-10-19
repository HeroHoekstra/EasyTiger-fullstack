<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        <?php
        if (isset($_GET['login'])) {
            echo $_GET['login'];
        } else {
            echo "Login";
        }
        ?>
    </title>
    <!-- Favicon -->
    <link href="../../../assets/webp/favicon.webp" rel="icon">

    <!-- Stylesheets -->
    <link href="../../generic/main.css" rel="stylesheet" type="text/css">
    <link href="./login.css" rel="stylesheet" type="text/css">
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
                            <a href="../../home/index.php#item_1">About us</a>
                        </li>
                        <li class="select-page-section">
                            <a href="../../home/index.php#item_2">Our events</a>
                        </li>
                        <li class="select-page-section">
                            <a href="../../home/index.php#item_3">Tickets & admission</a>
                        </li>
                        <li class="select-page-section">
                            <a href="../../home/index.php#item_4">Experience & enjoyment</a>
                        </li>
                        <li class="select-page-section">
                            <a href="../../home/index.php#item_5">Stay connected</a>
                        </li>
                    </ul>
                </div>
                <a href="#" class="nav-anchor home-button" tabindex="0">
                    <label for="stay_opened">
                        Home <!-- Page title -->
                        <img src="../../../assets/svg/misc/caret-right-fill.svg" alt="arrow" class="img-arrow">
                    </label>
                </a>
            </div>
        </div>
    </nav>

    <main>
        <div class="main-item">
            <form method="post" class="login-form">
                <label class="login-form-item">
                    <h4 class="login-input-context">Email: </h4>
                    <input type="text" name="email" class="login-input">
                </label>
                <br>
                <label class="login-form-item">
                    <h4 class="login-input-context">Password: </h4>
                    <input type="password" name="pass" class="login-input">
                </label>
                <br>

                <input type="submit" name="login">
                <br>
                <small><a href="?login=Sign up"><b><i>Don't have an account?</i></b></a></small>
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
</body>
</html>
