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

            <br>

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
            <!-- Login -->
            <?php if (!isset($_GET['login']) || $_GET['login'] != 'Sign up') { ?>
                <form method="post" class="login-form" action="./php/login.php">
                    <label class="login-form-item">
                        <h4 class="login-input-context">Username: </h4>
                        <input type="text" name="name" class="login-input" required>
                    </label>
                    <br>
                    <label class="login-form-item">
                        <h4 class="login-input-context">Password: </h4>
                        <input type="password" name="pass" class="login-input" required>
                    </label>
                    <br>

                    <label>
                        <small class="login-input-context remember-me">Remember me:</small>
                        <input type="checkbox" name="remember">
                    </label>
                    <br>

                    <input type="submit" name="login">
                    <br>
                    <small><a href="?login=Sign%20up"><b><i>Don't have an account?</i></b></a></small>
                </form>

            <!-- Sign up -->
            <?php } else { ?>
                <form method="post" class="signup-form" action="./php/signup.php">
                    <!-- Name -->
                    <label class="login-form-item">
                        <h4 class="login-input-context">Username: </h4>
                        <input type="text" name="name" class="login-input"required>
                    </label>
                    <br>

                    <!-- Email -->
                    <label class="login-form-item">
                        <h4 class="login-input-context">Email: </h4>
                        <input type="email" name="email" class="login-input" required>
                    </label>
                    <br>

                    <!-- Postal code -->
                    <label class="login-form-item">
                        <h4 class="login-input-context">Postal code: </h4>
                        <input type="text" name="pc" class="login-input" required>
                    </label>
                    <br>

                    <!-- Pass -->
                    <label class="login-form-item">
                        <h4 class="login-input-context">Password: </h4>
                        <input type="password" name="pass" class="login-input" required>
                    </label>
                    <br>
                    <label class="login-form-item">
                        <h4 class="login-input-context">Confirm password:</h4>
                        <input type="password" name="pass_c" class="login-input" required>
                    </label>

                    <label>
                        <small class="login-input-context remember-me">Remember me:</small>
                        <input type="checkbox" name="remember">
                    </label>
                    <br>
                    <input type="submit" name="signup">
                    <br>

                    <small><a href="?login=Login"><b><i>Already have an account?</i></b></a></small>
                </form>
            <?php } ?>
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
        const input = document.querySelectorAll('.login-input');
        const headers = document.querySelectorAll('.login-input-context');

        for (let i = 0; i < input.length; i++) {
            input[i].addEventListener('input', () => {
                doInput(i);
            });

            doInput(i);
        }

        function doInput(i) {
            if (input[i].value.length !== 0) {
                headers[i].style.display = 'none';
            } else {
                headers[i].style.display = 'block';
            }
        }
    </script>
</body>
</html>
