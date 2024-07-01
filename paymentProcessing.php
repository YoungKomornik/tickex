<?php
require_once("loginProcedure.php");
function generateRandomString($length = 20)
{
    return substr(str_shuffle(str_repeat($x = '!@#$%&0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}
try {
    $userID = $_POST['UserID'];
    $eventID = $_POST['EventID'];
    $typeOfTransaction = $_POST['TypeOfTransaction'];
    $priceOfTransaction = $_POST['PriceOfTransaction'];
    $singleTicketsBought = $_POST['SingleTicketsBought'];
    $ticketCode = generateRandomString();
    $databaseConnection->begin_transaction();
    $paymentQuery = "SELECT `CardNumber`, `CardExpireDate`, `CardCVV`, `CardMiscDetails` FROM `paymentinfo` WHERE `AssociatedUser` = ?";
    $userQuery = "SELECT `Email` FROM `user` WHERE `UserID` = ?";
    $statement = $databaseConnection->prepare($paymentQuery);
    $statement->bind_param("s", $userID);
    $statement->execute();
    $paymentQueryResult = $statement->get_result();
    $rowCount = $paymentQueryResult->num_rows;
    if ($rowCount === 0) {
        $insertPaymentQuery = "INSERT INTO `paymentinfo` (`AssociatedUser`, `CardNumber`, `CardExpireDate`, `CardCVV`, `CardMiscDetails`) VALUES (?,?,?,?,?)";
        $statement2 = $databaseConnection->prepare($insertPaymentQuery);
        $statement2->bind_param("iisis", $userID, $_POST['formControlCardNumber'], $_POST['formControlExpiry'], $_POST['formControlCVV'], $_POST['formControlMiscDetails']);
        $statement2->execute();
    }

    $ticketQuery = "INSERT INTO `tickets` (`UserWhoBought`, `EventID`, `TypeOfTransaction`,`TransactionPrice`,`SingleTicketsBought`,`TicketCode`) VALUES (?,?,?,?,?,?)";
    $statement3 = $databaseConnection->prepare($ticketQuery);
    $statement3->bind_param("ssssss", $userID, $eventID, $typeOfTransaction, $priceOfTransaction, $singleTicketsBought, $ticketCode);
    $statement3->execute();

    $databaseConnection->commit();
    $databaseConnection->close();
} catch (Exception $exception) {
    $databaseConnection->rollback();
    $databaseConnection->close();
}
header("location: userSite");
