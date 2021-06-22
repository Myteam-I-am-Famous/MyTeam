<?php session_start();

include 'includes/functions.php';

if (isset($_SESSION['uid']) && isset($_SESSION['status'])) {


    if ($_SESSION['status'] != 0)
        updateUserStatus($_SESSION['uid'], 2);

    session_unset();
    header('location: index.php?code=logout');
    exit;
}

header('location: index.php?code=nothing');
exit;

