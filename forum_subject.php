<?php session_start();

include 'includes/database_handler.php';

$q =
    'SELECT *,
    forum_subjects.last_activity as f_last_activity,
    forum_subjects.id as f_id
    FROM forum_subjects
    INNER JOIN users
    ON forum_subjects.author = users.id
    WHERE forum_subjects.id = :id;';
$stmt = $dbh->prepare($q);
$status = $stmt->execute(
    array(
        'id' => $_GET['id']
    )
);

setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
date_default_timezone_set('Europe/Paris');

if ($status) {
    $forum = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
}

$title = 'Forum : ' . $forum['title'];
include 'includes/head.php';
include 'includes/header.php';

?>

<div class="forum-subject-container">

    <p class="forum-subject-id">
        id : <span id="id"><?php echo $forum['f_id']; ?></span>
    </p>

    <div id="forum-subject">
        <div class="forum-subject-header">
            <div class="forum-subject-pfp">
                <?php echo '<img src="uploads/' . $forum['pseudo'] . '/' . $forum['profile_picture'] . '" alt="profile_picture"/>'; ?>
                <p>Score : <span class="score">761</span></p>
            </div>
            <div class="forum-subject-title">
                <h1><?php echo $forum['title']; ?></h1>
                <p>Par <?php echo $forum['pseudo']; ?> - <spanc class="green">abonné</spanc> - <?php echo utf8_encode(strftime('%A %d %B %Y, %H:%M', $forum['f_last_activity'] - (12 * 3600))) ?></p>
            </div>
            <?php

            if (isset($_SESSION['uid'])) {
                $q = 'SELECT COUNT(*) as cnt FROM forum_saved WHERE forum = :forum AND user = :user;';
                $stmt = $dbh->prepare($q);
                $status = $stmt->execute(
                    array(
                        'forum' => $_GET['id'],
                        'user' => $_SESSION['uid']
                    )
                );
                if ($status) {
                    $forumSaved = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($forumSaved['cnt'] > 0) {
                        echo '<i id="bookmark" class="fas fa-bookmark"></i>';
                    } else {
                        echo '<i id="bookmark" class="far fa-bookmark"></i>';
                    }
                } else {
                    echo '<i id="bookmark" class="far fa-bookmark"></i>';
                }
            }
            ?>
        </div>
        <div class="forum-subject-content">
            <?php echo '<p>' . $forum['content'] . '</p>'; ?>
        </div>
        <div class="forum-subject-actions">
            <?php
            if (isset($_SESSION['uid']) && getForumLiked($_GET['id'], $_SESSION['uid']))
                echo '<div class="action likes active" style="color: rgb(15, 187, 58);">';
            else
                echo '<div class="action likes">';
            ?>
            <i class="fas fa-thumbs-up"></i>
            <span id="likes-value"><?php echo getForumLikes($_GET['id']); ?></span>
        </div>
        <?php
        if (isset($_SESSION['uid']) && getForumLiked($_GET['id'], $_SESSION['uid'], -1))
            echo '<div class="action dislikes active" style="color: rgb(255, 34, 34);">';
        else
            echo '<div class="action dislikes">'
        ?>
        <i class="fas fa-thumbs-down"></i>
        <span id="dislikes-value"><?php echo -getForumLikes($_GET['id'], -1); ?></span>
    </div>
    <div class="action reply">
        <i class="fas fa-reply"></i>
        <span>Répondre</span>
    </div>
    <?php
    if (isset($_SESSION['uid']) &&  $forum['author'] == $_SESSION['uid']) {
        echo '<div class="action edit">
                <i class="fas fa-edit"></i>
                <span>Modifier</span>
            </div>';
        echo '<div class="action close">
                <i class="fas fa-door-closed"></i>
                <span>Fermer</span>
            </div>';
        echo '<div class="action delete">
                <i class="fas fa-times"></i>
                <span>Supprimer</span>
            </div>';
    }
    ?>

</div>

