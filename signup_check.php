<?php

include "includes/functions.php";


// if (!isset($_POST['submit'])) {
//     header('location: signup.php?code=accessdenied');
//     exit;
// }

// if (
//     preg_match('~[0-9]+~', $_POST['firstname'])
//     || preg_match('~[0-9]+~', $_POST['lastname'])
// ) {
//     header('location: signup.php?numberinname');
//     exit;
// }

// if (!aresetAndNotEmpty([
//     $_POST['firstname'],
//     $_POST['lastname'],
//     $_POST['pseudo'],
//     $_POST['username'],
//     $_POST['age'],
//     $_POST['email'],
//     $_POST['password'],
//     $_POST['password_repeat'],
//     $_POST['sport']
// ])) {
//     header('location: signup.php?code=emptyinput');
//     exit;
// }

// if (!preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9]{5,31}$/', $_POST['username'])) {
//     header('location: signup.php?code=invalidusernameformat');
//     exit;
// }

// if ($_POST['age'] < 18) {
//     header('location: signup.php?code=tooyoung');
//     exit;
// }

// if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
//     header('location: signup.php?code=invalidemailformat');
//     exit;
// }

// if (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[^a-zA-Z0-9]).{8,16}$/', $_POST['password'])) {
//     header('location: signup.php?code=invalidpasswordformat');
//     exit;
// }

if ($_POST['password'] !== $_POST['password_repeat']) {
    header('location: signup.php?code=differentpasswords');
    exit;
}

if (!createUser($_POST['firstname'], $_POST['lastname'], $_POST['username'], $_POST['email'], $_POST['age'], $_POST['password'], $_POST['sport'])) {
    header('location: signup.php?code=createuserfailure');
    exit;
} else {
    header('location: index.php?code=createusersuccess');
    exit;
}
