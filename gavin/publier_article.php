<?php
include('includes/database_handler.php');

if(isset($_POST['envoi'])){

    if(!empty($_POST['titre']) || !empty($_POST['description']) ||!empty($_POST['img']) || !empty($_POST['img'])){

        $titre = htmlspecialchars($_POST['titre']);
        $description = nl2br(htmlspecialchars($_POST['description']));
        $img = htmlspecialchars($_POST['img']);

        $insertArticle = $dbh->prepare('INSERT INTO articles(title, content, image) VALUES(? ,? ,?)');
        $insertArticle->execute(array($titre, $description,$img));


        echo "l'article a bien été envoyé";
    

    }else{
       echo "Veuillez compléter tous les champs ";
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier un article </title>
    <link rel="stylesheet" type="text/css" href="article.css"/>
</head>
<body>

	<br><br>

	<a href="adminboard.php">Retour au panel d'administration</a>

	<br><br>

	<a href="articles.php">Acceder aux articles</a>

	<br><br>

      <form method="post" action="">
       <input type="text" name="titre">
       <br>
       <textarea name="description" ></textarea>
       <br>
       <input type="file" name="img" accept="image/gif,image/png, image/jpeg,">
       <br>
       <input type="submit" name="envoi">
      </form>



</body>
</html>
