<?php session_start();
$title = "Articles";

include 'includes/head.php';
include 'includes/header.php';


?>

<main>


    <div class="article-list">

        <?php
        include 'includes/functions.php';
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
                        <img src="' . 'uploads/' . $article['title'] . '/' . $article['image'] . '" alt="article thumbnail" />
                        <button>Lire cet article</button>
                    </div>';
            }
        }

        ?>

    </div>



</main>

<?php include 'includes/footer.php'; ?>