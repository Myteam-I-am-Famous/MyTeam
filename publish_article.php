<?php session_start();

if (!isset($_SESSION['role']) || (isset($_SESSION['role']) && $_SESSION['role'] != 2)) {
    header('location: index.php?code=accessdenied');
    exit;
}

$title = "Publier un article";

include 'includes/head.php';
include 'includes/header.php';
?>


<main>

    <?php
    if (isset($_GET['action']) && !empty($_GET['action'])) {

        if ($_GET['action'] == 'create') {

            echo '<form class="article-form" action="publish_article_check.php?action=create" method="POST" enctype="multipart/form-data">
        <div class="form-input-row">
            <label for="title">Titre</label>
            <input type="text" id="title" name="title">
            <label for="caption">Caption</label>
	    <input type="text" id="caption" name="caption">
	    <label for="image">Image</label>
            <input type="file" id="image" name="image" accept="image/*">
            <button type="submit" name="submit">Publier</button>
        </div>
        <label for="content">Content</label>
        <textarea name="content" id="content" cols="150" rows="40"></textarea>
    </form>';
        } else if ($_GET['action'] == 'modify') {
            if (isset($_GET['id']) and !empty($_GET['id'])) {
                $getid = $_GET['id'];
                $recupArticles = $dbh->prepare('SELECT * FROM  articles WHERE id = ?');
                $recupArticles->execute(array($getid));
                if ($recupArticles->rowCount() > 0) {
                    $iarticles = $recupArticles->fetch();
                    $titre = $iarticles['title'];
                    $description = $iarticles['content'];
                    $caption = $iarticles['caption'];
                    str_replace('<br />', '', $iarticles['content']);
                }
            }


            echo '<form class="article-form" action="publish_article_check.php?action=modify&id=' . $_GET['id'] . '" method="POST" enctype="multipart/form-data">
        <div class="form-input-row">
            <label for="title">Titre</label>
            <input type="text" id="title" name="title"  value="' . $titre . '">
            <label for="caption">Caption</label>
            <textarea type="text" id="caption" cols="25" rows="10" name="caption">' . $caption . '</textarea>
            <label for="image">Image</label>
            <input type="file" id="image" name="image" accept="image/*">
            <button type="submit" name="submit">Modifier</button>
        </div>
        <label for="content">Content</label>
        <textarea name="content" id="content" cols="150" rows="40">' . $description . '</textarea>
    </form>';
        }
    }


    ?>

</main>


<?php include 'includes/footer.php'; ?>
