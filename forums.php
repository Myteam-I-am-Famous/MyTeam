<?php session_start();
$title = "Forum";

include 'includes/head.php';
include 'includes/header.php'; ?>


<main>


    <div id="forum">
        <h1>MyTEAM Forum</h1>

        <div class="forum-banner">
            <div class="forum-banner-bg"></div>
            <?php

            if (!isset($_SESSION['uid'])) {

                echo '<h3>Bienvenue dans notre communauté</h3>
            <p>Vous voulez participer aux discussions et joindre les autres utilisateurs ? Inscrivez vous c\'est gratuit </p>
            <a href="inscription"><button class="sign-btn">Inscription</button></a>';
            } else {
                echo '<h2>Envie de vous disputer avec d\'autres membres sur qui est le meilleur joueur de basket ayant jamais existé ?</h2>';
                echo '<a href="creer-un-sujet"><button id="create-forum">Créer une discussion</button></a>';
            }
            ?>
        </div>

        <div class="forum-container">
            <div class="forums-container">


                <div class="forum-categories">
                    <!-- <div class="forums-pinned">
                        <h3>Forums épinglés</h3>
                        <div class="forums">
                            <div class="forum">
                                <i class="fas fa-book read-status red"></i>
                                <p class="forum-title">James Harden surcoté ? <span class="new">new</span></p>
                                <div class="forum-stats">
                                    <p class="forum-message-number">23</p>
                                    <p>Messages</p>
                                </div>
                                <div class="forum-last-activity">
                                    <img src="https://fr.techtribune.net/wp-content/uploads/2020/11/one-piece-trafalgar-law-wano-anime-1246430-1280x0.jpeg" alt="">
                                    <div class="forum-stats">
                                        <p class="forum-last-activity-author">Belzbvb</p>
                                        <p class="forum-last-activity-time">Hier à 22 heures</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <?php


                    $categories = getDataFrom('forum_categories');
                    foreach ($categories as $category) {

                        $categoryName = $category['name'];

                        $q = 'SELECT *, forum_subjects.last_activity as f_last_activity, forum_subjects.id as f_id FROM forum_subjects
                        INNER JOIN forum_categories
                        ON forum_subjects.category = forum_categories.id
                        AND forum_categories.name = "' . $categoryName . '"
                        INNER JOIN users
                        ON forum_subjects.author = users.id;';
                        $stmt = $dbh->prepare($q);
                        $status = $stmt->execute();

                        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
                        date_default_timezone_set('Europe/Paris');

                        if ($status) {
                            $forums = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            // var_dump($forums[0]); 
                            if (count($forums) > 0) {

                                echo '<div class="forum-category">
                        <h3 class="category-name">' . strtoupper($category['name']) . '</h3>';

                                foreach ($forums as $forum) {
                                    echo '<a href="forum-' . $forum['f_id'] . '">
                                            <div class="forum">
                                                <i class="fas fa-book read-status"></i>
                                                <p class="forum-title">' . $forum['title'] . '</p>
                                                <div class="forum-stats">
                                                    <p class="forum-message-number">' . getForumReactionCount($forum['f_id']) . '</p>
                                                    <p>Messages</p>
                                                </div>
                                                <div class="forum-last-activity">
                                                    <img src="uploads/' . $forum['pseudo'] . '/' . $forum['profile_picture'] . '" alt="">
                                                    <div class="forum-stats">
                                                        <p class="forum-last-activity-author">Belzbvb</p>
                                                        <p class="forum-last-activity-time">' . utf8_encode(strftime('%A %d %B %Y, %H:%M', $forum['f_last_activity'] - (12 * 3600))) . '</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>';
                                } //* FIN foreach $forums

                                echo '</div>';
                            }
                        }
                    }

                    ?>
                </div>
            </div>
            <div class="forum-infos">
                <div class="forum-info">
                    <div class="info-header">
                        <i class="fas fa-user"></i>
                        <h3>Membres en lignes</h3>
                        <small id="online-members-cnt">(<?= getUsersStatusCount(3) ?>)</small>
                    </div>

                    <div class="online-members">
                        <?php

                        $connectedUsers = getUsersByStatus(3);
                        if (is_array($connectedUsers)) {
                            foreach ($connectedUsers as $connectedUser) {
                                echo '<div class="online-member">
                            <img src="uploads/' . $connectedUser['pseudo'] . "/" . $connectedUser['profile_picture'] .  '" alt="">
                            <p>' . $connectedUser['pseudo'] . '</p>
                        </div>';
                            }
                        }


                        ?>
                    </div>
                </div>
                <div class="forum-info">
                    <div class="info-header">
                        <div class="fas fa-bookmark"></div>
                        <h3>Forums favoris</h3>
                    </div>
                    <div class="forums-favoris">
                        <?php

                        if (isset($_SESSION['uid'])) {

                            $q = 'SELECT *, forum_subjects.id as f_id FROM forum_saved
                            INNER JOIN forum_subjects
                            ON forum_saved.forum = forum_subjects.id
                            WHERE forum_saved.user = :user;';
                            $stmt = $dbh->prepare($q);
                            $status = $stmt->execute(
                                array(
                                    'user' => $_SESSION['uid']
                                )
                            );

                            if ($status) {
                                $forums_saved = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if (count($forums_saved) > 0) {

                                    foreach ($forums_saved as $forum_saved) {
                                        echo '<a href="forum-' . $forum_saved['f_id'] . '">
                                            <div class="forum-favoris">
                                                <i class="fas fa-book read-status"></i>
                                                <p class="forum-title">' . $forum_saved['title'] . '</p>
                                                <div class="forum-stats">
                                                    <p class="forum-message-number">' . getForumReactionCount($forum_saved['f_id']) . '</p>
                                                    <p>Messages</p>
                                                </div>
                                            </div>
                                        </a>';
                                    }
                                } else {
                                    echo '<p class="green">Ajoutez des forums à vos favoris pour ne pas les perdre de vues!</p>';
                                }
                            }
                        } else {
                            echo '<p class="red">Connectez vous pour avoir accès a vos forums favoris !</p>';
                        }


                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</main>

<?php include 'includes/footer.php'; ?>
