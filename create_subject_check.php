<?php session_start();

include 'includes/functions.php';

if (!isset($_POST['submit'])) {
    header('location: create_subject.php?code=accessdenied');
    exit;
}

if (!aresetAndNotEmpty([
    $_POST['category'],
    $_POST['title'],
    $_POST['content']
])) {
    header('location: create_subject.php?code=emptyinput');
    exit;
}

if (!createForumSubject($_POST['title'], $_POST['content'], $_SESSION['uid'], $_POST['category'])) {
    header('location: create_subject.php?code=couldnotcreatesubject');
    exit;
}

header('location: create_subject.php?code=subjectcreated');
exit;
