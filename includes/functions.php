<?php

include 'database_handler.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function aresetAndNotEmpty($elements)
{
    foreach ($elements as $element) {
        if (!isset($element) || empty($element))
            return false;
    }

    return true;
}

function userexists($uid)
{
    global $dbh;

    if (filter_var($uid, FILTER_VALIDATE_EMAIL)) {
        $q = 'SELECT id FROM users WHERE email = :email;';
        $stmt = $dbh->prepare($q);

        $status = $stmt->execute(
            array(
                'email' => $uid
            )
        );

        if ($status) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['id']) {
                return true;
            }

            return false;
        } else {
            return false;
        }
    } else {
        $q = 'SELECT id FROM users WHERE pseudo = :pseudo;';
        $stmt = $dbh->prepare($q);

        $status = $stmt->execute(
            array(
                'pseudo' => $uid
            )
        );

        if ($status) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['id']) {
                return true;
            }

            return false;
        } else {
            return false;
        }
    }

    return false;
}

function checkuserpassword($uid, $password)
{
    global $dbh;

    if (filter_var($uid, FILTER_VALIDATE_EMAIL)) {

        $q = 'SELECT password FROM users WHERE email = :email;';
        $stmt = $dbh->prepare($q);
        $status = $stmt->execute(
            array(
                'email' => $uid
            )
        );

        if ($status) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['password']) {
                return password_verify($password, $result['password']);
            }
        } else {
            return false;
        }
    } else {
        $q = 'SELECT password FROM users WHERE pseudo = :pseudo;';
        $stmt = $dbh->prepare($q);
        $status = $stmt->execute(
            array(
                'pseudo' => $uid
            )
        );

        if ($status) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['password']) {
                return password_verify($password, $result['password']);
            }
        } else {
            return false;
        }
    }

    return false;
}

function sendVerificationMail($id, $to, $code)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->SMTPAuth = false;
        $mail->SMTPSecure = false;
        $mail->SMTPAutoTLS = false;

        $mail->Host = 'localhost';
        $mail->Port = 25;

        $mail->isHTML(true);
        $mail->SetFrom('no-reply@myteam.fr', '[MyTeam]');
	$mail->Subject = "Confirmation d'inscription";
	$hashedCode = md5($code);
        $mail->Body = 'Votre code de vérification est :'
            . $code
            . "<br><a href='http://monequipe.site/code_check.php?id={$id}&code={$hashedCode}'>Cliquez sur ce lien pour vérifier votre compte</a>";
        $mail->CharSet = 'utf-8';

        $mail->AddAddress($to);

        $mail->Send();
        echo 'Mail sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mail Error: ' . $mail->ErrorInfo;
    }
}

function createUser($firstname, $lastname, $pseudo, $email, $age, $pwd)
{

    global $dbh;

    $q = 'INSERT INTO users(
        id,
        first_name,
        last_name,
        email,
        age,
        password,
        hash,
        ip,
        mt_points,
        plan,
        role,
        status,
        pseudo,
        profile_picture
    )
	    VALUES(
		:id,
		:firstname,
		:lastname,
		:email,
		:age,
		:pwd,
		:hash,
		:ip,
		:mt_points,
		:plan,
		:role,
		:status,
		:pseudo,
		:profile_picture);';
    $stmt = $dbh->prepare($q);

    $id = getMaxID('users') + 1;
    $code = rand(1000, 10000);

    $response = $stmt->execute(
        array(
            'id' => $id,
            'firstname' => htmlspecialchars($firstname),
            'lastname' => htmlspecialchars($lastname),
            'pseudo' => htmlspecialchars($pseudo),
            'email' => htmlspecialchars($email),
            'age' => htmlspecialchars($age),
            'pwd' => password_hash($pwd, PASSWORD_DEFAULT),
            'hash' => md5($code),
            'ip' => ip2long(getClientIP()),
            'mt_points' => 100,
            'plan' => 1,
            'role' => 1,
            'status' => 0,
            'profile_picture' => NULL

        )
    );

    if ($response) 
    {

	    sendVerificationMail($id, $email, $code);
        return true;
    }

    return false;
}


function logUser($uid)
{
    session_unset();

    $userData = getUserDataByUID($uid);

    $_SESSION['uid'] = $userData['uid'];
    $_SESSION['firstname'] = $userData['first_name'];
    $_SESSION['lastname'] = $userData['last_name'];
    $_SESSION['username'] = $userData['pseudo'];
    $_SESSION['mt_points'] = $userData['mt_points'];
    // $_SESSION['ip'] = long2ip($userData['ip']);
    $_SESSION['role'] = $userData['role'];
    $_SESSION['status'] = $userData['status'];




    return true;
}

