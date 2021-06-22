<?php session_start();

include 'includes/functions.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('location: forums.php?code=couldnotfindsubject');
    exit;
}

if (!isset($_POST['submit'])) {
    header('location: forum_subject.php?id=' . $_GET['id'] . '&code=accessdenied');
    exit;
}

if (isset($_POST['reaction']) && !empty($_POST['reaction'])) {
    if (!createForumSubjectReaction($_POST['reaction'], $_SESSION['uid'], $_GET['id'])) {
        header('location: forum_subject.php?id=' . $_GET['id'] . '&code=couldnotaddreaction');
        exit;
    } else {
        header('location: forum_subject.php?id=' . $_GET['id'] . '&code=reactioncreated');
        exit;
    }
}
