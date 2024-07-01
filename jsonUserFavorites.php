<?php

$userID = $_GET['userID'];
$eventID = $_GET['eventID'];

if(!file_exists("src/UserData/favorites/".$userID.".json")){
    $userJson = fopen("src/UserData/favorites/".$userID.".json","w");
    fwrite($userJson,"");
    fclose($userJson);
}

$userJson = file_get_contents("src/UserData/favorites/".$userID.".json");
$userData = json_decode($userJson,true);

if(!isset($userData['favorites'])){
    $userData['favorites'] = array();
}

$deleteoradd = array_search($eventID, $userData['favorites']);

if(!($deleteoradd === false)){
    unset($userData['favorites'][$deleteoradd]);
}else{
    array_push($userData['favorites'], $eventID);
}

$jsonData = json_encode($userData, JSON_PRETTY_PRINT);

$userJson = fopen("src/UserData/favorites/".$userID.".json","w");
fwrite($userJson,$jsonData);
fclose($userJson);

echo "success";
