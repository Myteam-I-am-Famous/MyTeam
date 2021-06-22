<?php session_start();
$title = "MyTeam | Home";

include 'includes/head.php';
include 'includes/header.php';
include "includes/functions.php";


incrementVisits();
?>

<main>





    <div class="container">

        <div id="panel-1">

            <div class="panel-1-1">
                <div class="panel-title">
                    <h1><span class="red">Paris</span><br><span class="blue">Saint Germain</span></h1>

                    <div class="match-cards">
                        <div class="match-card">
                            <div class="match-card-options">
                                <div class="match-card-option active-card-option">
                                    <h3>Resultat</h3>
                                </div>
                                <div class="match-card-option">
                                    <h3>Stats</h3>
                                </div>
                            </div>
                            <p class="match-abv">FCB - MCI</p>
                            <div class="match-info">
                                <img src="./assets/icons/fc-barcelona-logo.png" class="match-team-logo">
                                <div class="match-score">8:3</div>
                                <img src="./assets/icons/Manchester_City_FC_badge.svg" class="match-team-logo">
                            </div>
                            <a href="#">Voir les Highlights</a>
                        </div>
                        <div class="match-card">
                            <div class="match-card-options">
                                <div class="match-card-option">
                                    <h3>Resultat</h3>
                                </div>
                                <div class="match-card-option  active-card-option">
                                    <h3>Stats</h3>
                                </div>
                            </div>
                            <p class="match-abv">RM - PSG</p>
                            <div class="match-info">
                                <img src="./assets/icons/psg.png" class="match-team-logo">
                                <div class="match-score">2:1</div>
                                <img src="./assets/icons/real.png" class="match-team-logo">
                            </div>
                            <a href="#">Voir les Highlights</a>
                        </div>
                        <div class="match-card">
                            <div class="match-card-options">
                                <div class="match-card-option active-card-option">
                                    <h3>Resultat</h3>
                                </div>
                                <div class="match-card-option">
                                    <h3>Stats</h3>
                                </div>
                            </div>
                            <p class="match-abv">OL - MCI</p>
                            <div class="match-info">
                                <img src="./assets/icons/580b57fcd9996e24bc43c4d3.png" class="match-team-logo">
                                <div class="match-score">1:4</div>
                                <img src="./assets/icons/Manchester_City_FC_badge.svg" class="match-team-logo">
                            </div>
                            <a href="#">Voir les Highlights</a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="panel-1-2">
                <h1 class="bg-title">Kylian<br>MBAPPE</h1>
                <img src="./assets/images/mbappe_banner_01.png" alt="">
                <div class="panel-stats">
                    <div class="panel-stat">
                        <p>Matchs</p>
                        <h2>31</h2>
                    </div>
                    <div class="panel-stat">
                        <p>Buts</p>
                        <h2>27</h2>
                    </div>
                    <div class="panel-stat">
                        <p>P.D</p>
                        <h2>7</h2>
                    </div>
                </div>
            </div>

            <div class="panel-1-3">
                <div class="chat-container">
                    <i class="fas fa-times chat-close"></i>
                    <h2 class="chat-title">Chat</h2>
                    <div class="chat-content">
                        <div class="chat-message">
                            <img src="https://besthqwallpapers.com/Uploads/15-2-2019/80626/thumb2-levi-ackerman-darkness-attack-on-titan-levi-artwork.jpg" class="message-profile-picture"></img>
                            <div class="message-body">
                                <h3>Levi</h3>
                                <p>Ora ora...</p>
                            </div>
                        </div>
                        <div class="chat-message">
                            <img src="https://besthqwallpapers.com/Uploads/15-2-2019/80626/thumb2-levi-ackerman-darkness-attack-on-titan-levi-artwork.jpg" class="message-profile-picture"></img>
                            <div class="message-body">
                                <h3>Levi</h3>
                                <p>EH !</p>
                            </div>
                        </div>
                        <div class="chat-message">
                            <img src="https://besthqwallpapers.com/Uploads/15-2-2019/80626/thumb2-levi-ackerman-darkness-attack-on-titan-levi-artwork.jpg" class="message-profile-picture"></img>
                            <div class="message-body">
                                <h3>Levi</h3>
                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero, assumenda tenetur in repudiandae suscipit illo saepe fugiat quia debitis temporibus alias rem sequi animi perspiciatis id corrupti at aliquid quae!</p>
                            </div>
                        </div>
                    </div>
                    <div class="chat-inputs">
                        <i class="fas fa-paperclip attach"></i>
                        <input id="chat-input" type="text" placeholder="Envoyer un message">
                        <i class="fas fa-paper-plane send"></i>
                    </div>
                </div>

                <div class="mini-news-container">
                    <?php


                    $articles = getDataFrom('articles');

                    foreach (array_reverse($articles) as $article) {
                        echo '<div class="mini-news">
                        <h4>' . $article['title'] .  '</h4>
                        <img src="' . 'uploads/' . $article['title'] . '/' . $article['image'] . '" alt="" srcset="">
                    </div>';
                    }




                    ?>
                    <div class="mini-news">
                        <h4>Mbappé en couple avec Neymar ? </h4>
                        <img src="https://imgresizer.eurosport.com/unsafe/1200x0/filters:format(jpeg):focal(948x578:950x576)/origin-imgresizer.eurosport.com/2020/12/17/2956970-60695328-2560-1440.jpg" alt="" srcset="">
                    </div>
                    <div class="mini-news">
                        <h4>Paul Pogba sort son album de rap</h4>
                        <img src="https://images.daznservices.com/di/library/GOAL/8e/6c/paul-pogba-manchester-united_ssc49lp07z301dzqds1s9y65x.jpg?t=1689427440&quality=100" alt="" srcset="">
                    </div>
                    <div class="mini-news">
                        <h4>TRANQUILO DE QUOI ?!</h4>
                        <img src="https://images2.minutemediacdn.com/image/upload/c_fill,w_1200,h_630,f_auto,q_auto,g_auto/shape/cover/sport/fc-barcelona-v-borussia-dortmund-group-f-uefa-champions-league-5e9019ca4bb6e9e4c2000001.jpg" alt="" srcset="">
                    </div>
                    <div class="mini-news">
                        <h4>Cristiano Ronaldo propose un tête à Messi</h4>
                        <img src="https://www.leparisien.fr/resizer/5RLD5pTFw9Uv4N2y2NZMXwVRqNQ=/932x582/cloudfront-eu-central-1.images.arcpublishing.com/leparisien/ODFDKMLMPADW2OW4HSNAI2ZGPA.jpg" alt="" srcset="">
                    </div>
                </div>
            </div>

            <div class="panel-down-arrow">
                <i class="fas fa-chevron-down"></i>
            </div>

        </div>


        <div id="events">

            <div class="event">
                <div class="time">
                    <h3>DIM 23 MAI 2021</h3>
                    <p>17:00</p>
                </div>
                <div class="details">
                    <div class="detail">
                        <p>18'</p>
                        <p>Jamie Vardy</p><img src="./assets/images/penalty.svg" alt="" style="height:30px">
                    </div>
                    <div class="detail">
                        <p>24'</p>
                        <p>Jamie Vardy</p><img src="./assets/images/goal.svg" alt="" style="height:30px">
                    </div>
                    <div class="detail">
                        <p>56'</p>
                        <p>Jamie Vardy</p><img src="./assets/images/yellow.svg" alt="" style="height:30px">
                    </div>
                    <div class="detail">
                        <p>56'</p>
                        <p>Jamie Vardy</p><img src="./assets/images/yellow.svg" alt="" style="height:30px">
                    </div>
                    <div class="detail">
                        <p>56'</p>
                        <p>Jamie Vardy</p><img src="./assets/images/yellow.svg" alt="" style="height:30px">
                    </div>
                    <div class="detail">
                        <p>90' +3'</p>
                        <p>Jamie Vardy</p><img src="./assets/images/goal.svg" alt="" style="height:30px">
                    </div>
                </div>
                <div class="team">
                    <h3>Tottenham</h3><img src="https://a.espncdn.com/i/teamlogos/soccer/500/367.png" alt="">
                </div>
                <div class="score"><span>4</span><span>-</span><span>2</span></div>
                <div class="team"><img src="https://a.espncdn.com/i/teamlogos/soccer/500/375.png" alt="">
                    <h3>Leicester City</h3>
                </div>
                <div class="clock">
                    <h3>90'+7'</h3><span>2</span>
                </div>
            </div>

        </div>

</main>


<script src="./scripts/news.js"></script>

<?php include 'includes/footer.php';