function updateUserStatus($uid, $status)
{
    global $dbh;
    $q = 'UPDATE users
    SET status = :status
    WHERE id = :uid;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'status' => $status,
            'uid' => $uid
        )
    );

    return $status;
}

function isAdmin()
{
    return $_SESSION['role'] == 2;
}

function getProfilePicture($uid)
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

function getUserDataByUID($uid)
{
    global $dbh;

    if (!userexists($uid))
        return false;

    if (filter_var($uid, FILTER_VALIDATE_EMAIL)) {

        $q = 'SELECT
        users.id as uid,
        users.first_name,
        users.last_name,
        users.pseudo,
        users.email,
        users.age,
        users.mt_points,
        users.event,
        users.plan,
        users.role,
        users.status,
        users.ip,
        user_roles.id as rid,
        user_roles.name,
        user_roles.description,
        user_roles.color
        FROM user_roles
        INNER JOIN users
        ON user_roles.id = users.role
        WHERE users.email = :email;';

        $stmt = $dbh->prepare($q);

        $status = $stmt->execute(
            array(
                'email' => $uid
            )
        );

        if ($status) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) == 0) {
                return false;
            }

            return $result[0];
        } else {
            return false;
        }
    } else {
        $q = 'SELECT
        users.id as uid,
        users.first_name,
        users.last_name,
        users.pseudo,
        users.email,
        users.age,
        users.mt_points,
        users.plan,
	    users.role,
	    users.ip,
        users.status,
        user_roles.id as rid,
        user_roles.name,
        user_roles.description,
        user_roles.color
        FROM user_roles
        INNER JOIN users
        ON user_roles.id = users.role
        WHERE users.pseudo = :pseudo;';

        $stmt = $dbh->prepare($q);

        $status = $stmt->execute(
            array(
                'pseudo' => $uid
            )
        );

        if ($status) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) == 0) {
                return false;
            }

            return $result[0];
        } else {
            return false;
        }
    }
    return false;
}

function getMaxID($table)
{
    global $dbh;

    $q = 'SELECT MAX(id) FROM ' . $table . ';';
    $stmt = $dbh->prepare($q);
    if ($stmt->execute()) {
        $result = $stmt->fetch();

        if ($result[0])
            return $result[0];

        return 0;
    }

    return false;
}

function getAllUsers()
{
    global $dbh;

    $q = 'SELECT id,
    first_name,
    last_name,
    email,
    age,
    mt_points,
    fav_sport,
    plan,
    role,
    status
    FROM users;';

    $stmt = $dbh->prepare($q);

    if ($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) == 0) {
            return false;
        }

        return $result;
    }

    return false;
}

function getCardsByUID($uid)
{
    global $dbh;

    $q = 'SELECT *, basketball_cards.id as bid
                FROM basketball_cards INNER JOIN basketball_inventory ON basketball_cards.id = basketball_inventory.basketball_card WHERE basketball_inventory.user = :uid;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'uid' => $uid
        )
    );

    if ($status) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    return false;
}

function addCard(
    $uid,
    $id,
    $fullName,
    $jerseyNumber,
    $headshotURL,
    $position,
    $team,
    $teamABV,
    $league,
    $gp,
    $min,
    $fg,
    $tp,
    $ft,
    $reb,
    $ast,
    $blk,
    $stl,
    $pts,
    $overall
) {
    global $dbh;

    if (!cardexists($id)) {

        $q = 'INSERT INTO basketball_cards
    (id,
     full_name,
     jersey_number,
     headshot_url,
     position,
     team,
     league,
     gp,
     min,
     fg_pct,
     tp_pct,
     ft_pct,
     reb,
     ast,
     blk,
     stl,
     pts,
     overall,
     team_abv
     )
     VALUES(
:id,
:full_name,
:jersey_number,
:headshot_url,
:position,
:team,
:league,
:gp,
:min,
:fg,
:tp,
:ft,
:reb,
:ast,
:blk,
:stl,
:pts,
:overall,
:teamABV
);';
        $stmt = $dbh->prepare($q);



        $status = $stmt->execute(
            array(
                'id' => $id,
                'full_name' => $fullName,
                'jersey_number' => $jerseyNumber,
                'headshot_url' => $headshotURL,
                'position' => $position,
                'team' => $team,
                'league' => $league,
                'gp' => $gp,
                'min' => $min,
                'fg' => $fg,
                'tp' => $tp,
                'ft' => $ft,
                'reb' => $reb,
                'ast' => $ast,
                'blk' => $blk,
                'stl' => $stl,
                'pts' => $pts,
                'overall' => $overall,
                'teamABV' => $teamABV

            )
        );

        if ($status) {
            return addCardToInventory($uid, $id);
        }
    } else {
        return addCardToInventory($uid, $id);
    }
    return false;
}

