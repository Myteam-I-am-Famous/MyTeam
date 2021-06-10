<?php session_start();
$title = "Inventory";

include 'includes/head.php';
include 'includes/header.php';
?>

<main>


    <?php include './includes/functions.php';

    ?>

    <h3 id="status"></h3>

    <input type="text" id="search-card" placeholder="player ID">
    <select name="sport" id="search-sport">
        <option value="1" selected>NBA</option>
        <option value="2">Football</option>
    </select>
    <button id="search-submit" type="submit">Search</button>

    <div class="shop-buttons">

        <button id="buy">Buy</button>
        <button id="refresh">Refresh</button>

    </div>


    <div class="pack-container" style="width: 100%; height: 30px; display:flex; margin-top:15rem; justify-content:center;">


        <div class="team-container">
            <h1>MY<span class="yellow">TEAM</span> <span class="red">CARD SHOP</span></h1>

            <h3 id="overall">Premium Pack : </h3>

            <div class="myteam-cards">


                <div class="myteam-card" id="card-1" draggable="true">
                    <img src="http://content.mtdb.com/www/nba2k20/lonzo-ball-1.png" alt="" srcset="">
                </div>


            </div>


        </div>



</main>
<script src="scripts/cards.js"></script>
<script src="scripts/shop.js"></script>


<?php include 'includes/footer.php'; ?>