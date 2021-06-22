<?php session_start();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('location: articles.php?code=noarticlefound');
    exit;
}


$title = "James Harden Bléssé ?";

include 'includes/head.php';
include 'includes/header.php';
?>


<main>

    <div class="article-container">

        <?php

        if ((isset($_SESSION['role']) && $_SESSION['role'] == 2)) {
            echo '<a href="edition_article/' . $_GET['id'] . '" id="edit-article">
                <i class="fas fa-edit"></i>
            </a>';
        }

        $tags = getDataFrom('tags', 'CHAR_LENGTH(name)', 'ASC');
        $article = getDataByID($_GET['id'], '*', 'articles');

        if (!$article) {
            // header('location: articles.php?code=noarticlefound');
            echo '<h1>no article found</h1>';
            echo '<a href="articles.php?code=noarticlefound">Go back to articles</a>';
            exit;
        }

        $article = $article[0];

        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
        date_default_timezone_set('Europe/Paris');


        ?>

        <div id="tags">
            <?php
            foreach ($tags as $tag) {
                echo '<h3 class="tag">' . $tag['name'] . '</h3>';
            }
            ?>
        </div>

        <div id="article-title">
            <h1><?php echo $article['title']; ?></h1>
        </div>

        <figure id="article-image">
            <img src=<?php echo '"uploads/articles/' . $article['image'] . '"' ?> alt="">
            <figcaption><?php echo $article['caption'] !== null ? $article['caption'] : '' ?></figcaption>
        </figure>

        <p id="article-content">
            <?php echo $article['content'] ?>
        </p>

        <p id="article-date"> <?php echo utf8_encode(strftime('%A %d %B %Y, %H:%M', $article['date'] - (12 * 3600))); ?></p>
        <div class="article-share">
            <i class="fab fa-facebook-f"></i>
            <i class="fab fa-twitter"></i>
            <i class="fab fa-instagram"></i>
        </div>

        <div class="article-navigation">
		<?php

            $articles = getDataFrom('articles', 'id', 'ASC');

            if ($article['id'] - 2 >= 0) {

                $previousArticle = $articles[$article['id'] - 2];
                echo '<a href="article/' . $previousArticle['id'] . '"><div id="previous-article">' . $previousArticle['title'] . '</div></a>';
	    }else{
		echo '<div></div>';
	    }

            if ($article['id'] < count($articles)) {
                $nextArticle = $articles[$article['id']];
                echo '<a href="article/' . $nextArticle['id'] . '"><div id="next-article">' . $nextArticle['title'] . '</div></a>';
            }

            ?>	    
	    </div>

    </div>

</main>


<?php include 'includes/footer.php'; ?>