function addCardToInventory($UID, $cardID, $inventory = 'basketball_inventory')
{

    global $dbh;

    $q = 'INSERT INTO ' . $inventory .
        ' VALUES (
        :id,
        :user_id,
        :card_id);';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'id' => getMaxID('basketball_inventory') + 1,
            'user_id' => $UID,
            'card_id' => $cardID
        )
    );
    if ($status) {
        return true;
    }
    return false;
}

function cardexists($id, $sport_cards = 'basketball_cards')
{
    global $dbh;

    $q = 'SELECT 1 FROM ' . $sport_cards . ' WHERE id = :id;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'id' => $id
        )
    );

    if ($status) {
        return ($stmt->fetch(PDO::FETCH_ASSOC));
    }

    return false;
}

function getUsersAndRoles()
{
    global $dbh;

    $q = 'SELECT
    users.id as uid,
    users.first_name,
    users.last_name,
    users.pseudo,
    users.email,
    users.age,
    users.mt_points,
    users.fav_sport,
    users.plan,
    users.role,
    users.status,
    user_roles.id as rid,
    user_roles.name,
    user_roles.description,
    user_roles.color
    FROM user_roles
    INNER JOIN users
    ON user_roles.id = users.role;';

    $stmt = $dbh->prepare($q);

    if ($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) == 0) {
            return false;
        }

        return $result;
    }

    return false;
}

function getUserByRole($role)
{
    global $dbh;

    $q = 'SELECT id,
    first_name,
    last_name,
    pseudo,
    email,
    age,
    mt_points,
    fav_sport,
    plan,
    role,
    status
    FROM users WHERE role = :role;';
    $stmt = $dbh->prepare($q);

    $status = $stmt->execute(
        array(
            'role' => $role
        )
    );

    if ($status) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) == 0) {
            return false;
        }

        return $result;
    }

    return false;
}

function searchUser($input)
{
    global $dbh;

    $users = getUsersAndRoles();
    $user = ['abdou'];

    foreach ($users as $key => $data) {
        if (
            strpos(strtolower($data['last_name']), strtolower($input)) !== false
            || strpos(strtolower($data['first_name']), strtolower($input)) !== false
        ) {
            array_push($user,  $data);
        }
    }

    return $user;
}

function getUserAndRoleByUID($uid)
{
    global $dbh;

    $q = 'SELECT
    users.id as uid,
    users.first_name,
    users.last_name,
    users.pseudo,
    users.email,
    users.age,
    users.mt_points,
    users.fav_sport,
    users.plan,
    users.role,
    users.status,
    user_roles.id as rid,
    user_roles.name,
    user_roles.description,
    user_roles.color,
    user_roles.roles_privileges
    FROM user_roles
    INNER JOIN users
    ON user_roles.id = users.role
    WHERE users.id = :uid;';

    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'uid' => $uid
        )
    );

    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['uid']) {
            return $result;
        }
    }

    return false;
}

function getUserInfo($info)
{
    global $dbh;

    $q = 'SELECT ' . $info . ' FROM users;';
    $stmt = $dbh->prepare($q);

    if ($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            return $result;
        }
    }

    return false;
}

function getRoleName($user_id)
{
    global $dbh;

    $q = 'SELECT name FROM user_roles INNER JOIN users ON user_roles.id = users.role AND users.id = :user_id;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'user_id' => $user_id
        )
    );
    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['name'] ? $result['name'] : false;
    }

    return false;
}

function getRoleByID($uid)
{
    global $dbh;

    $q = 'SELECT * FROM user_roles WHERE id = (SELECT role FROM users WHERE users.id = :uid);';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'uid' => $uid
        )
    );

    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (count($result) > 0) {
            return $result;
        }
    }

    return false;
}

function updateUserRow(
    $table,
    $row,
    $value,
    $id
) {

    global $dbh;

    $q = 'UPDATE ' . $table . '
    SET ' . $row . ' = "' . $value . '"
    WHERE id = :id;';

    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'id' => $id
        )
    );
    if ($status) {
        return true;
    }
    return false;
}

