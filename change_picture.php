<?php session_start();

include 'includes/functions.php';


if (!isset($_POST['submit'])) {
    header('location: index.php?code=accessdenied');
    exit;
}


if (!isset($_FILES['image'])) {
    header('location: index.php?code=emptyinput');
    exit;
}

if ($_FILES['image']['error'] !== 0) {
    header('location: index.php?code=fileerror');
    exit();
} else {
    $acceptable = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif'
    ];

    if (!in_array($_FILES['image']['type'], $acceptable)) {
        header('location: index.php?code=invalidtype');
        exit();
    }

    $maxSize = 2 * 1024 * 1024;

    if ($_FILES['image']['size'] > $maxSize) {
        header('location: index.php?code=filetoobig');
        exit();
    }

    $filePath = 'uploads/' . $_SESSION['username'];

    if (!file_exists($filePath)) {
	    mkdir($filePath, 0777);
	    chown($filePath, 'www-data');
    }

    $fileName = $_FILES['image']['name'];
    $splitFileName = explode('.', $fileName);
    $extension = end($splitFileName);

    $fileName = 'image-' . uniqid() . '.' . $extension;

    $dest = $filePath . '/' . $fileName;

    if (!move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
        header('location: index.php?code=couldnotupload');
        exit();
    }

    if (!updateUserRow('users', 'profile_picture', $fileName, $_SESSION['uid'])) {
        header('location: index.php?code=couldnotupdatepicture');
        exit();
    }

    header('location: index.php?code=pfpchanged');
    exit();
}

var_dump($_FILES);
