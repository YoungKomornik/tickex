<?php
require_once("loginProcedure.php");
if (!isset($_GET['id'])) {
  http_response_code(404);
  include('404.php');
  die();
}
if (!($loggedIn)) {
  header("location: ./");
}
$eventID = $_GET['id'];

try {
  $databaseConnection->begin_transaction();

  $eventQuery = "SELECT `EventName`, `EventCity`, `EventPlace`, `TicketPrice` FROM `events` WHERE `EventID` = ?";
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

  $tokenQuery = "SELECT `UserID` FROM `user` WHERE `LoginToken` = ?";
  $statement = $databaseConnection->prepare($tokenQuery);
  $statement->bind_param("s", $userToken);
  $statement->execute();
  $tokenQueryResult = $statement->get_result();

  $userIDReturned = $tokenQueryResult->fetch_assoc();
  $databaseConnection->commit();
  $databaseConnection->close();
} catch (Exception $exception) {
  $databaseConnection->rollback();
  $databaseConnection->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TickEX - Koszyk</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/cartstyles.css">
</head>
<style>
  @media (max-width: 767px) {
    .main {
      width: 100%;
      margin-left: -10%;
    }
  }
</style>


<body data-bs-theme="dark">
  <script src="js/bootstrap.bundle.js"></script>
  <script src="js/jquery-3.7.0.min.js"></script>
  <?php
  require_once("navbar.php");
  ?>

  <div class="main">
    <section class="h-100 h-custom szary1">
      <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12">
            <div>
              <div class="shadow-lg  mb-5 card-body p-0 rounded-5 szary2">
                <div class="row g-0">
                  <div class="col-lg-8">
                    <div class="p-3">
                      <div class="d-flex justify-content-between align-items-center mb-5">
                        <h1 class="fw-bold mb-0 zolty">Twoje bilety</h1>
                      </div>
                      <hr class="my-4">

                      <div class="row mb-4 d-flex justify-content-between align-items-center">
                        <div class="col-md-2 col-lg-2 col-xl-2">
                          <img src="data:image/webp;base64, <?= base64_encode(file_get_contents("src/EventImages/" . $eventID . ".webp"));  ?>" class="img-fluid rounded-3">
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-3">
                          <br>
                          <h6><?php echo $EventDataReturned['EventName']; ?></h6>
                          <br>
                          <h6 class=" mb-0"><?= $EventDataReturned['EventCity'] ?></h6>
                          <br>
                          <h6 class=" mb-0"><?= $EventDataReturned['EventPlace'] ?></h6>
                          <br>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                          <input id="TicketAmount" name="TicketQuantity" min="0" value="1" type="number" class="form-control form-control-sm" />
                        </div>
                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                          <br>
                          <h6 class="mb-0"><?= $EventDataReturned['TicketPrice'] . ".00 zł" ?></h6>
                        </div>
                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                          <a href="#!" class="text-muted"><i class="fas fa-times"></i></a>
                        </div>
                      </div>
                      <hr class="my-4">

                      <div class="pt-3">
                        <h6 class="mb-0"><a href="events?id=<?= $eventID ?>" class="text-white"><i class="fas fa-long-arrow-alt-left me-2"></i>Powrót do wydarzenia</a></h6>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 bg-grey">
                    <div class="p-2">
                      <h3 class="fw-bold mb-5 mt-2 pt-1 zolty">Podsumowanie</h3>
                      <hr class="my-4">

                      <div class="d-flex justify-content-between mb-4">
                        <h5 class="text-uppercase">Koszt Biletów: </h5>
                        <h5 id="PreCalculatedPrice"></h5>
                      </div>
                      <form method="POST" action="payment">
                        <h5 class="text-uppercase mb-3">Typ zamówienia</h5>

                        <div class="form-check">
                          <input class="form-check-input" value="Purchase" type="radio" name="TransactionType" id="flexRadioDefault1" checked>
                          <label class="form-check-label" for="flexRadioDefault1">
                            Zakup
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" value="Booking" type="radio" name="TransactionType" id="flexRadioDefault2">
                          <label class="form-check-label" for="flexRadioDefault2">
                            Rezerwacja
                          </label>
                        </div>
                        <br>
                        <h5 class="text-uppercase mb-3">Wpisz kod promocyjny</h5>
                        <div class="mb-5">
                          <div class="form-outline">
                            <input type="text" id="promoCodeInput" class="form-control form-control-lg" />
                          </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between mb-5">
                          <h5 class="text-uppercase">Suma: </h5>
                          <h5 id="PostCalculationPrice"></h5>
                        </div>

                        <input type="hidden" name="PriceOfTransaction" id="PriceOfTransaction" value="">
                        <input type="hidden" name="SingleTicketsBought" id="SingleTicketsBought" value="1">
                        <input type="hidden" name="UserID" value="<?= $userIDReturned['UserID'] ?>">
                        <input type="hidden" name="EventID" value="<?= $eventID ?>">
                        <button type="submit" class="btn btn-dark btn-block btn-lg" data-mdb-ripple-color="dark" style="background-color:#fff200;color:black">Przejdź do płatności</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  <?php
  require_once("footer.php");
  ?>
  <script>
    var PriceReduction = 1.0;
    $(document).ready(function() {
      function updateValue() {
        var priceforTickets = ($('#TicketAmount').val()) * <?= $EventDataReturned['TicketPrice'] ?>;
        var uselessVariable = priceforTickets * PriceReduction;
        console.log(uselessVariable);
        $('#PreCalculatedPrice').text(priceforTickets + ".00 zł");
        $('#PostCalculationPrice').text(uselessVariable + ".00 zł");
        $('#PriceOfTransaction').val(uselessVariable);
      }
      updateValue();
      $('#TicketAmount').on('change', function() {
          updateValue();
        })
        .trigger("change");

      $('#promoCodeInput').on('change', function() {
        var typedCode = $(this).val();
        if (typedCode === "TANIEJTIXY") {
          PriceReduction = 0.8;
          updateValue();
        } else {
          PriceReduction = 1;
          updateValue();
        }
      });

      $('#TicketAmount').on('change', function() {
        var sourceValue = $(this).val();
        $('#SingleTicketsBought').val(sourceValue);
      });
    });
  </script>

</body>

</html>