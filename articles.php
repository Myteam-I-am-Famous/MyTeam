<?php session_start();
$title = "Articles";

include 'includes/head.php';
include 'includes/header.php';


?>

<main>

<?php

        if ((isset($_SESSION['role']) && $_SESSION['role'] == 2)) {
            echo '<a href="creation_article" id="edit-article">
                <i class="fas fa-pen-nib"></i>
            </a>';
	}?>

    <div class="article-list">

        <?php

        function getDataByUID($uid, $data = "*", $table = 'users')
        {
            global $dbh;

            $q = 'SELECT ' . $data . ' FROM ' . $table . ' WHERE id = :id;';
            $stmt = $dbh->prepare($q);

            if ($stmt->execute(['id' => $uid])) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return false;
        }


        $articles = getDataFrom('articles');

        if ($articles) {
            foreach ($articles as $article) {
                echo '<div class="article-thumbnail">
                        <p>' . getDataByUID($article['author'], 'pseudo')[0]['pseudo'] . '</p>
                        <h3>' . $article['title'] . '</h3>
                        <img src="' . 'uploads/articles/' . $article['image'] . '" alt="article thumbnail" />
                        <a href="article/' . $article['id'] . '"><button>Lire cet article</button></a>
                    </div>';
            }
        }

        ?>

    </div>



</main>

<?php include 'includes/footer.php'; ?>
