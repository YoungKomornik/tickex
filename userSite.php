<?php
session_start();
require_once("cookieCheck.php");

cookieCheck();

$loggedIn = $_SESSION['isLoggedIn'];
$userToken = $_SESSION['sessionLogin'];

if (!$loggedIn) {
  header('Location: login.php');
  exit();
}

$sqlServer = "localhost";
$sqlLogin = "root";
$sqlPassword = "";
$sqlDatabase = "tickex";

$databaseConnection = new mysqli($sqlServer, $sqlLogin, $sqlPassword, $sqlDatabase);

$query = "SELECT `Login`, `Email`, `UserID` FROM `user` WHERE `LoginToken` = ?";
$statement = $databaseConnection->prepare($query);
$statement->bind_param("s", $userToken);
$statement->execute();
$queryResult = $statement->get_result();

if ($queryResult->num_rows < 1) {
  header('Location: logout.php');
  exit();
}

$userDataReturned = $queryResult->fetch_assoc();
$login = $userDataReturned['Login'];
$userEmail = $userDataReturned['Email'];
$userID = $userDataReturned['UserID'];

$infoQuery = "SELECT * FROM `personalinfo` WHERE `AssociatedUser` = ?";
$statement = $databaseConnection->prepare($infoQuery);
$statement->bind_param("i", $userID);
$statement->execute();
$infoQueryResult = $statement->get_result();
$infoDataReturned = $infoQueryResult->fetch_assoc();

foreach ($infoDataReturned as $key => $result) {
  if ($result == NULL) {
    $infoDataReturned[$key] = "Nie ustawiono";
  }
}

$userName = $infoDataReturned['Name'];
$userSurname = $infoDataReturned['Surname'];
$userPhone = $infoDataReturned['PhoneNumber'];
$userAddress = $infoDataReturned['Address'];
$userAvatar = $infoDataReturned['Avatar'];
$userCreationDate = $infoDataReturned['CreationDate'];

$statement->close();

$eventQuery = 'SELECT `EventID`,`EventName` FROM `events`';

$eventQueryResult = $databaseConnection->query($eventQuery);

$events = [];

while ($event = $eventQueryResult->fetch_assoc()) {
  array_push($events, $event);
}

$tickets = [];
$ticketQuery = 'SELECT `EventID`, `TicketCode` FROM `tickets` WHERE `UserWhoBought` = ?';
$ticketStatement = $databaseConnection->prepare($ticketQuery);
$ticketStatement->bind_param('s', $userID);
$ticketStatement->execute();
$ticketQueryResult = $ticketStatement->get_result();
while ($ticket = $ticketQueryResult->fetch_assoc()) {
  array_push($tickets, $ticket);
}
$databaseConnection->close();

