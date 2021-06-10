<?php session_start();
$title = "Publier un article";

include 'includes/head.php';
include 'includes/header.php';
?>


<main>


    <form class="article-form" action="publish_article_check.php" method="POST" enctype="multipart/form-data">
        <div class="form-input-row">
            <label for="title">Title</label>
            <input type="text" id="title" name="title">
            <label for="image">image</label>
            <input type="file" id="image" name="image" accept="image/*">
            <button type="submit" name="submit">Publish</button>
        </div>
        <label for="content">Content</label>
        <textarea name="content" id="content" cols="150" rows="40"></textarea>
    </form>


</main>


<?php include 'includes/footer.php'; ?>