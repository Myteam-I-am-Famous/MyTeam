<?php session_start();
$title = "Créer un pack";

include 'includes/head.php';
include 'includes/header.php';

include 'includes/functions.php';
?>

<main>

    <div class="create-pack-container">

        <div class="pack-container">

            <h1>Pack - Premium SZN</h1>
            <h3>350 mt_points</h3>

            <div class="pack-players">
                <div class="pack-player">
                    <img src="https://a.espncdn.com/i/headshots/nba/players/full/1966.png" alt="">
                    <p>LeBron James</p>
                    <p>N°3</p>
                </div>
                <div class="pack-player">
                    <img src="https://a.espncdn.com/i/headshots/nba/players/full/1966.png" alt="">
                    <p>LeBron James</p>
                    <p>N°3</p>
                </div>
            </div>

        </div>

        <div class="pack-creator">

            <input type="text" id="pack-searchbar" placeholder="Tappez le nom d'un joueur">

            <div id="pack-creator-players">
                <div class="pack-creator-player" id="LeBron James">
                    <h1>LeBron James</h1>
                    <div class="pack-creator-player-variant">
                        <img src="http://content.mtdb.com/www/nba2k20/lebron-james-1.png" alt="">
                        <img src="http://content.mtdb.com/www/nba2k20/lebron-james-2.png" alt="">
                        <img src="http://content.mtdb.com/www/nba2k20/lebron-james-3.png" alt="">
                        <!-- <img src="http://content.mtdb.com/www/nba2k20/lebron-james-4.png" alt="">
                        <img src="http://content.mtdb.com/www/nba2k20/lebron-james-5.png" alt="">
                        <img src="http://content.mtdb.com/www/nba2k20/lebron-james-6.png" alt="">
                        <img src="http://content.mtdb.com/www/nba2k20/lebron-james-7.png" alt="">
                        <img src="http://content.mtdb.com/www/nba2k20/lebron-james-8.png" alt="">
                        <img src="http://content.mtdb.com/www/nba2k20/lebron-james-9.png" alt="">
                        <img src="http://content.mtdb.com/www/nba2k20/lebron-james-10.png" alt="">
                        <img src="http://content.mtdb.com/www/nba2k20/lebron-james-11.png" alt=""> -->

                    </div>
                </div>
                <div class="pack-creator-player">
                    <h1>Russel Westbrook</h1>
                    <div class="pack-creator-player-variant" id="Russell Westbrook">
                        <img src="http://content.mtdb.com/www/nba2k20/russell-westbrook-1.png" alt="">
                        <img src="http://content.mtdb.com/www/nba2k20/russell-westbrook-2.png" alt="">
                        <img src="http://content.mtdb.com/www/nba2k20/russell-westbrook-3.png" alt="">
                        <img src="http://content.mtdb.com/www/nba2k20/russell-westbrook-4.png" alt="">

                    </div>
                </div>

            </div>


</main>

<script src="scripts/pack_creator.js"></script>

<?php include 'includes/footer.php'; ?>