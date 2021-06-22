<?php session_start();
$title = "Créer un pack";

include 'includes/head.php';
include 'includes/header.php';


?>

<main>

    <div class="create-pack-container">

        <div class="pack-container">

            <h1>Pack - Premium SZN</h1>
            <h3>350 mt_points</h3>

            <div id="pack-players">
                <!-- <div class="pack-player">
                    <img src="http://content.mtdb.com/www/nba2k20/lonzo-ball-1.png" alt="player headshot">
                    <p>Lonzo Ball</p>
                    <p>N°1</p>
                    <i class="fas fa-times"></i>
                </div> -->
            </div>


        </div>

        <div class="actions">
            <button id="create-btn">Create</button>

            <input type="text" id="name" placeholder="Name">
            <input type="number" name="price" id="price">

            <button id="clear-btn">Clear</button>
        </div>

        <div class="pack-creator">

            <input type="text" id="pack-searchbar" placeholder="Tappez le nom d'un joueur">

            <div id="pack-creator-players">


            </div>
</main>

<script src="scripts/pack_creator.js"></script>

<?php include 'includes/footer.php'; ?>