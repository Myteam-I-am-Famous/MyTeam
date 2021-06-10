<?php session_start();

if (isset($_SESSION['uid'])) {
    session_unset();
    header('location: index.php?code=logout');
    exit;
}

header('location: index.php?code=nothing');
exit;
