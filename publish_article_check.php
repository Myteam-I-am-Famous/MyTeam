<?php session_start();

include 'includes/functions.php';


if (!isset($_POST['submit'])) {
    header('location: home');
    exit;
}


if (!aresetAndNotEmpty(
    [
        $_POST['title'],
        $_POST['content']
    ]
)) {
    header('location: creation_article');
    exit;
}


if (isset($_GET['action']) && !empty($_GET['action'])) {

    if ($_GET['action'] == 'create') {
        if (!isset($_FILES['image'])) {
            header('location: creation_article?code=nofileinput');
            exit;
        }

        if ($_FILES['image']['error'] !== 0) {
            header('location: creation_article?code=fileerror');
            exit();
        } else {
            $acceptable = [
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/gif'
            ];

            if (!in_array($_FILES['image']['type'], $acceptable)) {
                header('location:creation_article?code=invalidtype');
                exit();
            }

            $maxSize = 10 * 1024 * 1024;

            if ($_FILES['image']['size'] > $maxSize) {
                header('location: creation_article?code=filetoobig');
                exit();
            }

            $filePath = 'uploads/articles';

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
                header('location: creation_article?code=couldnotupload');
                exit();
            }

            if (!createArticle($_POST['title'], $_POST['content'], $_POST['caption'], $_SESSION['uid'], $fileName)) {
                header('location: creation_article?code=couldnocreatearticle');
                exit();
            }
        }

        header('location: tous-les-articles');
        exit;
    } else if ($_GET['action'] == 'modify') {


        if ($_FILES['image']['error'] == 0) {
            $acceptable = [
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/gif'
            ];

            if (!in_array($_FILES['image']['type'], $acceptable)) {
                header('location: edition_article/' . $_GET['id']);
                exit();
            }

            $maxSize = 10 * 1024 * 1024;

            if ($_FILES['image']['size'] > $maxSize) {
                header('location: edition_article/' . $_GET['id'] .'?code=filetoobig');
                exit();
            }

            $filePath = 'uploads/articles';

            if (!file_exists($filePath)) {
                mkdir($filePath, 0777);
                // chown($filePath, 'www-data');
            }

            $fileName = $_FILES['image']['name'];
            $splitFileName = explode('.', $fileName);
            $extension = end($splitFileName);

            $fileName = "image-" . uniqid() . '.' . $extension;



            $dest = $filePath . '/' . $fileName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
                header('location: edition_article/' . $_GET['id'] . '?code=couldnotupload');
                exit();
            }
            if (modifyArticle($_GET['id'], $_POST['title'], $_POST['caption'], $_POST['content'], $fileName)) {
                header('location: edition_article/' . $_GET['id'] . '?code=articlemodified');
                exit;
            } else {
                header('location: edition_article/' . $_GET['id'] . '?code=couldnotmodifyarticle');
                exit;
            }
        }

        if (modifyArticle($_GET['id'], $_POST['title'], $_POST['caption'], $_POST['content'])) {
            header('location: edition_article/' . $_GET['id'] . '?code=articlemodified');
            exit;
        } else {
            header('location: edition_article/' . $_GET['id'] . '?code=couldnotmodifyarticle');
            exit;
        }
    }
}

