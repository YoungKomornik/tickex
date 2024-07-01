<?php
session_start();
require_once("cookieCheck.php");

cookieCheck();

$loggedIn = $_SESSION['isLoggedIn'];
$userToken = $_SESSION['sessionLogin'];
$sqlServer = "localhost";
$sqlLogin = "root";
$sqlPassword = "";
$sqlDatabase = "tickex";

$databaseConnection = new mysqli($sqlServer, $sqlLogin, $sqlPassword, $sqlDatabase);

if ($loggedIn) {
    try {
        $databaseConnection->begin_transaction();

        $loginQuery = "SELECT `UserID`, `Login`  FROM `user` WHERE `LoginToken` = ?";
        $statement = $databaseConnection->prepare($loginQuery);
        $statement->bind_param("s", $userToken);
        $statement->execute();
        $loginQueryResult = $statement->get_result();

        if ($loginQueryResult->num_rows < 1) {
            $databaseConnection->rollback();
            $databaseConnection->close();
            header('Location: logout');
            exit();
        }

        $loginQueryResult = $loginQueryResult->fetch_assoc();
        $login = $loginQueryResult['Login'];
        $userID = $loginQueryResult['UserID'];
        $databaseConnection->commit();
    } catch (Exception $exception) {
        $databaseConnection->rollback();
    }
}