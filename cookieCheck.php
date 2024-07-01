<?php

function cookieCheck()
{
    if (isset($_COOKIE['rememberUser']) && !empty($_COOKIE['rememberUser'])) {
        $rememberUser = $_COOKIE['rememberUser'];
        $_SESSION['sessionLogin'] = $rememberUser;
        $_SESSION['isLoggedIn'] = true;
    }

    if (!isset($_SESSION['isLoggedIn'])) {
        $_SESSION['isLoggedIn'] = false;
        $_SESSION['sessionLogin'] = null;
    }
}