if (file_exists("src/UserData/favorites/" . $userID . ".json")) {
  $favoritesJson = file_get_contents("src/UserData/favorites/" . $userID . ".json");
  $favoritesArray = json_decode($favoritesJson, true);
  $favorites = $favoritesArray['favorites'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Strona użytkownika</title>

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/userstyles.css">
</head>
<style>
  .btn.btn-dark.btn-block.btn-lg {
    background-color: #fff200;
    color: black
  }

  .profile-pic img {
    max-width: 100px;
    max-height: 100px;
  }

  .card.mb-4 {
    height: 395px;

  }

  .img-fluid {
    margin-bottom: 10px;
  }

  @media (max-width: 768px) {
    .img-fluid {
      height: 75px;
      margin-bottom: 0px;
    }
  }

  .card-title {
    color: #fff200;
  }

  .card-body.text-center {
    overflow-y: scroll;
  }
</style>

<body data-bs-theme="dark">
  <script src="js/bootstrap.bundle.js"></script>
  <script src="js/jquery-3.7.0.min.js"></script>
  <?php
  require_once("navbar.php");
  ?>
  <section style="background-color: #181818;">
    <div class="container py-5">
      <div class="row d-flex">

      </div>

      <div class="row shadow-lg  mb-5 card-body p-0 rounded-5">
        <div class="col-lg-4">
          <div class="card mb-4">
            <div class="card-body text-center">
              <div class="profile-pic">
                <label class="-label" for="file">
                  <span class="glyphicon glyphicon-camera"></span>
                  <span>Change Image</span>
                </label>
                <input id="file" type="file" onchange="changeAvatar(event)" />
                <img src="./<?= $userAvatar ?>" id="output" width="200" />
              </div>
              <h5 class="my-3">
                <?= $login ?>
              </h5>
              <p class=" mb-1">Data założenia konta</p>
              <p class=" mb-4">
                <?= $userCreationDate ?>
              </p>
              <div class="d-flex justify-content-center mb-2">
                <a class="btn btn-dark btn-block btn-lg" data-mdb-ripple-color="dark" style="background-color:#fff200;color:black" role="button" aria-disabled="true" href="logout.php">Wyloguj</a>
              </div>
            </div>

          </div>

        </div>
        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-body" style="color:white">
              <div id="name" class="row">
                <div class="col-sm-3" style="color:#fff200;">
                  <p class="mb-0">Imię</p>
                </div>
                <div class="col-sm-8">
                  <p class="mb-0">
                    <?= $userName ?>
                  </p>
                </div>
                <div class="col-sm-1">
                  <button id="nameButton" type="button" class="btn btn-link" onclick="edit('name')" edit="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff200" class="bi bi-pencil-square" viewBox="0 0 16 16">
                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                    </svg>
                  </button>
                </div>
              </div>
              <hr>
              <div id="surname" class="row">
                <div class="col-sm-3" style="color:#fff200;">
                  <p class="mb-0">Nazwisko</p>
                </div>
                <div class="col-sm-8">
                  <p class="mb-0">
                    <?= $userSurname ?>
                  </p>
                </div>
                <div class="col-sm-1">
                  <button id="surnameButton" type="button" class="btn btn-link" onclick="edit('surname')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff200" class="bi bi-pencil-square" viewBox="0 0 16 16">
                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                    </svg>
                  </button>
                </div>
              </div>
              <hr>
              <div id="email" class="row">
                <div class="col-sm-3" style="color:#fff200;">
                  <p class="mb-0">E-mail</p>
                </div>
                <div class="col-sm-8">
                  <p class=" mb-0">
                    <?= $userEmail ?>
                  </p>
                </div>
                <div class="col-sm-1">
                  <button id="emailButton" type="button" class="btn btn-link" onclick="edit('email')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff200" class="bi bi-pencil-square" viewBox="0 0 16 16">
                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                    </svg>
                  </button>
                </div>
              </div>
              <hr>
              <div id="mobile" class="row">
                <div class="col-sm-3" style="color:#fff200;">
                  <p class="mb-0">Telefon</p>
                </div>
                <div class="col-sm-8">
                  <p class=" mb-0">
                    <?= $userPhone ?>
                  </p>
                </div>
                <div class="col-sm-1">
                  <button id="mobileButton" type="button" class="btn btn-link" onclick="edit('mobile')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff200" class="bi bi-pencil-square" viewBox="0 0 16 16">
                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                    </svg>
                  </button>
                </div>
              </div>
              <hr>
              <div id="address" class="row">
                <div class="col-sm-3" style="color:#fff200;">
                  <p class="mb-0">Adres Zamieszkania</p>
                  <br>
                </div>

                <div class="col-sm-8">
                  <p class="mb-0">
                    <?= $userAddress ?>
                  </p>
                </div>
                <div class="col-sm-1">
                  <button id="addressButton" type="button" class="btn btn-link" onclick="edit('address')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff200" class="bi bi-pencil-square" viewBox="0 0 16 16">
                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>


          <div class="row d-flex">
            <div class="col-md-6">
              <div class="card mb-4">
                <div class="card-body text-center">
                  <h5 class="card-title">Ulubione</h5>
                  <hr>
                  <?php
                  if (isset($favorites)) {
                    foreach ($favorites as $favorite) {
                      foreach ($events as $event) {
                        if ($event['EventID'] === $favorite) {
                          $eventID = $event['EventID'];
                          $eventName = $event['EventName'];
                        }
                      }
                  ?>
                      <div class="row align-items-center">
                        <div class="col-md-4">
                          <img src="src/EventImages/<?= $eventID ?>.webp" class="img-fluid" alt="Favorite Image">
                        </div>
                        <div class="col-md-8">
                          <p><?= $eventName ?></p>
                        </div>
                      </div>
                      <hr>
                  <?php
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card mb-4">
                <div class="card-body text-center">
                  <h5 class="card-title">Bilety</h5>
                  <hr>
                  <?php
                  if (!empty($tickets)) {
                    foreach ($tickets as $ticket) {
                      foreach ($events as $event) {
                        if (intval($event['EventID']) === $ticket['EventID']) {

                          $eventID = $event['EventID'];
                          $eventName = $event['EventName'];
                        }
                      }
                  ?>

                      <div class="row align-items-center">
                        <div class="col-md-4">
                          <img src="src/EventImages/<?= $eventID ?>.webp" class="img-fluid" alt="Favorite Image">
                        </div>
                        <div class="col-md-8">
                          <p><?= $eventName ?></p>
                          <p class="censor"><?= $ticket['TicketCode'] ?></p>
                          <button class="btn btn-dark btn-block btn-lg censor-btn">Odkryj</button>
                        </div>
                      </div>
                      <hr>
                  <?php
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
  </section>
  <script>
    function changeAvatar(event) {
      const xhttp = new XMLHttpRequest();
      var avatar = event.target.files[0];

      xhttp.onload = function() {
        response = this.response;
        if (response == 'success') {
          window.location.reload();
        } else {
          var error = document.createElement('div');
          var body = $(`body`);
          error.setAttribute('class', "alert alert-danger position-absolute top-1 start-50 translate-middle-x")
          error.setAttribute('role', 'alert')
          error.setAttribute('aria-live', 'assertive')
          error.setAttribute('aria-atomic', 'true')
          error.setAttribute('style', 'z-index: 1000; top: 1%;')
          error.innerHTML = "<div class=\"toast-body\">Nie udało się zmienić zdjęcia profilowego, spróbuj ponownie puźniej.</div>"
          document.body.insertBefore(error, document.body.firstChild)
        }
      }

      var params = new FormData();

      params.append('value', avatar);
      params.append('id', 'avatar');
      params.append('userID', '<?= $userID ?>')

      xhttp.open("POST", "updateUserInfo.php", true)
      xhttp.send(params);
    }

    function edit(id) {
      var button = document.getElementById(`${id}Button`);
      if (button.getAttribute("edit") == "true") {
        button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff200" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" /><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" /></svg>'
        button.setAttribute("edit", false);
        var input = $(`#${id}Input`)[0].value

        if (input == "") {
          window.location.reload()
        }

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
          response = this.responseText;
          console.log(response);
          if (response == "error") {
            $(`#${id} .col-sm-8`)[0].innerHTML = "Wystąpił błąd!";
          } else {
            window.location.reload();
          }
        }

        var params = new FormData();

        params.append('value', input);
        params.append('id', $id);
        params.append('userID', "<?= $userID ?>");

        xhttp.open("POST", "updateUserInfo.php", true)
        xhttp.send(params);
      } else {
        button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff200" class="bi bi-check-square" viewBox="0 0 16 16"><path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/><path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/></svg>'
        button.setAttribute("edit", true);
        $(`#${id} .col-sm-8`)[0].innerHTML = `<input id="${id}Input" class="form-control" type="text" placeholder="Edytuj">`;
      }
    }
    $(document).ready(function() {
      $('.censor').each(function() {
        var textElement = $(this);
        var text = textElement.text();
        var censoredText = text.replace(/\S/g, '*'); // Replace each character with an asterisk
        textElement.text(censoredText);
        textElement.data('censored', true);
        textElement.data('originalText', text);
      });

      // Toggle censoring and uncensoring on button click
      $('.censor-btn').click(function() {
        var parentDiv = $(this).parent();
        var textElement = parentDiv.find('.censor');
        var text = textElement.text();
        if (textElement.data('censored')) {
          var uncensoredText = textElement.data('originalText');
          textElement.text(uncensoredText);
          textElement.data('censored', false);
        } else {
          var censoredText = text.replace(/\S/g, '*');
          textElement.text(censoredText);
          textElement.data('censored', true);
          textElement.data('originalText', text);
        }
      });
    });
  </script>
  <?php
  require_once("footer.php");
  ?>
</body>

</html>