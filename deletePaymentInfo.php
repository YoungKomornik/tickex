<?php
$sqlServer = "localhost";
$sqlLogin = "root";
$sqlPassword = "";
$sqlDatabase = "tickex";
$userID = $_POST['userID'];
try {
    $databaseConnection = new mysqli($sqlServer, $sqlLogin, $sqlPassword, $sqlDatabase);
    $deletePayment = "DELETE FROM `paymentinfo` WHERE `AssociatedUser` = ?";
    $statement = $databaseConnection->prepare($deletePayment);
    $statement->bind_param("s", $userID);
    $statement->execute();
    $databaseConnection->commit();
    $databaseConnection->close();
} catch (Exception $exception) {
    $databaseConnection->rollback();
    $databaseConnection->close();
}