function getClientIP()
{
    $ip = '127.0.0.1';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

function createArticle($title, $content, $caption, $author, $imagePath = null)
{
    global $dbh;
    $date = new DateTime("now");

    $q = 'INSERT INTO articles
    VALUES(
        :id,
        :title,
        :content,
        :image,
        :author,
        :caption,
        :date
        );';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'id' => getMaxID('articles') + 1,
            'title' => $title,
            'content' => $content,
            'image' => $imagePath,
            'author' => $author,
            'caption' => $caption,
            'date' => strtotime($date->format('Y/m/d h:i:s'))
        )
    );

    return $status;
}

function getDataFrom($table, $orderBy = '', $direction = 'DESC')
{

    global $dbh;

    if ($orderBy != '')
        $q = 'SELECT * FROM ' . $table . ' ORDER BY ' . $orderBy . ' ' . $direction . ';';
    else
        $q = 'SELECT * FROM ' . $table . ';';
    $stmt = $dbh->prepare($q);

    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return false;
}

function getDataByID($id, $data = "*", $table = 'users')
{
    global $dbh;

    $q = 'SELECT ' . $data . ' FROM ' . $table . ' WHERE id = :id;';
    $stmt = $dbh->prepare($q);

    if ($stmt->execute(['id' => $id])) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return false;
}

function createEvent(
    $title,
    $description,
    $begin,
    $end,
    $rules,
    $reward_first,
    $reward_second,
    $reward_third,
    $reward_others,
    $image
) {

    global $dbh;

    $q = 'INSERT INTO events (
            id,
            title,
            description,
            begin,
            end,
            rules,
            reward_first,
            reward_second,
            reward_third,
            reward_others,
            image
        )
        VALUES
        (
            :id,
            :title,
            :description,
            :begin,
            :end,
            :rules,
            :reward_first,
            :reward_second,
            :reward_third,
            :reward_others,
            :image
        );';

    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'id' => getMaxID('events') + 1,
            'title' => $title,
            'description' => $description,
            'begin' => $begin,
            'end' => $end,
            'rules' => $rules,
            'reward_first' => $reward_first,
            'reward_second' => $reward_second,
            'reward_third' => $reward_third,
            'reward_others' => $reward_others,
            'image' => $image
        )
    );

    return $status;
}


function joinEvent($user_id, $event_id)
{
    global $dbh;

    $q = 'UPDATE users SET event = ' . $event_id . ' WHERE users.id = :user_id;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'user_id' => $user_id
        )
    );

    return $status ? true : false;
}

function quitEvent($user_id)
{
    global $dbh;

    $q = 'UPDATE users SET event = null WHERE users.id = :user_id;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'user_id' => $user_id
        )
    );

    return $status ? true : false;
}

function getDoubleDigitFormat($date)
{
    if (strlen($date) == 1) return "0" . $date;
    return $date;
}

function getEventParticipants($event_id)
{
    global $dbh;

    $q = 'SELECT * FROM users WHERE event = :event_id;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'event_id' => $event_id
        )
    );

    if ($status) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}


function createForumSubject($title, $content, $author, $category)
{
    global $dbh;
    $date = new DateTime("now");

    $q = 'INSERT INTO forum_subjects
    (
        id,
        title,
        content,
        author,
        last_activity,
        category,
        status
    )
    VALUES
    (
        :id,
        :title,
        :content,
        :author,
        :last_activity,
        :category,
        :status
    );';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'id' => getMaxID('forum_subjects') + 1,
            'title' => $title,
            'content' => $content,
            'author' => $author,
            'last_activity' => strtotime($date->format('Y/m/d h:i:s')),
            'category' => $category,
            'status' => 1

        )
    );

    return $status;
}

function getForumLikes($forum, $value = 1)
{
    global $dbh;

    $q = 'SELECT COUNT(*) as cnt
    FROM forum_likes_dislikes
    WHERE forum = :forum
    AND value = :value;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'forum' => $forum,
            'value' => $value
        )
    );
    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['cnt'];
    }
    return false;
}

function getForumLiked($forum, $user, $value = 1)
{
    global $dbh;

    $q = 'SELECT COUNT(*) as cnt
    FROM forum_likes_dislikes
    WHERE forum = :forum
    AND user = :user
    AND value = :value;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'forum' => $forum,
            'user' => $user,
            'value' => $value
        )
    );
    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['cnt'];
    }
    return false;
}

function getReactionLikes($reaction, $value = 1)
{
    global $dbh;

    $q = 'SELECT COUNT(*) as cnt
    FROM reaction_likes_dislikes
    WHERE reaction = :reaction
    AND value = :value;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'reaction' => $reaction,
            'value' => $value
        )
    );
    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['cnt'];
    }
    return false;
}

