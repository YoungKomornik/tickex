<?php
require_once("loginProcedure.php");
if (!isset($_GET['id'])) {
    http_response_code(404);
    include('404.php');
    die();
}

$eventID = $_GET['id'];

try {
    $databaseConnection->begin_transaction();

    $eventQuery = "SELECT * FROM `events` WHERE `EventID` = ?";
    $statement = $databaseConnection->prepare($eventQuery);
    $statement->bind_param("s", $eventID);
    $statement->execute();
    $eventQueryResult = $statement->get_result();

    if ($eventQueryResult->num_rows < 1) {
        $databaseConnection->rollback();
        $databaseConnection->close();
        http_response_code(404);
        include('404.php');
        die();
    }

    $EventDataReturned = $eventQueryResult->fetch_assoc();

    $databaseConnection->commit();
    $databaseConnection->close();
} catch (Exception $exception) {
    $databaseConnection->rollback();
    $databaseConnection->close();
}

$isFavorite = false;
if ($loggedIn) {
    if (file_exists("src/UserData/favorites/" . $userID . ".json")) {
        $userJson = file_get_contents("src/UserData/favorites/" . $userID . ".json");
        $userData = json_decode($userJson, true);
        $checkFavorite = array_search($eventID, $userData['favorites']);
        if ($checkFavorite === false) {
            $isFavorite = false;
        } else {
            $isFavorite = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TickEX -
        <?= $EventDataReturned['EventName'] ?>
    </title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/eventstyles.css">
    <style>
    </style>
</head>

<body data-bs-theme="dark">
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/jquery-3.7.0.min.js"></script>
    <?php
    require_once("navbar.php");
    ?>
    <div class="col-lg-12 bg-grey shadow-lg mb-5 card-body p-0 rounded-5">
        <div class="content-wrapper">
            <img src="data:image/webp;base64, <?= base64_encode(file_get_contents("src/EventImages/" . $eventID . ".webp")); ?>"
                class="rounded-5" id="zdjevent">
            <div class="content-div col-lg-4 bg-grey shadow-lg mb-5 card-body p-0 rounded-5">
                <div class="p-5">
                    <div class="container mb-5 mt-2 pt-1">
                        <div class="row">
                            <div class="col">
                                <h3 class="fw-bold">
                                    <?= $EventDataReturned['EventName'] ?>
                                </h3>
                            </div>
                            <div class="col col-lg-2">
                                <?php
                                if ($isFavorite) {
                                    echo '<button type="button" class="btn" onclick="favorite(' . $eventID . ')" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Usuń z ulubionych">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#fff200" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                            </svg>
                                          </button>';
                                } else {
                                    echo '<button type="button" class="btn" onclick="favorite(' . $eventID . ')" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-custom-class="custom-tooltip" data-bs-title="Dodaj do ulubionych">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#fff200" class="bi bi-star" viewBox="0 0 16 16">
                                                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
                                            </svg>
                                          </button>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="d-flex justify-content-between mb-4">
                        <h5 class="text-uppercase">
                            <?= $EventDataReturned['DateOfEvent'] ?>
                        </h5>
                    </div>
                    <h5 class="text-uppercase mb-3 zolte">Lokalizacja:</h5>
                    <h6 class="text-uppercase mb-3">
                        <?= $EventDataReturned['EventCity'] . ", " . $EventDataReturned['EventPlace'] ?>
                    </h6>
                    <h5 class="text-uppercase mb-3 zolte">Infromacje o wydarzeniu: </h5>
                    <h7 class="text-uppercase mb-3">
                        <?= $EventDataReturned['Description'] ?>
                    </h7>
                    <br>
                    <br>
                    <h5 class="text-uppercase mb-3">Cena biletów:
                        <?= $EventDataReturned['TicketPrice'] . ".00zł" ?>
                    </h5>
                    <h5 class="text-uppercase mb-3 zolte">Kontakt</h5>
                    <h7>E-mail:
                        <?= $EventDataReturned['OrganiserContactEmail'] ?><br>Telefon:
                        <?= $EventDataReturned['OrganiserContactPhone'] ?>
                    </h7>
                    <br>
                    <hr>
                    <h7 class="text-uppercase mb-3">Jest możliwość opcji rezerwacji. Można ją wybrać w koszyku. Wtedy
                        płatność za bilet odbywa się na wydarzeniu.</h7>
                    <hr class="my-4">
                    <button type="button" class="btn btn-block btn-lg btn-color" data-mdb-ripple-color="dark"
                        onClick="location.href='cart?id=<?= $eventID ?>';">Kup Bilet</button>
                    <div class=" pt-5">
                        <h6 class="mb-0"><a href="./" class="text-white"><i
                                    class="fas fa-long-arrow-alt-left me-2"></i>Powrót do strony głównej</a></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once("footer.php");
    ?>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

        function favorite(eventID) {
            loggedIn = <?php
            if ($loggedIn) {
                echo "true";
            } else {
                echo "false";
            }
            ?>;
            if (!loggedIn) {
                var error = document.createElement('div');
                var body = $(`body`);
                error.setAttribute('class', "alert alert-danger position-fixed start-50 translate-middle-x");
                error.setAttribute('role', 'alert');
                error.setAttribute('aria-live', 'assertive');
                error.setAttribute('aria-atomic', 'true');
                error.setAttribute('style', 'z-index: 1000; top: 1%;');
                error.innerHTML = "<div class=\"toast-body\">Musisz być zalogowany aby polubić wydarzenie!</div>";
                document.body.insertBefore(error, document.body.firstChild);
                return;
            }
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function () {
                response = this.response;
                if (response == 'success') {
                    window.location.reload();
                } else {
                    var error = document.createElement('div');
                    var body = $(`body`);
                    error.setAttribute('class', "alert alert-danger position-fixed start-50 translate-middle-x");
                    error.setAttribute('role', 'alert');
                    error.setAttribute('aria-live', 'assertive');
                    error.setAttribute('aria-atomic', 'true');
                    error.setAttribute('style', 'z-index: 1000; top: 1%;');
                    error.innerHTML = "<div class=\"toast-body\">Wystąpił błąd, proszę spróbować puźniej.</div>";
                    document.body.insertBefore(error, document.body.firstChild);
                    console.log(response);
                }
            }
            xhttp.open("GET", "jsonUserFavorites.php?userID=<?php
            if (!$loggedIn) {
                echo "";
            } else {
                echo $userID;
            }
            ?>& eventID=" + eventID);
            xhttp.send();
        }
    </script>
</body>

</html>