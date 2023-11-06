<?php
if (!isset($_COOKIE['login'])) {
    header('Location: ../../user/login');
}

include "../../../php/connect.php";

$stmt = $pdo->prepare('SELECT evenementen.`Entreegeld`, bezoeker.`Bezoeker_id` FROM `evenementen` JOIN bezoeker ON 1=1 WHERE evenementen.`Event_id` = :id AND bezoeker.`Username` = :name');
$stmt->bindParam(':id', $_GET['event_id']);
$stmt->bindParam(':name', $_COOKIE['login']);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt->closeCursor();
unset($stmt);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tickets</title>
    <link href="../../../assets/webp/favicon.webp" rel="icon">

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
            <form action="./response.php" method="post">
                <label>
                    Amount of tickets: <input type="number" name="amount" id="input" value="1" min="1">
                </label>

                <input type="hidden" name="event_id" value="<?php echo $_GET['event_id'] ?>">
                <input type="hidden" name="user_id" value="<?php echo $result[0]['Bezoeker_id'] ?>">
                <input type="submit">
            </form>

            <div>
                <p id="price">Total price: €0</p>
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
<script>
    const display = document.getElementById('price');
    const input = document.getElementById('input');

    const price = <?php echo $result[0]['Entreegeld']; ?>;

    display.innerText = `Total price: €${price * input.value}`

    input.addEventListener('click', () => {
        display.innerText = `Total price: €${price * input.value}`
    });
</script>
</body>
</html>