<div class="forum-reactions-container">

    <div class="forum-reactions-header">
        <h2>RÉACTIONS <span id="reactions-cnt">7</span></h2>
    </div>

    <div class="forum-reactions-filter">
        <select name="reactions-filter" id="reactions-filter">
            <option value="0" selected disabled>Trier les commentaires</option>
            <option value="1">Plus ancient</option>
            <option value="2">Plus récent</option>
            <option value="3">Top commentaires</option>
        </select>
    </div>

    <div class="forum-reactions">

        <?php


        $q = 'SELECT *, reactions.id as r_id FROM reactions
            INNER JOIN users
            ON reactions.user = users.id
            WHERE forum = :forum;';
        $stmt = $dbh->prepare($q);
        $status = $stmt->execute(
            array(
                'forum' => $_GET['id']
            )
        );

        if ($status) {
            $reactions = $stmt->fetchAll(PDO::FETCH_ASSOC);



            foreach ($reactions as $reaction) {

                echo '<div class="forum-reaction">
    <div class="reaction-pfp">
        <img src="uploads/' . $reaction['pseudo']  . '/' . $reaction['profile_picture'] . '" alt="pfp">
        <p>Score : <span class="score">761</span></p>
    </div>
    <div class="reaction-body">
        <div class="reaction-author">
            <p>' .  $reaction['pseudo'] . '- <span class="green">abonné</span> - ' . utf8_encode(strftime('%A %d %B %Y, %H:%M', $reaction['date'] - (12 * 3600))) . '</p>
        </div>
        <div class="reaction-content">
            <p>' . $reaction['reaction'] . '</p>
        </div>



        <div class="forum-reactions-actions">';
                if (isset($_SESSION['uid']) &&  getReactionLiked($reaction['r_id'], $_SESSION['uid']))
                    echo '<div class="action likes active" style="color: rgb(15, 187, 58);">';
                else
                    echo '<div class="action likes">';
                echo '<i class="fas fa-thumbs-up"></i>
            <span id="likes-value">' . getReactionLikes($reaction['r_id']) . '</span>
        </div>';

                if (isset($_SESSION['uid']) &&  getReactionLiked($reaction['r_id'], $_SESSION['uid'], -1))
                    echo '<div class="action dislikes active" style="color: rgb(255, 34, 34);">';
                else
                    echo '<div class="action dislikes">
                    <i class="fas fa-thumbs-down"></i>
        <span id="dislikes-value">' . -getReactionLikes($reaction['r_id'], -1) . '</span>
    </div>
    <div class="action reply">
        <i class="fas fa-reply"></i>
        <span>Répondre</span>
    </div>';
                if (isset($_SESSION['uid']) &&  $forum['author'] == $_SESSION['uid']) {
                    echo '<div class="action edit">
                <i class="fas fa-edit"></i>
                <span>Modifier</span>
            </div>';
                    echo '<div class="action delete">
                <i class="fas fa-times"></i>
                <span>Supprimer</span>
            </div>';
                }
                echo '</div>
</div>
</div>';
            }
        }

        ?>


    </div>
</div>
<?php

if (isset($_SESSION['uid'])) {

    if (isset($_SESSION['status']) && $_SESSION['status'] != 0) {
        echo '<div class="forum-react">
    <div class="forum-reactions-header">
        <h2>RÉAGIR À CE SUJET</h2>
    </div>
    <div class="forum-react-body">
        <form action="reaction_check.php?id=' . $_GET['id'] . '" method="POST">
            <textarea name="reaction" id="" cols="105" rows="10"></textarea>
            <button name="submit">POSTER</button>
        </form>
    </div>
</div>';
    } else {
        echo '<h2 class="red">Vérifiez votre compte pour réagir à ce sujet.</h2>';
    }
} else {
    echo '<a href="login.php"><h2 class="red">Connectez vous pour réagir à ce sujet.</h2></a>';
} ?>
</div>


<script src="scripts/forum_subject.js"></script>
