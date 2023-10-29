<?php
// Nom nom yummy cookie 😋
setcookie('login', false, time() + -3600, '/');

header('Location: ' . $_SERVER['HTTP_REFERER']);