<?php
include('includes/database_handler.php');

$dbname = "myteam";
$host = 'localhost';
$dsn = "mysql:dbname=" . $dbname . ";host=" . $host;

$user = "myteam";
$password = "myteam";
$dbh = new PDO($dsn, $user, $password);
if(isset($_GET['id']) AND !empty($_GET['id'])){
   $getid= $_GET['id'];
   $recupArticles =$dbh->prepare('SELECT * FROM  articles WHERE id = ?');
   $recupArticles ->execute(array($getid));
   if($recupArticles ->rowCount()> 0){
        $iarticles=$recupArticles->fetch();

        $titre = $iarticles['titre'];
        $description = $iarticles['description'];
        $img = $iarticles['img'];
        str_replace ( '<br />', '',$iarticles['description']);

        if(isset($_POST['valider'])){
        $titre_saisi = htmlspecialchars($_POST['titre']);
        $description_saisi = nl2br(htmlspecialchars($_POST['description']));
        $img_saisi = htmlspecialchars($_POST['img']);
        //problème par ici || || 
        $update = $dbh->prepare('UPDATE articles SET titre = ? AND img = ? AND description = ? WHERE id = ?');
        $update ->execute(array($titre_saisi, $description_saisi, $img, $getid));
         
        header('Location: articles.php');
        }
   }else{
       echo"Aucun article trouvé";

   }

}else{
    echo"Aucun identifiant trouvé";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l Article <?= $recupArticles['title'] ?></title>
</head>
<body>

       <form action="" method="post">
        <input type="text" name="titre" value="<?= $titre; ?>">
        <br>
        <textarea name="description" value="<?= $description; ?>"></textarea>
        <br><br>
        <input type="file" name="img" accept="image/gif,image/png, image/jpeg," value="<?= $img; ?>">
        <br><br><br>
        <input type="submit" name="valider">

     </form>
</body>
</html>
