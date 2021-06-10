<?php session_start();
$title = "Football | Inventaire";

include 'includes/head.php';
include 'includes/header.php'; ?>


<main>

    <div class="team-container">


        <!-- <div class="team-card">
            <div class="card-bg"></div>
            <div class="card-content">
                <div class="card-text">
                    <div class="card-role">
                        <p>HEAT / SF</p>
                    </div>
                    <div class="card-identity">
                        <h3>LEBRON</h3>
                        <p> 23 </p>
                        <h3>JAMES</h3>
                    </div>
                </div>
            </div>
        </div> -->

        <h1>MY<span class="yellow">TEAM</span> <span class="red">NBA</span></h1>

        <h3 id="overall">Team Overall : </h3>

        <div class="myteam-cards">

            <div class="myteam-card" id="card-1" draggable="true">
                <img src="http://content.mtdb.com/www/nba2k20/lonzo-ball-4.png" alt="" srcset="">
            </div>
            <div class="myteam-card" id="card-2" draggable="true">
                <img src=" http://content.mtdb.com/www/nba2k20/lebron-james-5.png" alt="" srcset="">
            </div>
            <div class="myteam-card" id="card-3" draggable="true">
                <h1>Empty</h1>
                <!-- <img src=" http://content.mtdb.com/www/nba2k20/paul-george-5.png" alt="" srcset=""> -->
            </div>
            <div class="myteam-card" id="card-4" draggable="true">
                <img src=" http://content.mtdb.com/www/nba2k20/joel-embiid-5.png" alt="" srcset="">
            </div>
            <div class="myteam-card" id="card-5" draggable="true">
                <img src=" http://content.mtdb.com/www/nba2k20/lamelo-ball-2.png" alt="" srcset="">
            </div>

        </div>



    </div>


    <div class="inventory-container">



        <?php

        include './includes/functions.php';

        $uid = isset($_SESSION['uid']) ? $_SESSION['uid'] : 1;

        $cards = getCardsByUID($uid);


        if ($cards) {

            if (!isset($_GET['display']) || $_GET['display'] == 'table') {
                echo '<table class="inventory-table" cellspacing="0" cellpadding="0">

            <thead>
                <tr>
                    <th class="id">id<i class="fas fa-chevron-down"></i></th>
                    <th class="fullname">Full Name<i class="fas fa-chevron-down"></i></th>
                    <th class="number">Number<i class="fas fa-chevron-down"></i></th>
                    <th class="headshot">Headshot</th>
                    <th class="position">Position<i class="fas fa-chevron-down"></i></th>
                    <th class="table-team">Team<i class="fas fa-chevron-down"></i></th>
                    <th class="league">League</th>
                    <th class="overall">Overall<i class="fas fa-chevron-down"></i></th>
                    <th class="gp">GP<i class="fas fa-chevron-down"></i></th>
                    <th class="pts">PTS<i class="fas fa-chevron-down"></i></th>
                    <th class="min">Min<i class="fas fa-chevron-down"></i></th>
                    <th class="fg">FG<i class="fas fa-chevron-down"></i></th>
                    <th class="tp">TP<i class="fas fa-chevron-down"></i></th>
                    <th class="ft">FT<i class="fas fa-chevron-down"></i></th>
                    <th class="reb">REB<i class="fas fa-chevron-down"></i></th>
                    <th class="ast">AST<i class="fas fa-chevron-down"></i></th>
                    <th class="blk">BLK<i class="fas fa-chevron-down"></i></th>
                    <th class="stl">STL<i class="fas fa-chevron-down"></i></th>
                </tr>
            </thead>

            <tbody>';

                foreach ($cards as $key => $card) {

                    echo '<tr class="inventory-table-row">
                    <td class="id">' . $card['bid'] . '</td>
                    <td class="fullname">' . $card['full_name'] . '</td>
                    <td class="number">' . $card['jersey_number'] . '</td>
                    <td class="headshot"><img src="' . $card['headshot_url'] . '" alt=""></td>
                    <td class="position">' . $card['position'] . '</td>
                    <td class="table-team">' . $card['team'] . '</td>
                    <td class="league">' . $card['league'] . '</td>
                    <td class="overall">' . $card['overall'] . '</td>
                    <td class="gp">' . $card['gp'] . '</td>
                    <td class="pts">' . $card['pts'] . '</td>
                    <td class="min">' . $card['min'] . '</td>
                    <td class="fg">' . $card['fg_pct'] . '</td>
                    <td class="tp">' . $card['tp_pct'] . '</td>
                    <td class="ft">' . $card['ft_pct'] . '</td>
                    <td class="reb">' . $card['reb'] . '</td>
                    <td class="ast">' . $card['ast'] . '</td>
                    <td class="blk">' . $card['blk'] . '</td>
                    <td class="stl">' . $card['stl'] . '</td>
                </tr>';
                }

                echo '
            </tbody>

        </table>';
            } else if ($_GET['display'] == 'grid') {

                echo '<div class="inventory-grid">';

                foreach ($cards as $key => $card) {
                    echo '<div class="grid-card">
                                    <i class="fas fa-lock"></i>
                                    <h3 class="rating">' . $card['overall'] . '</h3>
                                    <img src= "https://a.espncdn.com/i/headshots/nba/players/full/' . $card['bid'] . '.png" alt="" class="headshot">
                                    <img src= "https://a.espncdn.com/combiner/i?img=/i/teamlogos/nba/500/' . $card['team_abv'] . '.png&h=50&w=50" alt="" class="team-logo">
                                </div>';
                }
                echo '</div>';
            }
        } else {
            echo "<div class='inventory-empty'>
                    <h1>Votre inventaire est vide</h1>
                    <p>Visiter la <a href='#'>boutique</a> ou la <a href='#'>page d'évènements</a> pour en obtenir</p>
                    <div class='inventory-empty-bg'></div>
                  </div>";
        }

        ?>


    </div>



</main>
<script src="./scripts/inventory.js"></script>


<?php include 'includes/footer.php';
