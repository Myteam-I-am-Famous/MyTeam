<?php

// include 'database_handler.php';


$dbname = "myteam_rebuild";
$host = 'localhost';
$dsn = "mysql:dbname=" . $dbname . ";host=" . $host;

$user = "myteam";
$password = "myteam";

try {
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
    die();
}


function getProfilePictureSrc($uid)
{
    global $dbh;

    $q = 'SELECT profile_picture FROM users WHERE id = :id;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'id' => $uid
        )
    );
    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['profile_picture']) {

            return $result['profile_picture'];
        }
    }

    return false;
}
?>
<header>

	<div class="fader"></div>

    <nav>
        <div class="nav-search">
            <img id="nav-logo" src="assets/images/logo.png" alt="logo" srcset="">
            <input type="text" id="nav-searchbar" placeholder="Search">

        </div>

        <ul class="nav-links">

            <li><a href="index.php" class="nav-link">Acceuil</a></li>
            <li><a href="#" class="nav-link">News</a></li>
            <li><a id="nav-joueur" href="#" class="nav-link">Joueurs</a></li>
            <li><a href="signup.php" class="nav-link">Classements(signup_temp)</a></li>
            <li><a href="login.php" class="nav-link">S'abonner(login_temp)</a></li>
            <li><a href="logout.php" id="live-status" class="nav-link">Live ·(logout_temp)</a></li>
        </ul>


        <?php


        echo isset($_SESSION['uid']) ? "<p>Uid : " . $_SESSION['uid'] . "</p>" : "Logged out";

        ?>


        <div class="nav-profile">
<img id="nav-profile-picture" src="<?php echo isset($_SESSION['uid']) ? 'uploads/' . $_SESSION['username']  . '/' .  getProfilePictureSrc($_SESSION['uid']) : 'https://besthqwallpapers.com/Uploads/15-2-2019/80626/thumb2-levi-ackerman-darkness-attack-on-titan-levi-artwork.jpg' ?>" alt="profile picture" srcset="">	   
	       <i class="fas fa-angle-down"></i>
        </div>

    </nav>

    <div id="menu">
        <div id="menu-cls-btn">
            <i class="fas fa-times"></i>
        </div>
        <div class="menu-title">
            <h1><span class="white">My</span><span class="yellow">Team</span></h1>
        </div>
        <div class="menu-profile">
            <div class="profile-info">
                <img src="<?php echo isset($_SESSION['uid']) ? 'uploads/' . $_SESSION['username']  . '/' .  getProfilePictureSrc($_SESSION['uid']) : 'https://besthqwallpapers.com/Uploads/15-2-2019/80626/thumb2-levi-ackerman-darkness-attack-on-titan-levi-artwork.jpg' ?>" alt="profile picture" srcset="">
                <form action="change_picture.php" method="POST" enctype="multipart/form-data">
                    <label for="pfp-input">Changer la photo de profil</label>
                    <input id="pfp-input" name="image" type="file" accept="image/*">
                    <button type="submit" id="change-picture" name="submit">Change</button>
                </form>
                <h3>Belzebvb</h3>
                <p>@mt-belzebvb</p>
            </div>
            <div class="profile-stats">
                <div class="profile-stat">
                    <h3>2445</h3>
                    <p>Amis</p>
                </div>
                <div class="profile-stat">
                    <h3>400</h3>
                    <p>Posts</p>
                </div>
                <div class="profile-stat">
                    <h3>89</h3>
                    <p>Rang</p>
                </div>
            </div>
        </div>
        <div class="menu-options">
            <div class="menu-option">
                <i class="fas fa-user"></i>
                <h3>Mon Compte</h3>
            </div>
            <div class="menu-option highlighted-menu">
                <i class="fas fa-user"></i>
		<h3><a href="inventory.php?display=table">Mon Inventaire</a></h3>
	    </div>
            <div class="menu-option">
                <i class="fas fa-basketball-ball"></i>
		<h3><a href="pack_card.php?display=table">Packer des cartes</a></h3>
	    </div>
            <div class="menu-option">
                <i class="fas fa-list-alt"></i>
                <h3>Actualités</h3>
            </div>
            <div class="menu-option">
                <i class="fas fa-comments"></i>
                <h3>Discussion</h3>
            </div>
            <div class="menu-option">
                <i class="fas fa-history"></i>
                <h3>Historique</h3>
            </div>
            <div class="menu-option">
                <i class="fas fa-shopping-cart"></i>
                <h3>Magasin</h3>
            </div>
        </div>
        <div class="favorites ">
            <div class="fav-title highlighted-menu">
                <h3>Clubs Favoris</h3>
                <i class="fas fa-plus"></i>
            </div>
            <div class="teams">

                <div class="team">
                    <img class="menu-team-logo" src="./assets/icons/Manchester_City_FC_badge.svg" alt="team logo" srcset="">
                    <h4>Manchester City</h4>
                </div>
                <div class="team">
                    <img class="menu-team-logo" src="./assets/icons/Manchester_City_FC_badge.svg" alt="team logo" srcset="">
                    <h4>Tottenham Hotspur</h4>
                </div>
                <div class="team">
                    <img class="menu-team-logo" src="./assets/icons/Manchester_City_FC_badge.svg" alt="team logo" srcset="">
                    <h4>Paris Saint Germain</h4>
                </div>

                <button class="view-more">View More</button>

            </div>
        </div>

        <div class="saved">
            <div class="saved-title highlighted-menu">
                <h3>Saved Match</h3>
                <i class="fas fa-plus"></i>
            </div>
            <div class="saved-matches">
                <div class="saved-match">
                    <img src="./assets/icons/Manchester_City_FC_badge.svg" class="menu-team-logo" alt="ext" class="ext">
                    <h4 class="score">2-1</h4>
                    <img src="./assets/icons/Manchester_City_FC_badge.svg" class="menu-team-logo" alt="int" class="int">
                    <h4 class="match-abv">MCI - RFC</h4>
                    <h4 class="match-status">Live '56</h4>
                </div>
                <div class="saved-match">
                    <img src="./assets/icons/Manchester_City_FC_badge.svg" class="menu-team-logo" alt="ext" class="ext">
                    <h4 class="score">7-1</h4>
                    <img src="./assets/icons/Manchester_City_FC_badge.svg" class="menu-team-logo" alt="int" class="int">
                    <h4 class="match-abv">TOT - LMM</h4>
                    <h4 class="match-status">SAT</h4>
                </div>

                <button class="view-more">View More</button>

            </div>
        </div>
    </div>



</header>
