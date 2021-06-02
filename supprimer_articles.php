<?php
include('includes/database_handler.php');
/*
$dbname = "myteam";
$host = 'localhost';
$dsn = "mysql:dbname=" . $dbname . ";host=" . $host;

$user = "myteam";
$password = "myteam";
$dbh = new PDO($dsn, $user, $password);

if(isset($_GET['id']) AND !empty($_GET['id'])){
      $getid = $_GET['id'];
      $recupArticles = $dbh->prepare('SELECT * FROM articles WHERE id = ?');
      $recupArticles->execute(array($getid));
        if($recupArticles->rowCount()> 0){
            // $supprimerArticle = $dbh->prepare('DELETE FROM articles WHERE id = ?');
            // $supprimerArticle ->execute(array($getid));

             header('Location : articles.php?message=article-' . $getid . '-supprimer');
        }else{
            echo"Aucun article touvé";
        }
}else{
    echo "Aucun identifiant trouvé";
}
?>*/

if(isset($_GET['id']) && !empty($_GET['id'])){

	$q = 'DELETE FROM articles WHERE id = :id;';
	$stmt = $dbh->prepare($q);
	$status = $stmt->execute(
		array(
			'id'=>$_GET['id']
		));
	if($status){
		header('location: articles.php?message=article-' . $_GET['id'] .  '-deleted');
		exit();
	}
}else{
	header('location: articles.php?message=invalidarticleid');
	exit();

}
