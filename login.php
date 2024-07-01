<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="logo.ico">
    <title>tickEX - Logowanie</title>
</head>

<body data-bs-theme="dark">
    <?php
    if (isset($_COOKIE['rememberUser'])) {
        header("Location: ./");
        exit(); // Ensure script execution stops after redirection
    }

    session_start();

    function LoginOutcome()
    {
        if (isset($_POST['loginInput'], $_POST['passwordInput'])) {
            $inputLogin = $_POST['loginInput'];
            $inputPassword = hash('sha512', $_POST['passwordInput']);
            $rememberMe = false;
            $sqlServer = "localhost";
            $sqlLogin = "root";
            $sqlPassword = "";
            $sqlDatabase = "tickex";

            if (isset($_POST['rememberInput']) && $_POST['rememberInput'] === "true") {
                $rememberMe = true;
            }

            $databaseConnection = new mysqli($sqlServer, $sqlLogin, $sqlPassword, $sqlDatabase);

            if ($databaseConnection->connect_error) {
                $errorMessage = '<div class="bg-danger-subtle border border-danger-subtle rounded-3">Przepraszamy, ale w tym momencie nasze serwery są niedostępne. Prosimy spróbować później.</div><br>';
                return $errorMessage;
            }

            try {
                $databaseConnection->begin_transaction();

                $query = "SELECT `PasswordSHA512`, `LoginToken` FROM `user` WHERE `Login` = ?";
                $statement = $databaseConnection->prepare($query);
                $statement->bind_param("s", $inputLogin);
                $statement->execute();
                $queryResult = $statement->get_result();

                if ($queryResult->num_rows < 1) {
                    $errorMessage = '<div class="bg-danger-subtle border border-danger-subtle rounded-3">Podana nazwa użytkownika nie istnieje!</div><br>';
                    return $errorMessage;
                }

                $passwordAndToken = $queryResult->fetch_assoc();

                if ($passwordAndToken['PasswordSHA512'] === $inputPassword) {
                    session_regenerate_id(true);
                    $_SESSION['sessionLogin'] = $passwordAndToken['LoginToken'];
                    $_SESSION['isLoggedIn'] = true;

                    if ($rememberMe) {
                        $cookieName = "rememberUser";
                        $cookieValue = $passwordAndToken['LoginToken'];
                        $cookieExpire = time() + (86400 * 30);

                        setcookie($cookieName, $cookieValue, $cookieExpire, "/", "", true, true);
                    }

                    $databaseConnection->commit();
                    $databaseConnection->close();

                    header("Location: ./");
                    exit();
                } else {
                    $errorMessage = '<div class="bg-danger-subtle border border-danger-subtle rounded-3">Niepoprawne hasło! Spróbuj jeszcze raz.</div><br>';
                    return $errorMessage;
                }
            } catch (Exception $exception) {
                $databaseConnection->rollback();
                $errorMessage = '<div class="bg-danger-subtle border border-danger-subtle rounded-3">Wystąpił błąd podczas logowania. Prosimy spróbować ponownie.</div><br>';
                return $errorMessage;
            }
        }
    }

    $errorMessage = LoginOutcome();

    if (isset($_SESSION['success'])) {
        $errorMessage = '<div class="bg-success-subtle border border-success-subtle rounded-3">Pomyślnie utworzono konto!</div><br>';
        unset($_SESSION['success']);
    }
    ?>
    <div class="container text-center">
        <div class="row">
            <div class="col"></div>
            <!--Rzeczywisty kontent, tamte divy są po to by to jakoś wyglądało esz -->
            <div class="col">
                <form method="POST" action="login.php">
                    <?php
                    if (isset($errorMessage)) {
                        echo $errorMessage;
                    }
                    ?>
                    <img class="mb-4" src="logo.svg" alt="" width="160" height="160">

                    <div class="mb-3">
                        <input type="text" class="form-control" name="loginInput" placeholder="Nazwa użytkownika">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="passwordInput" placeholder="Hasło">
                    </div>
                    <div class="checkbox mb-3">
                        <label>
                            <input type="checkbox" name="rememberInput" value="true"> Zapamiętaj mnie
                        </label>
                    </div>
                    <button class="w-100 btn btn-lg" id="login-button" type="submit">Zaloguj się</button><br><br>
                    <p>Nie masz jeszcze konta? <a class="text-decoration-none" href="register">Zajerestuj się</a></p>
                    <p class="mt-5 mb-3 text-body-secondary">©tickEX 2023</p>
                </form>
            </div>
            <div class="col">
            </div>
        </div>
    </div>

</body>

</html>