<?php

include 'includes/functions.php';

?>
<header>

 <?php

    if (isset($_SESSION['status']) && $_SESSION['status'] == 0 && isset($_GET['blockunverified'])) {
        echo '<div id="overlay-alert-container">
                    <div id="overlay-alert" class="overlay-warning">
            <i id="overlay-alert-close" class="fas fa-times"></i>
            <h1 id="overlay-alert-title">Halte !</h1>
            <p id="overlay-alert-message">Un mail de confirmation vous à été adresser, merci de confirmer votre compte afin de profiter de vos nouveaux avantages <span class="blue">MY</span><span class="red">TEAM</span></p>
        </div>
        </div>';
    }

    if (isset($_GET['code'])) {
        switch ($_GET['code']) {
            case 'usercreated':
                echo '<div id="overlay-alert-container">
                    <div id="overlay-alert" class="overlay-warning">
            <i id="overlay-alert-close" class="fas fa-times"></i>
            <h1 id="overlay-alert-title">Dernière étape !</h1>
            <p id="overlay-alert-message">Un mail de confirmation vous à été adresser, merci de confirmer votre compte afin de profiter de vos nouveaux avantages <span class="blue">MY</span><span class="red">TEAM</span></p>
        </div>
        </div>';
		break;
		case 'unverifieduser':
                echo '<div id="overlay-alert-container">
                    <div id="overlay-alert" class="overlay-warning">
            <i id="overlay-alert-close" class="fas fa-times"></i>
            <h1 id="overlay-alert-title">Rappel !</h1>
            <p id="overlay-alert-message">Un mail de confirmation vous à été adresser, merci de confirmer votre compte afin de profiter de vos nouveaux avantages <span class="blue">MY</span><span class="red">TEAM</span></p>
        </div>
        </div>';
		break;
	case 'useractivated':
                echo '<div id="overlay-alert-container">
                    <div id="overlay-alert" class="overlay-good">
            <i id="overlay-alert-close" class="fas fa-times"></i>
            <h1 id="overlay-alert-title">Bravo !</h1>
            <p id="overlay-alert-message">Nous vous remercions d\'avoir valider votre inscription à <span class="blue">MY</span><span class="red">TEAM</span><br>À bientôt dans les forums</p>
        </div>
        </div>';
                break;
            case 'useralreadyactivated':
                echo '<div id="overlay-alert-container">
                    <div id="overlay-alert" class="overlay-mid">
            <i id="overlay-alert-close" class="fas fa-times"></i>
            <h1 id="overlay-alert-title">😁 Merci mais...</h1>
            <p id="overlay-alert-message">Il semblerait que vous ayez déjà confirmer votre inscription.</p>
        </div>
        </div>';
                break;
        }
    }

    ?>

    <div class="fader"></div>

    <nav>

        <a href="index.php"><img src="./assets/images/logo.png" alt="" id="nav-logo"></a>

        <div class="searchbar-container">
            <input type="text" id="searchbar" placeholder="Tappez quelques chose...">
            <div id="auto-complete">


            </div>
        </div>

        <ul class="nav-links">

            <li><a href="home" class="nav-link">Acceuil</a></li>
            <li><a href="tous-les-articles" class="nav-link">News</a></li>
	    <?php echo (isset($_SESSION['uid']) ? '<li><a id="nav-joueur" href="inventaire" class="nav-link"><span class="red">MY</span><span class="blue">TEAM</span> Collection</a></li>' : ''); ?>
	    <li><a href="evenements" class="nav-link">Evénements</a></li>
	    <li><a href="forum" class="nav-link">Forum</a></li>
            <?php echo !isset($_SESSION['uid']) ?
	    	' <li><a href="connexion" class="nav-link">Se connecter</a></li>
		 <li><a href="inscription" class="nav-link">S\'inscrire</a></li>'
                :
                // '<li><a href="logout.php" id="live-status" class="nav-link">Live •</a></li>';
                ' <li><a href="logout.php" class="nav-link">Se deconnecter</a></li>'
            ?>
        </ul>

	<?php

        if (isset($_SESSION['uid'])) {

            $userPfp = getDataByID($_SESSION['uid'], 'profile_picture')[0]['profile_picture'];

            if ($userPfp == null) {
                echo '<div class="nav-profile">
            <div id="nav-profile-picture-temp">' . strtoupper($_SESSION['username'][0]) .  '</div>
            <i class="fas fa-angle-down"></i>
        </div>';
            } else {
                echo '<div class="nav-profile">
            <img id="nav-profile-picture" src="uploads/' . $_SESSION['username']  . '/' .  $userPfp . '" alt="profile picture" srcset="">
            <i class="fas fa-angle-down"></i>
        </div>';
            }
        } ?>
       
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
			 <?php
                if ($userPfp == null) {
                    echo '<div id="menu-profile-picture-temp">' . strtoupper($_SESSION['username'][0]) . '</div>';
                } else {

                    echo '<img src="uploads/' . $_SESSION['username']  . '/' .  $userPfp . '" alt="profile picture" srcset="">';
		}?>

                	       
		       <form action="change_picture.php" method="POST" enctype="multipart/form-data">
                    <label for="pfp-input">Changer la photo de profil</label>
                    <input id="pfp-input" name="image" type="file" accept="image/*">
                    <button type="submit" id="change-picture" name="submit">Change</button>
                </form>
                <h3><?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] : 'temp_user'; ?></h3>
                <p>@<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'temp_user'; ?></p>
            </div>
            <div class="profile-stats">
                <?php

                if (isset($_SESSION['uid'])) {

                    $user = getDataByID($_SESSION['uid'])[0];

                    echo '<div class="profile-stat">
                    <h3>' . getUserForumCount($_SESSION['uid']) . '</h3>
                    <p>Forums</p>
                </div>
                <div class="profile-stat">
                    <h3>' . getUserScore($_SESSION['uid']) . '</h3>
                    <p>Score</p>
                </div>
                <div class="profile-stat">
                    <h3>' . (isset($_SESSION['uid']) ? $user['team_overall'] : '') . '</h3>
                    <p>Team</p>
                </div>';
                }
                ?>
            </div>
        </div>
        <div class="menu-options">
            <!-- <div class="menu-option">
                <i class="fas fa-user"></i>
                <h3>Mon Compte</h3>
            </div> -->
            <a href="inventory.php?active=inventory">
                <div class="menu-option <?= (isset($_GET['active']) && $_GET['active'] == 'inventory' ? ' highlighted-menu' : '') ?>">
                    <i class="fas fa-user"></i>
                    <h3>Mon Inventaire</h3>
                </div>
            </a>
            <a href="shop.php?active=shop">
                <div class="menu-option <?= (isset($_GET['active']) && $_GET['active'] == 'shop' ? ' highlighted-menu' : '') ?>">
                    <i class="fas fa-basketball-ball"></i>
                    <h3>Shop <span class="red">MY</span><span class="blue">TEAM</span>
                    </h3>
                </div>
            </a>
        </div>
        <?php
        if (isset($_SESSION['role']) && $_SESSION['role'] == 2) {
            echo '<div class="menu-option ' . (isset($_GET['active']) && $_GET['active'] == 'publish_article' ? ' highlighted-menu' : '')  . '">
                <i class="fas fa-pen"></i>
                <h3><a href="publish_article.php?active=publish_article&action=create">Publier un article</a></h3>
            </div>';
        } ?>
        <a href="articles.php?active=articles">
            <div class="menu-option <?= (isset($_GET['active']) && $_GET['active'] == 'articles' ? ' highlighted-menu' : '') ?>">
                <i class="fas fa-list-alt"></i>
                <h3>Actualités</h3>
            </div>
        </a>
        <a href="forums.php?active=forums">
            <div class="menu-option <?= (isset($_GET['active']) && $_GET['active'] == 'forums' ? ' highlighted-menu' : '') ?>">
                <i class="fas fa-comment"></i>
                <h3>Forum</h3>
            </div>
        </a>
        <div class="menu-option <?= (isset($_GET['active']) && $_GET['active'] == 'ladder' ? ' highlighted-menu' : '') ?>">
            <i class="fas fa-futbol"></i>
            <h3><a href="ladder.php?active=ladder">Classement</a></h3>
        </div>
        <div class="menu-option">
            <i class="fas fa-shopping-cart"></i>
            <h3>S'abonner</h3>
        </div>
    </div>
    <!-- <div class="favorites ">
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
        </div> -->
    </div>



</header>
<script src="scripts/searchbar.js"></script>
