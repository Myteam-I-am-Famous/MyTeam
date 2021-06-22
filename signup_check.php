<?php


include 'includes/functions.php';


if (!isset($_POST['submit'])) {
    header("location: signup.php?code=accessdenied");
    exit;
}

if (!aresetAndNotEmpty(
    [
        $_POST['firstname'],
        $_POST['lastname'],
        $_POST['age'],
        $_POST['email'],
        $_POST['password'],
        $_POST['password_repeat'],
        $_POST['username'],
        //! Pas obligatoire : $_POST['bio'],
        // $_POST['sport']
    ]
)) {
    header('location: signup.php?code=emptyinput');
    exit;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('location: signup.php?code=invalidemail');
    exit;
}

if ($_POST['age'] < 18) {
    header('location: signup.php?code=tooyoung');
    exit;
}

if (userexists($_POST['email']) || userexists($_POST['username'])) {
    header('location: signup.php?code=userexists');
    exit;
}

if (strlen($_POST['password']) < 8 && strlen($_POST['password']) > 18) {
    header('location: signup.php?code=passwordlength');
    exit;
}

if ($_POST['passwprd'] != $_POST['password_repeat']) {
    header('location: signup.php?code=differentpassword');
    exit;
}

if (!createUser(
    $_POST['firstname'],
    $_POST['lastname'],
    $_POST['username'],
    $_POST['email'],
    $_POST['age'],
    $_POST['password'],
    1
)) {
    header('location: signup.php?code=couldnotcreateuser');
    exit;
}

header('location: index.php?code=usercreated');
exit;

