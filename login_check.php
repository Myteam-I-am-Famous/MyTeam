<?php session_start();

include 'includes/functions.php';

if (!isset($_POST['submit'])) {
    header('location: login.php?message=accessdenied');
    exit();
}

if (!aresetAndNotEmpty([
    $_POST['uid'],
    $_POST['password']
])) {
    header('location: login.php?message=emptyinput');
    exit();
}

if (!userexists($_POST['uid'])) {
    header('location: login.php?message=userdoesnotexists');
    exit();
}

if (!checkuserpassword($_POST['uid'], $_POST['password'])) {
    header('location: login.php?message=invalidpassword');
    exit();
}

if (!logUser($_POST['uid'], $_POST['password'])) {
    header('location: login.php?message=couldnotconnect');
    exit();
}

header('location: index.php?message=connectsuccess');
exit();
