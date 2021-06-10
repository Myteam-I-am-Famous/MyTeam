<?php

include 'includes/functions.php';

if (!isset($_POST['submit'])) {
    header('location: publish_article.php?code=accessdenied');
    exit;
}

if (!aresetAndNotEmpty(
    [
        $_POST['title'],
        $_POST['content']
    ]
)) {
    header('location: publish_article.php?code=emptyinput');
    exit;
}

if (!isset($_FILES['image'])) {
    header('location: publish_article.php?code=emptyinput');
    exit;
}

if ($_FILES['image']['error'] !== 0) {
    header('location: publish_article.php?code=fileerror');
    exit();
} else {
    $acceptable = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif'
    ];

    if (!in_array($_FILES['image']['type'], $acceptable)) {
        header('location: publish_article.php?code=invalidtype');
        exit();
    }

    $maxSize = 10 * 1024 * 1024;

    if ($_FILES['image']['size'] > $maxSize) {
        header('location: publish_article.php?code=filetoobig');
        exit();
    }

    $filePath = 'uploads/' . $_POST['title'];

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
        header('location: publish_article.php?code=couldnotupload');
        exit();
    }

    if (!createArticle($_POST['title'], $_POST['content'], $fileName)) {
        header('location: publish_article.php?code=couldnocreatearticle');
        exit();
    }
}

header('location: publish_article.php?code=articlecreated');
exit;
