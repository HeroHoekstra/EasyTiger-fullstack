<?php
ob_start();

require('./to_json.php');

session_start();
$bands = $_SESSION['bands'];

ob_end_clean();

header('Content-Type: text/html');
?>

<!DOCTYPE html>
<html lang="en">
    <!-- This needs WAY more css btw -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <!-- Main CSS -->
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <!-- Main layout -->
    <!-- And maybe some other small misc items -->
    <link href="./css/layout.css" rel="stylesheet" type="text/css">
    <!-- Buttons -->
    <link href="./css/buttons.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php
    if (isset($_COOKIE['succ'])) {
        $msg = $_COOKIE['succ'];
        $col = 'succ_msg';
    } else if (isset($_COOKIE['err'])) {
        $msg = $_COOKIE['err'];
        $col = 'err_msg';
    }

    if (isset($_COOKIE['succ']) || isset($_COOKIE['err'])) {
        echo "<div class=\"message " . $col . "\"> " . $msg . " </div>";
    }
    ?>   

    <main>
        <!-- Add band menu -->
        <div class="add_band">
            <input type="checkbox" id="open_band_menu" class="open_menu_button">
            <label for="open_band_menu" aria-label="Open create band menu" tabindex="0">
                <h1 class="open_menu_text">Create a new band <img src="../assets/svg/misc/caret-right.svg" alt="open menu button" class="open_menu_img"></h1>
            </label>

            <div class="menu_content menu_openable">
                <form action="./php/add_band.php" method="post">
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
                                    <img src="../assets/svg/misc/plus-circle.svg" alt="add button">
                                </label>
                                <input type="checkbox" id="remove_people_0" class="remove_item">
                                <label for="remove_people_0" aria-label="Remove a person to band list" tabindex="0">
                                    <img src="../assets/svg/misc/dash-circle.svg" alt="remove button">
                                </label>
                                <input type="checkbox" id="open_band_member_menu" class="open_menu_button open_band_member_menu">
                                <label for="open_band_member_menu" aria-label="Open create band menu" tabindex="0">
                                    <img src="../assets/svg/misc/caret-right.svg" alt="open menu button" class="open_menu_member_img open_menu_img">
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

        <!-- Edit band menu -->
        <div class="edit_band">
            <input type="checkbox" id="open_edit_band_menu" class="open_menu_button">
            <label for="open_edit_band_menu" aria-label="Open edit band menu" tabindex="0">
                <h1 class="open_menu_text">Edit existing band <img src="../assets/svg/misc/caret-right.svg" alt="open menu button" class="open_menu_img"></h1>
            </label>

            <div class="menu_content menu_openable">
                <!-- Select band -->
                <ul>
                    <h3>Select band:</h3>
                    <small class="found_display"></small>
                    <br>
                    <input type="text" class="search" aria-label="Search band by name" tabindex="0" autocomplete="off">
                </ul>

                <div id="band_edit">
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
                            <p class=\"edit\">[Edit]</p>
                        </div>
                        ";
                    }
                    ?>
                </div>

                <!-- Edit band -->
                <form action="./php/edit_band.php" method="post" id="edit_band_members">
                    <ul>
                        <li>
                            <h3 class="item_title">Band name:</h3>
                            <input type="text" value="Band name" name="band_name" aria-label="Textbox for the bands name" tabindex="0" maxlength="250" required>
                        </li>
                        <li>
                            <h3 class="item_title">Genre:</h3>
                            <input type="text" value="Genre" name="genre" aria-label="Textbox for band genre" tabindex="0" maxlength="250" required>
                        </li>
                        <li>
                            <h3 class="item_title">Origin:</h3>
                            <input type="text" value="Origin" name="origin" aria-label="Textbox for band origin" tabindex="0" maxlength="250" required>
                        </li>
                        <li>
                            <h3 class="item_title">Description:</h3>
                            <textarea Value="Desc" name="desc" aria-label="Bigger textbox for band discription" tabindex="0" maxlength="65535" required></textarea>
                        </li>
                        <br>

                        <li>
                            <div class="add_people">
                                <h3 class="item_title">Add person to band list</h3>
                                <input type="checkbox" id="add_people_edit" class="add_item">
                                <label for="add_people_edit" aria-label="Add a person to band list" tabindex="0">
                                    <img src="../assets/svg/misc/plus-circle.svg" alt="add button">
                                </label>
                                <input type="checkbox" id="remove_people_1" class="remove_item">
                                <label for="remove_people_1" aria-label="Remove a person to band list" tabindex="0">
                                    <img src="../assets/svg/misc/dash-circle.svg" alt="remove button">
                                </label>
                                <input type="checkbox" id="open_band_member_menu_edit" class="open_menu_button open_band_member_menu">
                                <label for="open_band_member_menu_edit" aria-label="Open create band menu" tabindex="0">
                                    <img src="../assets/svg/misc/caret-right.svg" alt="open menu button" class="open_menu_member_img open_menu_img">
                                </label>
                            </div>
                            <ul class="people menu_openable">

                            </ul>
                            <input type="hidden" name="band_id" id="edit_band_id">
                        </li>

                        <br>

                        <input type="submit" name="edit_band" value="Edit Band" aria-label="Add band to database">
                        <p class="cancel_edit">[Cancel]</p>
                    </ul>
                </form>
            </div>
        </div>

        <!-- Add event menu -->
        <div class="add_event">
            <input type="checkbox" id="open_add_event_menu" class="open_menu_button">
            <label for="open_add_event_menu" aria-label="Open create new event menu" tabindex="0">
                <h1 class="open_menu_text">Add event <img src="../assets/svg/misc/caret-right.svg" alt="open menu button" class="open_menu_img"></h1>
            </label>

            <div class="menu_content menu_openable">
                <form action="./php/add_event.php" method="post">
                    <ul>
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

                            <div id="band_add">
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
                                        <p class=\"add edit\">[add]</p>
                                    </div>
                                    ";
                                }
                                ?>
                            </div>
                        </li>
                        <li>
                            <div id="added_bands">

                            </div>
                        </li>
                    </ul>

                    <input type="submit" name="add_event" value="Add event" aria-label="Submit the event to the database">
                </form>
            </div>
        </div>

        <div class="edit_event">
            <input type="checkbox" id="open_edit_event" class="open_menu_button">
            <label for="open_edit_event" aria-label="Open create edit event menu" tabindex="0">
                <h1 class="open_menu_text">Edit existing event <img src="../assets/svg/misc/caret-right.svg" alt="open menu button" class="open_menu_img"></h1>
            </label>

            <div class="menu_content menu_openable">
                <form action="#" method="post">
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
                                foreach ($bands as $band) {
                                    echo "
                                    <div class=\"edit_band_band\" data-band_id=\"" . $band['Band_id'] . "\">
                                        <p class=\"band_title\" data-name=\"" . $band['Naam'] . "\"><b>" . $band['Naam'] . "</b></p>
                                        <ul class=\"band_attributes\">
                                            <li>Genre: " . $band['Genre'] . "</li>
                                            <li>Origin: " . $band['Herkomst'] . "</li>
                                            <li>" . count($band['members']) . " band members</li>
                                        </ul>
                                        <p class=\"add edit\">[add]</p>
                                    </div>
                                    ";
                                }
                                ?>
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </main>

    <!-- main.js does misc stuff -->
    <script src="./js/main.js"></script>
    <!-- get_band.js and change_values.js provide values to main.js -->
    <script src="./js/get_bands.js"></script>
    <script src="./js/change_values.js"></script>
    <!-- Script for accessibility -->
    <script src="../js/a11y.js"></script>
</body>
</html>