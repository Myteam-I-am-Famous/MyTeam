<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chat</title>
    <link rel="shortcut icon" href="https://upload.wikimedia.org/wikipedia/commons/8/85/Circle-icons-chat.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/chat.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

</head>

<body>

    <div class="container">

        <div id="bg"></div>
        <div class="chat-container">
            <div class="title">
                <i class="fas fa-envelope"></i>
                <h1>Messages</h1>
            </div>

            <div class="conversations">
                <h3 class="title">Conversations</h3>
                <?php



                $q = "SELECT * FROM conversations WHERE user_1 = :user_1 ORDER BY id;";
                $stmt = $dbh->prepare($q);
                $status = $stmt->execute(
                    array(
                        'user_1' => $_SESSION['uid']
                    )
                );
                if ($status) {
                    $conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($conversations as $conversation) {

                        if ($conversation['user_2'] == $_SESSION['uid'])
                            continue;

                        $user = getDataByID($conversation['user_2'])[0];


                        $q = 'SELECT * FROM messages WHERE author = :author ORDER BY time DESC;';
                        $stmt = $dbh->prepare($q);
                        $status = $stmt->execute(
                            array(
                                'author' => $conversation['user_2']
                            )
                        );

                        if ($status) {
                        }

                        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        $lastMesssage = $messages[0];



                        echo '<div class="conversation" id="conversation-' . $user['id'] . '">
                    <img src="uploads/' . $user['pseudo'] . '/' . $user['profile_picture'] . '" alt="" class="user-pfp">
                    <div class="user-info">
                        <h3 class="user-name">' . $user['pseudo'] . '</h3>
                        <div class="user-text-info">
                            <p class="last-text">' . $lastMesssage['message'] . '</p>
                            <p class="time">30 min</p>
                        </div>
                    </div>
                </div>';
                    }
                }

                ?>

            </div>
            <div class="chat">
                <div class="chat-header">
                    <?php

                    $user = getDataByID($_SESSION['uid'])[0];
                    echo '<img src="uploads/' . $user['pseudo'] . '/' . $user['profile_picture'] . '" alt="" class="user-pfp">
                        <div class="user-info">
                            <h3 class="user-name">' . $user['pseudo'] . '</h3>
                            <div class="user-status-info">
                                <p class="status"><span id="status">•</span> En ligne</p>
                                <p id="last-activity"></p>
                            </div>
                        </div>';
                    ?>
                    <div class="user-actions">
                        <i class="fas fa-phone"></i>
                        <i class="fas fa-camera"></i>
                        <i class="fas fa-cog"></i>
                    </div>
                </div>
                <div id="chat-content">

                </div>
                <div class="chat-actions">
                    <i id="join-file" class="fas fa-paperclip"></i>
                    <input type="text" id="message-input" placeholder="Tappez votre message ici...">
                    <i id="emojis" class="fas fa-smile"></i>
                    <i id="audio" class="fas fa-microphone"></i>
                </div>
            </div>
        </div>

    </div>

    <script src="scripts/chat.js"></script>
</body>

</html>