<?php session_start();


if (isset($_SESSION['status']) && $_SESSION['status'] == 0) {
    header('location: index.php?blockunverified');
    exit;
}

$title = "Inventory";

include 'includes/head.php';
include 'includes/header.php';
?>

<main>

    <div class="shop-container">

        <div id="overlay-container">

            <div id="overlay">
                <i id="overlay-close" class="fas fa-times"></i>
                <h1 id="overlay-title">Oops !</h1>
                <p id="overlay-message">Il semblerait que vous ne possediez pas assez de <span class="green">MT_POINTS</span></p>
            </div>

        </div>


        <div class="packed-cards-container">
            <i id="packed-cards-cls" class="fas fa-times"></i>

            <div id="packed-cards"></div>
        </div>

        <?php
        $user = getDataByID($_SESSION['uid']);

        echo '<h3 id="mt-points">Mt_points : ' . number_format($user[0]['mt_points'], 0, ',', ' ') . '</h3>';

        ?>

        <div class="shop-packs">

            <?php

            foreach (getDataFrom('basketball_packs') as $pack) {

                // var_dump($pack['name']);
                $q = 'SELECT * FROM basketball_cards_variants WHERE id IN (' . $pack['cards'] . ');';
                $stmt = $dbh->prepare($q);
                $status = $stmt->execute();
                if ($status) {
                    echo '<div class="shop-pack">
                    <h3>' . $pack['name'] . '</h3>';
                    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="shop-pack-card">
                                    <img src="' . $result['variantURL'] . '" alt="" srcset="">
                                </div>';
                    }
                    echo '<div class="shop-pack-actions">
                    <h2>Price : ' . $pack['price'] . '</h2>
                    <button class="buy-btn" id="pack-' . $pack['id'] . '">Buy</button>
                    </div>
                    </div>
                    ';
                }
            }


            ?>

        </div>





    </div>



</main>
<!-- <script src="scripts/cards.js"></script> -->
<script src="scripts/shop.js"></script>


<?php include 'includes/footer.php'; ?>
