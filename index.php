<?php
require_once("loginProcedure.php");
$eventQuery = "SELECT `EventID`, `EventName`, `DateOfEvent`, `Category`, `Description` FROM `events` ORDER BY `events`.`Category` ASC";
$eventsArray = array();
$eventsByCategory = array();
$tooManyCards = 0;
$categoryNamesForDOM = [
    "ID" => array("RAP", "POP", "TECHNO", "ROCK", "STAND-UP", "KONCERT", "TARGI", "TANIEC", "WYSCIGI", "DJ"),
    "Name" => array(
        "Twoi ulubieni raperzy",
        "POP! i cie nie ma",
        "Teczniczne Brzmienie",
        "Rockuj i Rolluj",
        "Śmiechom nie było końca",
        "Koncertujemy",
        "Targi",
        "Tańcz ile sił",
        "Brum Brum Brum",
        "Diżej"
    )
];

try {
    $databaseConnection->begin_transaction();
    $statement = $databaseConnection->prepare($eventQuery);
    $statement->execute();
    $eventQueryResult = $statement->get_result();
    while ($row = $eventQueryResult->fetch_assoc()) {
        $eventsArray[] = $row;
    }
    $databaseConnection->commit();
} catch (Exception $exception) {
    $databaseConnection->rollback();
}


foreach ($eventsArray as $event) {
    $category = $event['Category'];

    $categoryIndex = array_search($category, $categoryNamesForDOM['ID']);

    if ($categoryIndex !== false) {
        $categoryID = $categoryNamesForDOM['ID'][$categoryIndex];
        $categoryName = $categoryNamesForDOM['Name'][$categoryIndex];

        // Add an if condition to exclude specific categories
        $excludedCategories = ['WYSCIGI', 'TECHNO', 'TARGI', 'STAND-UP', 'DJ'];
        if (!in_array($category, $excludedCategories)) {
            // Add the event to the eventsByCategory array
            if (!isset($eventsByCategory[$category])) {
                $eventsByCategory[$category] = array();
            }
            $eventsByCategory[$category][] = $event;
        }
    }
}

