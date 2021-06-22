<?php session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'includes/functions.php';

if (
    isset($_GET['type']) && !empty($_GET['type'])
    &&  isset($_GET['request']) && !empty($_GET['request'])
) {
    if ($_GET['type'] == "subject") {
        switch ($_GET['request']) {
            case 'bookmark':
                if (isset($_GET['status']) && !empty($_GET['status'])) {

                    if ($_GET['status'] === "true") {
                        $q = 'INSERT INTO forum_saved
                (
                    id,
                    forum,
                    user
                )
                VALUES
                (
                    :id,
                    :forum,
                    :user
                );';

                        $stmt = $dbh->prepare($q);
                        $status = $stmt->execute(
                            array(
                                'id' => getMaxID('forum_saved') + 1,
                                'forum' => $_GET['forum'],
                                'user' => $_SESSION['uid']
                            )
                        );

                        echo json_encode([
                            'status' => $_GET['status'],
                            'message' => 'forum saved'
                        ]);
                        exit;
                    } else {
                        $q = 'DELETE FROM forum_saved
                WHERE
                forum = :forum
                AND
                user = :user;';

                        $stmt = $dbh->prepare($q);
                        $status = $stmt->execute(
                            array(
                                'forum' => $_GET['forum'],
                                'user' => $_SESSION['uid']
                            )
                        );

                        echo json_encode([
                            'status' => $_GET['status'],
                            'message' => 'forum unsaved'
                        ]);
                        exit;
                    }
                }
                break;
            case 'like':
                $q = 'SELECT * FROM forum_likes_dislikes
                WHERE user = :user
                AND forum = :forum;';
                $stmt = $dbh->prepare($q);
                $status = $stmt->execute(
                    array(
                        'user' => $_SESSION['uid'],
                        'forum' => $_GET['forum']
                    )
                );

                if ($status) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);


                    if ($result) {
                        $value = $result['value'] == 1 ? 0 : 1;
                        $q = 'UPDATE forum_likes_dislikes
                    SET value = :value
                    WHERE user = :user;';
                        $stmt = $dbh->prepare($q);
                        $status = $stmt->execute(
                            array(
                                'value' => $value,
                                'user' => $_SESSION['uid']
                            )
                        );
                        if ($status) {
                            echo json_encode([
                                'status' => $status,
                                'value' => $value,
                                'message' => 'updated likes'
                            ]);
                            exit;
                        }
                    } else {

                        $q = 'INSERT INTO forum_likes_dislikes
                    (
                        id,
                        value,
                        user,
                        forum
                    )
                    VALUES
                    (
                        :id,
                        :value,
                        :user,
                        :forum
                    );';
                        $stmt = $dbh->prepare($q);
                        $status = $stmt->execute(
                            array(
                                'id' => getMaxID('forum_likes_dislikes') + 1,
                                'value' => 1,
                                'user' => $_SESSION['uid'],
                                'forum' => $_GET['forum']
                            )
                        );

                        echo json_encode([
                            'status' => $status,
                            'result' => $result,
                            'value' => 1,
                            'message' => 'liked a post'
                        ]);
                        exit;
                    }
                }

                break;
            case 'dislike':
                $q = 'SELECT * FROM forum_likes_dislikes
                WHERE user = :user
                AND forum = :forum;';
                $stmt = $dbh->prepare($q);
                $status = $stmt->execute(
                    array(
                        'user' => $_SESSION['uid'],
                        'forum' => $_GET['forum']
                    )
                );

                if ($status) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);


                    if ($result) {
                        $value = $result['value'] == -1 ? 0 : -1;
                        $q = 'UPDATE forum_likes_dislikes
                    SET value = :value
                    WHERE user = :user;';
                        $stmt = $dbh->prepare($q);
                        $status = $stmt->execute(
                            array(
                                'value' => $value,
                                'user' => $_SESSION['uid']
                            )
                        );
                        if ($status) {
                            echo json_encode([
                                'status' => $status,
                                'value' => $value,
                                'message' => 'updated dislikes'
                            ]);
                            exit;
                        }
                    } else {

                        $q = 'INSERT INTO forum_likes_dislikes
                    (
                        id,
                        value,
                        user,
                        forum
                    )
                    VALUES
                    (
                        :id,
                        :value,
                        :user,
                        :forum
                    );';
                        $stmt = $dbh->prepare($q);
                        $status = $stmt->execute(
                            array(
                                'id' => getMaxID('forum_likes_dislikes') + 1,
                                'value' => -1,
                                'user' => $_SESSION['uid'],
                                'forum' => $_GET['forum']
                            )
                        );

                        echo json_encode([
                            'status' => $status,
                            'value' => -1,
                            'message' => 'disliked a post'
                        ]);
                        exit;
                    }
                }

                break;
        }
    } else if ($_GET['type'] == 'reaction') {
        switch ($_GET['request']) {
            case 'like':
                $q = 'SELECT * FROM reaction_likes_dislikes
                WHERE user = :user
                AND reaction = :reaction;';
                $stmt = $dbh->prepare($q);
                $status = $stmt->execute(
                    array(
                        'user' => $_SESSION['uid'],
                        'reaction' => $_GET['reaction']
                    )
                );

                if ($status) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);


                    if ($result) {
                        $value = $result['value'] == 1 ? 0 : 1;
                        $q = 'UPDATE reaction_likes_dislikes
                    SET value = :value
                    WHERE user = :user;';
                        $stmt = $dbh->prepare($q);
                        $status = $stmt->execute(
                            array(
                                'value' => $value,
                                'user' => $_SESSION['uid']
                            )
                        );
                        if ($status) {
                            echo json_encode([
                                'status' => $status,
                                'value' => $value,
                                'message' => 'updated likes'
                            ]);
                            exit;
                        }
                    } else {

                        $q = 'INSERT INTO reaction_likes_dislikes
                    (
                        id,
                        value,
                        user,
                        reaction
                    )
                    VALUES
                    (
                        :id,
                        :value,
                        :user,
                        :reaction
                    );';
                        $stmt = $dbh->prepare($q);
                        $status = $stmt->execute(
                            array(
                                'id' => getMaxID('reaction_likes_dislikes') + 1,
                                'value' => 1,
                                'user' => $_SESSION['uid'],
                                'reaction' => $_GET['reaction']
                            )
                        );

                        echo json_encode([
                            'status' => $status,
                            'result' => $result,
                            'value' => 1,
                            'message' => 'liked a post'
                        ]);
                        exit;
                    }
                }

                break;
            case 'dislike':
                $q = 'SELECT * FROM reaction_likes_dislikes
                WHERE user = :user
                AND reaction = :reaction;';
                $stmt = $dbh->prepare($q);
                $status = $stmt->execute(
                    array(
                        'user' => $_SESSION['uid'],
                        'reaction' => $_GET['reaction']
                    )
                );

                if ($status) {
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);


                    if ($result) {
                        $value = $result['value'] == -1 ? 0 : -1;
                        $q = 'UPDATE reaction_likes_dislikes
                    SET value = :value
                    WHERE user = :user;';
                        $stmt = $dbh->prepare($q);
                        $status = $stmt->execute(
                            array(
                                'value' => $value,
                                'user' => $_SESSION['uid']
                            )
                        );
                        if ($status) {
                            echo json_encode([
                                'status' => $status,
                                'value' => $value,
                                'message' => 'updated dislikes'
                            ]);
                            exit;
                        }
                    } else {

                        $q = 'INSERT INTO reaction_likes_dislikes
                    (
                        id,
                        value,
                        user,
                        reaction
                    )
                    VALUES
                    (
                        :id,
                        :value,
                        :user,
                        :reaction
                    );';
                        $stmt = $dbh->prepare($q);
                        $status = $stmt->execute(
                            array(
                                'id' => getMaxID('reaction_likes_dislikes') + 1,
                                'value' => -1,
                                'user' => $_SESSION['uid'],
                                'reaction' => $_GET['reaction']
                            )
                        );

                        echo json_encode([
                            'status' => $status,
                            'value' => -1,
                            'message' => 'disliked a post'
                        ]);
                        exit;
                    }
                }

                break;
        }
    }

    echo json_encode([
        'status' => $_GET['status'],
        'message' => 'could not save/unsave forum'
    ]);
    exit;
}
