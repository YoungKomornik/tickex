<?php
require_once("loginProcedure.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Nie znaleziono strony</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        .event404 {
            color: #fff200;
            font-size: 500%;
            text-align: center;
        }
    </style>
</head>

<body data-bs-theme="dark">
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/jquery-3.7.0.js"></script>
    <?php
    require_once("navbar.php");
    ?>
    <div class="position-absolute top-50 start-50 translate-middle event404">BŁĄD 404<br> NIE ZNALEZIONO STRONY DOCELOWEJ</div>
    <?php
    require_once("footer.php");
    ?>
</body>

</html>