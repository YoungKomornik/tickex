<?php
$id = $_POST['id'];
$id = ucfirst($id);
if ($id == 'Avatar') {
    $value = $_FILES['value'];
} else {
    $value = $_POST['value'];
}
$userID = $_POST['userID'];

$sqlServer = "localhost";
$sqlLogin = "root";
$sqlPassword = "";
$sqlDatabase = "tickex";

$databaseConnection = new mysqli($sqlServer, $sqlLogin, $sqlPassword, $sqlDatabase);

if ($id == "Email") {
    $query = "UPDATE `user` SET `Email` = ? WHERE `user`.`UserID` = ?";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param("si", $value, $userID);
} else if ($id == 'Avatar') {
    if (!(substr($value['type'], 0, 5) === "image")) {
        echo "error";
        die();
    }
    $fileType = explode('/', $value['type']);
    $avatarPath = "src/userData/avatars/" . $userID . "." . $fileType[1];
    move_uploaded_file($value['tmp_name'], $avatarPath);

    $query = "UPDATE `personalinfo` SET `Avatar` = ? WHERE `personalinfo`.`AssociatedUser` = ?";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param("si", $avatarPath, $userID);
} else {
    $query = "UPDATE `personalinfo` SET `" . $id . "` = ? WHERE `personalinfo`.`AssociatedUser` = ?";
    $statement = $databaseConnection->prepare($query);
    $statement->bind_param("si", $value, $userID);
}

$databaseConnection->begin_transaction();

if ($statement->execute()) {
    $databaseConnection->commit();
    echo "success";
} else {
    $databaseConnection->rollback();
    echo "error";
}

$statement->close();
$databaseConnection->close();