//karuzela polecane
$numberOfRecomendedEvents = 8;
$recomendedEventIndex = [];
for($i=0; $i<$numberOfRecomendedEvents; $i++){
    do{
    $randomEvent = rand(0,count($eventsArray)-1);
    }while(!(array_search($randomEvent, $recomendedEventIndex) === false));
    array_push($recomendedEventIndex, $randomEvent);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TickEX - Wszystkie bilety w jednym miejscu!</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/indexstyles.css">

</head>

<body data-bs-theme="dark">
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/jquery-3.7.0.min.js"></script>
    <?php
    require_once("navbar.php");
    ?>
    <div id="carouselExampleIndicators" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner main-carousel">
            <div class="carousel-item main-carousel-item active" onClick="location.href='events?id=15'">
                <a><img src="src/EventImages/<?= $eventsArray[0]["EventID"] ?>.webp" class="d-block w-100 h-25" alt="Slide 1"></a>
            </div>
            <div class="carousel-item main-carousel-item" onClick="location.href='events?id=12'">
                <a><img src="src/EventImages/<?= $eventsArray[1]["EventID"] ?>.webp" class="d-block w-100 h-25" alt="Slide 2"></a>
            </div>
            <div class="carousel-item main-carousel-item" onClick="location.href='events?id=38'">
                <a><img src="src/EventImages/<?= $eventsArray[2]["EventID"] ?>.webp" class="d-block w-100 h-25" alt="Slide 3"></a>
            </div>
        </div>
        <button class="carousel-control-prev main-carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next main-carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <br>

    <h1 class="h1 carousel-header fs-1 fw-bold">Polecane</h1>
    <div id="polecane" class="carousel" data-ride="carousel">
        <div class="carousel-inner mid-carousel">
            <?php
                foreach($recomendedEventIndex as $index => $eventIndex){
                    ?>
                        <div class="carousel-item card-carousel<?php echo ($index === 0) ? ' active' : ''; ?>" onClick="location.href='events?id=<?=$eventsArray[$eventIndex]['EventID']?>'">
                            <div class="card">
                                <div class="img-wrapper"><img src="src/EventImages/<?=$eventsArray[$eventIndex]['EventID']?>.webp" class="d-block w-100" alt="Zdjęcie wydarzenia"></div>
                                <div class="card-body">
                                    <h5 class="card-title"><?=$eventsArray[$eventIndex]['EventName']?></h5>
                                    <p class="card-text"><?php echo mb_strimwidth($eventsArray[$eventIndex]['Description'], 0, 200, "...");?></p>
                                </div>
                            </div>
                        </div>
                    <?php
                }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#polecane" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#polecane" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <?php foreach ($eventsByCategory as $category => $categoryEvents) {
        $categoryIndex = array_search($category, $categoryNamesForDOM['ID']);
        $categoryID = $categoryNamesForDOM['ID'][$categoryIndex];
        $categoryName = $categoryNamesForDOM['Name'][$categoryIndex];
    ?>
            <h1 class="h1 carousel-header fs-1 fw-bold"><?php echo $categoryName; ?></h1>
            <div id="carouselExampleControls_<?php echo $categoryID; ?>" class="carousel" data-ride="carousel">
                <div class="carousel-inner mid-carousel">
                    <?php foreach ($categoryEvents as $index => $event) : ?>
                        
                        <div class="carousel-item card-carousel<?php echo ($index === 0) ? ' active' : ''; ?>" onClick="location.href='events?id=<?= $event['EventID'] ?>'">
                            <div class="card">
                                <div class="img-wrapper"><img src="src/EventImages/<?= $event['EventID'] ?>.webp" class="d-block w-100" alt="..."></div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $event['EventName']; ?></h5>
                                    <p class="card-text"><?php echo mb_strimwidth($event['Description'], 0, 200, "..."); ?></p>
                                </div>
                            </div>

                        </div>

                    <?php ;
                    if($tooManyCards >= 7){
                        $tooManyCards = 0;
                        break;
                    }
                    
                endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls_<?php echo $categoryID; ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls_<?php echo $categoryID; ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    <?php
    }
    ?>

    <?php
    require_once("footer.php");
    ?>


    <script>
        $('.carousel').each(function() {
            const carouselSelector = `#${this.id}`;
            const carouselInstance = new bootstrap.Carousel(carouselSelector, {
                interval: false
            });

            let scrollPosition = 0;
            let cardWidth;

            const updateCardWidth = function() {
                cardWidth = $(`${carouselSelector} .carousel-item`).width();
            };

            const animateScroll = function(position) {
                $(`${carouselSelector} .carousel-inner`).animate({
                    scrollLeft: position
                }, 600);
            };

            const nextButtonClick = function() {
                if (scrollPosition < $(`${carouselSelector} .carousel-inner`)[0].scrollWidth - cardWidth * 4) {
                    scrollPosition += cardWidth;
                    animateScroll(scrollPosition);
                }
            };

            const prevButtonClick = function() {
                if (scrollPosition > 0) {
                    scrollPosition -= cardWidth;
                    animateScroll(scrollPosition);
                }
            };

            const handleResponsive = function() {
                if (window.matchMedia("(min-width: 768px)").matches) {
                    $(carouselSelector).removeClass("slide");
                } else {
                    $(carouselSelector).addClass("slide");
                }
            };


            $(window).on("resize", function() {
                updateCardWidth();
                scrollPosition = 0;
                animateScroll(scrollPosition);
                handleResponsive();
            });

            $(`${carouselSelector} .carousel-control-next`).on("click", nextButtonClick);
            $(`${carouselSelector} .carousel-control-prev`).on("click", prevButtonClick);

            updateCardWidth();
            handleResponsive();
        });
    </script>
</body>

</html>