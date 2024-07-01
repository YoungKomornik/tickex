<?php
header('Content-Type: application/json');

$sqlServer = "localhost";
$sqlLogin = "root";
$sqlPassword = "";
$sqlDatabase = "tickex";

$databaseConnection = new mysqli($sqlServer, $sqlLogin, $sqlPassword, $sqlDatabase);

$databaseConnection->begin_transaction();

try {
    $sql = "SELECT * FROM events";
    $result = $databaseConnection->query($sql);

    $eventData = array();
    foreach ($result as $row) {
        $eventData[] = array(
            'EventID' => $row['EventID'],
            'EventName' => $row['EventName'],
            'DateOfEvent' => $row['DateOfEvent'],
            'EventCity' => $row['EventCity'],
            'EventPlace' => $row['EventPlace'],
            'AvailabeSpots' => $row['AvailabeSpots'],
            'TicketPrice' => $row['TicketPrice'],
            'Category' => $row['Category'],
            'Description' => $row['Description'],
            'OrganiserContactEmail' => $row['OrganiserContactEmail'],
            'OrganiserContactPhone' => $row['OrganiserContactPhone']
        );
    }

    $databaseConnection->commit();
} catch (Exception $exception) {
    $databaseConnection->rollback();
    throw $exception;
} finally {
    $databaseConnection->close();
}
$correctedEventData = array('data' => $eventData);
$jsonData = json_encode($correctedEventData);

$myfile = fopen("guwno.json", "w") or die("Unable to open file!");
fwrite($myfile, $jsonData);
fclose($myfile);
echo $jsonData;

?>