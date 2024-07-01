<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="logo.ico">
    <title>tickEX - Rejestracja</title>
</head>

<body data-bs-theme="dark">
    <?php
    session_start();
    function registerAction()
    {
        if (isset($_POST['loginInput'], $_POST['passwordInput'], $_POST['passwordInputControl'], $_POST['emailInput'])) {
            $sqlServer = "localhost";
            $sqlLogin = "root";
            $sqlPassword = "";
            $sqlDatabase = "tickex";
            $databaseConnection = new mysqli($sqlServer, $sqlLogin, $sqlPassword, $sqlDatabase);

            if ($databaseConnection->connect_error) {
                $errorMessage = '<div class="bg-danger-subtle border border-danger-subtle rounded-3">Przepraszamy, ale w tym momencie nasze serwery są niedostępne. Prosimy spróbować później.</div><br>';
                return $errorMessage;
            }
            $databaseConnection->begin_transaction();
            try {
                $inputLogin = $_POST['loginInput'];
                $inputEmail = $_POST['emailInput'];
                $inputPasswordStrengthControl = $_POST['passwordInput'];
                $inputPassword = hash('sha512', $_POST['passwordInput']);
                $inputPasswordControl = hash('sha512', $_POST['passwordInputControl']);

                $uppercase = preg_match('@[A-Z]@', $inputPasswordStrengthControl);
                $lowercase = preg_match('@[a-z]@', $inputPasswordStrengthControl);
                $number    = preg_match('@[0-9]@', $inputPasswordStrengthControl);
                $specialChars = preg_match('@[^\w]@', $inputPasswordStrengthControl);

                if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($inputPasswordStrengthControl) < 8) {
                    $errorMessage = '<div class="bg-danger-subtle border border-danger-subtle rounded-3">Podane hasło nie spełnia wymagań!</div><br>';
                    return $errorMessage;
                }
                if ($inputPassword != $inputPasswordControl) {
                    $errorMessage = '<div class="bg-danger-subtle border border-danger-subtle rounded-3">Podane hasła nie zgadzają się!</div><br>';
                    return $errorMessage;
                }
                $query = "SELECT `Login` FROM `user` WHERE `Login` = ?";
                $statement = $databaseConnection->prepare($query);
                $statement->bind_param("s", $inputLogin);
                $statement->execute();
                $queryResult = $statement->get_result();

                if ($queryResult->num_rows > 0) {
                    $errorMessage = '<div class="bg-danger-subtle border border-danger-subtle rounded-3">Podana nazwa użytkownika jest zajęta!</div><br>';
                    return $errorMessage;
                }

                $registerDateHash = hash('sha512', time());
                $loginHash = hash('sha512', $inputLogin);
                $loginToken = $registerDateHash . "." . $loginHash;

                $insertQuery = "INSERT INTO `user` (`Login`, `Email`,`PasswordSHA512`, `LoginToken`) VALUES (?, ?, ?, ?)";
                $insertStatement = $databaseConnection->prepare($insertQuery);
                $insertStatement->bind_param("ssss", $inputLogin, $inputEmail, $inputPassword, $loginToken);
                $insertStatement->execute();

                $selectQuery = "SELECT `UserID` FROM `user` WHERE `LoginToken` = ?";
                $selectStatement = $databaseConnection->prepare($selectQuery);
                $selectStatement->bind_param("s", $loginToken);
                $selectStatement->execute();
                $queryResult = $selectStatement->get_result()->fetch_assoc();

                $personalInfoQuery = "INSERT INTO `personalinfo` (`AssociatedUser`, `CreationDate`) VALUES (?, ?)";
                $personalInfoStatement = $databaseConnection->prepare($personalInfoQuery);
                $creationDate = date("Y-m-d");
                $personalInfoStatement->bind_param("ss", $queryResult['UserID'], $creationDate);
                $personalInfoStatement->execute();

                $databaseConnection->commit();
            } catch (Exception $exception) {
                $databaseConnection->rollback();
                throw $exception;
            }
            $databaseConnection->close();
            $_SESSION['success'] = true;
            header("Location: ./login");
        }
    }
    $registerOutcome = registerAction();
    ?>
    <div class="container text-center">
        <div class="row">
            <div class="col"></div>
            <!--Rzeczywisty kontent, tamte divy są po to by to jakoś wyglądało esz -->
            <div class="col">
                <form method="POST" action="">
                    <?php
                    echo $registerOutcome;
                    ?>
                    <img class="mb-4" src="logo.svg" alt="" width="160" height="160">

                    <div class="mb-3">
                        <input type="text" class="form-control" name="loginInput" placeholder="Nazwa użytkownika" required>
                    </div>

                    <div class="mb-3">
                        <input type="email" class="form-control" name="emailInput" placeholder="Adres email" required>
                    </div>

                    <div class="mb-3">
                        <input type="password" class="form-control" name="passwordInput" placeholder="Hasło" aria-describedby="passwordInfo" required>
                        <div id="passwordInfo" class="form-text text-start">Hasło musi mieć co najmniej 8 znaków, jedną dużą literę,<br> jedą cyfre i jeden znak specjalny.</div>
                    </div>

                    <div class="mb-3">
                        <input type="password" class="form-control" name="passwordInputControl" placeholder="Powtórz Hasło" required>
                    </div>
                    <br>
                    <button class="w-100 btn btn-lg" id="login-button" type="submit">Utwórz konto</button><br><br>
                    <p><a class="text-decoration-none" href="login">Powrót do logowania</a></p>
                    <p class="mt-5 mb-3 text-body-secondary">©tickEX 2023</p>
                </form>
            </div>
            <div class="col">
            </div>
        </div>
    </div>

</body>

</html>