function getReactionLiked($reaction, $user, $value = 1)
{
    global $dbh;

    $q = 'SELECT COUNT(*) as cnt
    FROM reaction_likes_dislikes
    WHERE reaction = :reaction
    AND user = :user
    AND value = :value;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'reaction' => $reaction,
            'user' => $user,
            'value' => $value
        )
    );
    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['cnt'];
    }
    return false;
}

function createForumSubjectReaction($reaction, $author, $forum)
{
    global $dbh;
    $date = new DateTime('NOW');

    $q = 'INSERT INTO reactions
    (
        id,
        reaction,
        date,
        user,
        forum
    )
    VALUES
    (
        :id,
        :reaction,
        :date,
        :user,
        :forum
    );';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'id' => getMaxID('reactions') + 1,
            'reaction' => $reaction,
            'date' => strtotime($date->format('Y/m/d h:i:s')),
            'user' => $author,
            'forum' => $forum
        )
    );

    return $status;
}

function getForumReactionCount($forum)
{

    global $dbh;

    $q = 'SELECT COUNT(*) as cnt
    FROM reactions
    WHERE forum = :forum;';
    $stmt = $dbh->prepare($q);

    $status = $stmt->execute(
        array(
            'forum' => $forum
        )
    );

    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['cnt'];
    }
    return 0;
}


function modifyArticle($id, $title, $caption, $content, $image = null)
{

    global $dbh;

    if ($image != null) {
        $q = 'UPDATE articles SET
    title = :title,
    content = :content,
    caption = :caption,
    image = :image
    WHERE id = :id;';

        $stmt = $dbh->prepare($q);
        $status = $stmt->execute(
            array(
                'title' => htmlspecialchars($title),
                'content' => htmlspecialchars($content),
                'caption' => htmlspecialchars($caption),
                'image' => htmlspecialchars($image),
                'id' => htmlspecialchars($id)
            )
        );
    } else {
        $q = 'UPDATE articles SET
    title = :title,
    content = :content,
    caption = :caption
    WHERE id = :id;';

        $stmt = $dbh->prepare($q);
        $status = $stmt->execute(
            array(
                'title' => htmlspecialchars($title),
                'content' => htmlspecialchars($content),
                'caption' => htmlspecialchars($caption),
                'id' => htmlspecialchars($id)
            )
        );
    }


    return $status;
}

function getActiveMenu($activeMenu, $menu)
{
    return (isset($activeMenu) && $activeMenu == $menu);
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

function getUserScore($uid)
{
    global $dbh;
    $q = 'SELECT SUM(value) as sum FROM forum_likes_dislikes WHERE user = :user;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'user' => $uid
        )
    );
    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['sum'];
    }

    return false;
}

function getUserForumCount($uid)
{
    global $dbh;
    $q = 'SELECT COUNT(*) as cnt FROM forum_subjects WHERE author = :user;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'user' => $uid
        )
    );
    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['cnt'];
    }

    return false;
}

function getUsersByStatus($status)
{
    global $dbh;

    $q = 'SELECT * FROM users
    WHERE status = :status;';
    $stmt = $dbh->prepare($q);

    $status = $stmt->execute(
        array(
            'status' => $status
        )
    );

    if ($status) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0)
            return $result;
    }
    return false;
}

function getUserStatus($uid, $status)
{
    global $dbh;

    $q = 'SELECT * FROM users
    WHERE status = :status
    AND id = :uid;';
    $stmt = $dbh->prepare($q);

    $status = $stmt->execute(
        array(
            'uid' => $uid,
            'status' => $status
        )
    );

    if ($status) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0)
            return $result;
    }
    return false;
}

function getUsersStatusCount($status)
{
    global $dbh;
    $q = 'SELECT COUNT(*) as cnt FROM users WHERE status = :status;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'status' => $status
        )
    );
    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['cnt'];
    }

    return false;
}

function checkVerificationCode($dbh, $email, $code)
{
    if (!userexists($email))
        return false;

    if (useractivated($email))
        return false;
}

function useractivated($uid)
{
	global $dbh;



    $q = 'SELECT status FROM users WHERE id = :uid;';
    $stmt = $dbh->prepare($q);

    $status = $stmt->execute(
        array(
            'uid' => $uid
        )
    );

    if ($status) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['status'] != 0;
    }

    return false;
}

function activateuser($uid)
{
	global $dbh;

    $q = 'UPDATE users SET status = 1 WHERE id = :uid;';
    $stmt = $dbh->prepare($q);

    $status = $stmt->execute(
        array(
            'uid' => $uid
        )
    );

    return $status;
}

