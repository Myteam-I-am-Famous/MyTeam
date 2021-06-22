<?php session_start();

include 'includes/functions.php';

if (!isset($_POST['submit'])) {
    header('location: login.php?code=accessdenied');
    exit();
}

if (!aresetAndNotEmpty([
    $_POST['uid'],
    $_POST['password']
])) {
    header('location: login.php?code=emptyinput');
    exit();
}

if (!userexists($_POST['uid'])) {
    header('location: login.php?code=userdoesnotexists');
    exit();
}

if (!checkuserpassword($_POST['uid'], $_POST['password'])) {
    header('location: login.php?code=invalidpassword');
    exit();
}


if (!logUser($_POST['uid'])) {
    header('location: login.php?code=couldnotconnect');
    exit();
}

if ($_SESSION['role'] == 2) {
    header('location: Admin/?code=adminconnected');
    exit;
}
if (getUserStatus($_SESSION['uid'], 0)) {
    header('location: index.php?code=unverifieduser');
    exit();
}


updateUserStatus($userData['uid'], 3);
header(
    'location: index.php?code=connectsuccess'
);
exit();

