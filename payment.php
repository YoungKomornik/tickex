<?php
require_once("loginProcedure.php");
if (!isset($_POST['PriceOfTransaction'], $_POST['UserID'], $_POST['EventID'])) {
  http_response_code(404);
  include('404.php');
  die();
}
if (!($loggedIn)) {
  header("location: ./");
}
$userID = $_POST['UserID'];
$eventID = $_POST['EventID'];
$typeOfTransaction = $_POST['TransactionType'];
$priceOfTransaction = $_POST['PriceOfTransaction'];
$singleTicketsBought = $_POST['SingleTicketsBought'];
$paymentDataSaved = true;
try {
  $databaseConnection->begin_transaction();
  $paymentQuery = "SELECT `CardNumber`, `CardExpireDate`, `CardCVV`, `CardMiscDetails` FROM `paymentinfo` WHERE `AssociatedUser` = ?";
  $userQuery = "SELECT `Email` FROM `user` WHERE `UserID` = ?";

  if (!($userID === "")) {
    $statement = $databaseConnection->prepare($paymentQuery);
    $statement->bind_param("s", $userID);
    $statement->execute();
    $paymentQueryResult = $statement->get_result();
    $paymentDataReturned = $paymentQueryResult->fetch_assoc();
    if ($paymentQueryResult->num_rows === 0) {
      $paymentDataSaved = false;
    }
    $statement2 = $databaseConnection->prepare($userQuery);
    $statement2->bind_param("s", $userID);
    $statement2->execute();
    $userQueryResult = $statement2->get_result();
    $userDataReturned = $userQueryResult->fetch_assoc();
  }

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
  <title>TickEX - Tranzakcja</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/paymentstyles.css">

</head>



<body data-bs-theme="dark">
  <script src="js/bootstrap.bundle.js"></script>
  <script src="js/jquery-3.7.0.min.js"></script>
  <?php
  require_once("navbar.php");
  ?>
  <section class="p-4 p-md-5">
    <div class="row d-flex justify-content-center">
      <div class="col-md-10 col-lg-8 col-xl-5">
        <div class="shadow-lg  mb-5 card-body p-0 rounded-5" style="background-color:#181818 ">
          <div class="card-body p-4">
            <div class="text-center mb-4">
              <h2 id="payment">Płatność</h2>
            </div>

            <div class="d-flex flex-row align-items-center mb-4 pb-1">
              <div class="flex-fill mx-3">
                <div class="form-outline">
                  <input type="text" id="formControlLgXs" class="form-control form-control-lg" placeholder="Twój email" value="<?= $userDataReturned['Email'] ?>" />
                </div>
              </div>
              <button class="btn btn-dark btn-block" id="DeleteData">Usuń dane z serwera</button>
            </div>
            <form method="POST" action="paymentProcessing">
              <p class="fw-bold mb-4" id="savedcards">Podaj dane karty kredytowej:</p>
              <div class="form-outline mb-4">
                <input type="text" name="formControlMiscDetails" class="form-control form-control-lg" placeholder="Imię i Nazwisko" value="<?php if ($paymentDataSaved) {
                                                                                                                                              echo $paymentDataReturned['CardMiscDetails'];
                                                                                                                                            } ?>" required />
                <label class="form-label" for="formControlLgXsd">Dane posiadacza karty</label>
              </div>

              <div class="row mb-4">
                <div class="col-7">
                  <div class="form-outline">
                    <input type="text" name="formControlCardNumber" class="form-control form-control-lg" placeholder="Wpisz 16-cyfrowy numer karty" value="<?php if ($paymentDataSaved) {
                                                                                                                                                              echo $paymentDataReturned['CardNumber'];
                                                                                                                                                            } ?>" required minlength="16" maxlength="16" />
                    <label class="form-label" for="formControlLgXM">Numer Karty</label>
                  </div>
                </div>
                <div class="col-3">
                  <div class="form-outline">
                    <input type="password" name="formControlExpiry" class="form-control form-control-lg" placeholder="MM/YY" value="<?php if ($paymentDataSaved) {
                                                                                                                                      echo $paymentDataReturned['CardExpireDate'];
                                                                                                                                    } ?>" required maxlength="5" minlength="5" />
                    <label class="form-label" for="formControlLgExpk">Data ważności</label>
                  </div>
                </div>
                <div class="col-2">
                  <div class="form-outline">
                    <input type="password" name="formControlCVV" class="form-control form-control-lg" placeholder="CVV" value="<?php if ($paymentDataSaved) {
                                                                                                                                  echo $paymentDataReturned['CardCVV'];
                                                                                                                                } ?>" required maxlength="3" minlength="3" />
                    <label class="form-label" for="formControlLgcvv">CVV</label><br><br>
                  </div>
                </div>
                <input type="hidden" name="UserID" value="<?= $userID ?>">
                <input type="hidden" name="EventID" value="<?= $eventID ?>">
                <input type="hidden" name="TypeOfTransaction" value="<?= $typeOfTransaction ?>">
                <input type="hidden" name="PriceOfTransaction" value="<?= $priceOfTransaction ?>">
                <input type="hidden" name="SingleTicketsBought" value="<?= $singleTicketsBought ?>">
                <button type="submit" class="btn btn-dark btn-block btn-lg" data-mdb-ripple-color="dark" id="button1">zapłać</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php
  require_once("footer.php");
  ?>
  <script>
    $(document).ready(function() {
      function deletePaymentInfo(userID) {
        $.ajax({
          url: 'deletePaymentInfo.php',
          method: 'POST',
          data: {
            userID: userID
          },
          success: function(response) {
            console.log(response);
          },
          error: function(xhr, status, error) {
            console.log(error);
          }
        });
      }
      $('#DeleteData').on('click', function() {
        var userID = <?= $userID ?>;
        deletePaymentInfo(userID);
      });
    });
  </script>
</body>

</html>