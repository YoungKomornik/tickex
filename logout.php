<?php
session_start();

unset($_COOKIE['rememberUser']);

setcookie('rememberUser', null, 1, "/", "", true, true);

unset($_SESSION['sessionLogin']);

unset($_SESSION['isLoggedIn']);

session_regenerate_id(true);

header('Location: ./');