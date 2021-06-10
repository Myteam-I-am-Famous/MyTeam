<?php

include 'includes/functions.php';

if (!isset($_POST['submit'])) {
    header('location: create_event.php?code=accessdenied');
    exit;
}


var_dump($_POST);
var_dump($_FILES);

if (!aresetAndNotEmpty([
    $_POST['title'],
    $_POST['begin'],
    $_POST['end'],
    $_POST['description'],
    $_POST['reward_first'],
    $_POST['reward_second'],
    $_POST['reward_third'],
    $_POST['reward_others']
])) {
    header('location: create_event.php?code=emptyinput');
    exit;
}

if (!isset($_FILES['image'])) {
    header('location: create_event.php?code=emptyinput');
    exit;
}

if ($_FILES['image']['error'] !== 0) {
    header('location: create_event.php?code=fileerror');
    exit();
} else {
    $acceptable = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif'
    ];

    if (!in_array($_FILES['image']['type'], $acceptable)) {
        header('location: create_event.php?code=invalidtype');
        exit();
    }

    $maxSize = 25 * 1024 * 1024;

    if ($_FILES['image']['size'] > $maxSize) {
        header('location: create_event.php?code=filetoobig');
        exit();
    }


    $filePath = 'uploads/events/event-' . $_POST['title'];

    if (!file_exists($filePath)) {
        mkdir($filePath, 0777);
        // chown($filePath, 'www-data');
    }

    $fileName = $_FILES['image']['name'];
    $splitFileName = explode('.', $fileName);
    $extension = end($splitFileName);

    $fileName = 'image-' . uniqid() . '.' . $extension;

    $dest = $filePath . '/' . $fileName;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
        header('location: create_event.php?code=couldnotupload');
        exit();
    }

    $begin = strtotime($_POST['begin']);
    $begin = date('Y-m-d H:i:s', $begin);

    $end = strtotime($_POST['end']);
    $end = date('Y-m-d H:i:s', $end);

    var_dump($fileName);
    // exit;

    if (!createEvent(
        $_POST['title'],
        $_POST['description'],
        $begin,
        $end,
        1,
        $_POST['reward_first'],
        $_POST['reward_second'],
        $_POST['reward_third'],
        $_POST['reward_others'],
        $fileName
    )) {
        exit;
        header('location: create_event.php?code=cannotcreateevent');
        exit;
    }

    header('location: create_event.php?code=eventcreated');
    exit;
}
