<?php session_start();

$title = "Liste d'événements";

include 'includes/head.php';
include 'includes/header.php'; ?>


<main>

    <div class="event-list">

        <?php

        $events = getDataFrom('events', 'end');


        foreach ($events as $event) {
            $begin = strftime("%A %d %B", strtotime($event['begin']));
            $end = strftime("%A %d %B", strtotime($event['end']));

            $beginDT = new DateTime("NOW");
            $endDT = new DateTime($event['end']);

            $difference = $beginDT->diff($endDT);


            $days = getDoubleDigitFormat($difference->days);
            $hours = getDoubleDigitFormat(intval($difference->format("%h")) - 2);
            $minutes = getDoubleDigitFormat($difference->format("%i"));
            echo '<div class="event-list-element">
            <h1 class="event-name">' . $event['title'] . '</h1>
            <h3 class="event-time-remaining">' . $days . ' jours ' . $hours . ' heures ' . $minutes . ' minutes' . '</h3>
            <img src="uploads\events\event-' . $event['title']  . '/' . $event['image'] . '" alt="">
            <a href="evenement/' . $event['id'] . '"><button>Voir l\'événement</button></a>
        </div>';
        }

        ?>

    </div>

</main>


<?php include 'includes/footer.php'; ?>
