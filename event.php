<?php session_start();

include 'includes/functions.php';

if (!isset($_SESSION['uid'])) {
    header('location: index.php?code=accessdenied');
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('location: index.php?code=noeventfound');
    exit;
}
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');


$events = getDataByID($_GET['id'], '*', 'events');

if ($events == null) {
    header('location: index.php?code=noeventfound');
    exit;
}


$event = $events[0];

$begin = strftime("%A %d %B", strtotime($event['begin']));
$end = strftime("%A %d %B", strtotime($event['end']));

$beginDT = new DateTime("NOW");
$endDT = new DateTime($event['end']);

$difference = $beginDT->diff($endDT);


$days = getDoubleDigitFormat($difference->days);
$hours = getDoubleDigitFormat(intval($difference->format("%h")) - 2);
$minutes = getDoubleDigitFormat($difference->format("%i"));
$seconds = getDoubleDigitFormat($difference->format("%s"));

$userEvent = getDataByID($_SESSION['uid'], 'event')[0];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="css/event.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body>


    <header>
        <div class="event-logo">MyTeam</div>

        <ul class="nav-links">
            <li><a href="#" class="nav-link">Forum</a></li>
            <li><a href="#" class="nav-link">Recompense</a></li>
            <li><a href="#" class="nav-link">Rules</a></li>
            <img src="./assets/menu.svg" alt="" class="event-menu">
        </ul>
    </header>

    <main>

        <div class="event-panels">
            <div id="e-p-1">
                <div class="event-bg">
                    <img src="<?php echo 'uploads/events/event-' . $event['title'] . '/' . $event['image']; ?>" alt="">
                </div>

                <div class="vignette"></div>

                <!-- <div class="sparks"></div> -->

                <div class="event-main">

                    <div class="event-info">
                        <p><?php echo strtoupper($begin) ?> | MYTEAM</p>
                        <h3><?php echo $event['title']; ?></h3>
                    </div>

                    <div id="countdown">
                        <div class="countdown-value">
                            <h1 id="days"><?php echo $days ?></h1>
                            <p>Jours</p>
                        </div>
                        <div class="countdown-separator"></div>
                        <div class="countdown-value">
                            <h1 id="hours"><?php echo $hours ?></h1>
                            <p>Heures</p>
                        </div>
                        <div class="countdown-separator"></div>
                        <div class="countdown-value">
                            <h1 id="minutes"><?php echo $minutes ?></h1>
                            <p>Minutes</p>
                        </div>
                        <div class="countdown-separator"></div>
                        <div class="countdown-value">
                            <h1 id="seconds"><?php echo $seconds ?></h1>
                            <p>Secondes</p>
                        </div>
                    </div>

                    <?php

                    if ($userEvent['event'] == $event['id'])
                        echo '<button class="joined" id="join">Quitter l\'événement</button>';
                    else
                        echo '<button id="join">Rejoindre l\'événement</button>';

                    ?>

                </div>

                <div class="event-footer">

                    <div id="participant-list">
                        <h3>Liste des participants</h3>
                        <div class="participant">
                            <div class="id">
                                <i class="fas fa-user"></i>
                                <p>25</p>
                            </div>
                            <p>Exemple</p>
                            <img src="https://get.wallhere.com/photo/Jump-Force-Son-Goku-Super-Saiyan-hero-1557785.jpg" alt="participant-pfp">
                        </div>
                        <div class="participant">
                            <div class="id">
                                <i class="fas fa-user"></i>
                                <p>25</p>
                            </div>
                            <p>Exemple 2</p>
                            <img src="https://get.wallhere.com/photo/Jump-Force-Son-Goku-Super-Saiyan-hero-1557785.jpg" alt="participant-pfp">
                        </div>
                        <?php

                        $participants = getEventParticipants($event['id']);

                        foreach ($participants as $participant) {
                            echo ' <div class="participant">
                            <div class="id">
                                <i class="fas fa-user"></i>
                                <p>' . getDoubleDigitFormat($participant['id']) . '</p>
                            </div>
                            <p>' . $participant['pseudo'] . '</p>
                            <img src="' . 'uploads/' . $participant['pseudo'] . '/' . $participant['profile_picture'] . '" alt="participant-pfp">
                        </div>';
                        }

                        ?>

                    </div>

                    <div class="event-quick-links">
                        <a href="#">Ladder</a>
                        <span>/</span>
                        <a href="#" id="participants">Participants</a>
                        <span>/</span>
                        <a href="#">Liste d'événements</a>
                    </div>

                    <div class="scroll-down">
                        <img src="./assets/scroll_down.svg" alt="scroll down">
                        <p>Scroll pour en voir plus</p>
                    </div>

                    <p>id : <span id="event-id"><?php echo $event['id'] ?></span></p>

                </div>
            </div>
            <div id="event-panel-2">
            </div>
        </div>

    </main>


    <script src="scripts/event.js"></script>
</body>

</html>