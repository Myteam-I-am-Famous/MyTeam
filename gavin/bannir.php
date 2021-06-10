<?php
include('includes/database_handler.php');

$dbname = "myteam";
$host = 'localhost';
$dsn = "mysql:dbname=" . $dbname . ";host=" . $host;

$user = "myteam";
$password = "myteam";
$dbh = new PDO($dsn, $user, $password);

if(isset($_GET['id']) AND !empty($_GET['id'])){
    $getid=$_GET['id'];
    $recupUser = $dbh->prepare("SELECT * FROM utilisateurs  WHERE id = ? ");
    $recupUser ->execute(array($getid));
    if($recupUser->rowCount()>0){
         
         $bannirUser = $dbh->prepare("DELETE FROM utilisateurs  WHERE id = ?");
         $bannirUser->execute(array($getid));

         header('location: adminboard.php');

    }else{
        echo "Aucun membre n'a été trouvé";
    }
}else{
    echo "l'identifiant n'a pas été récupereé ";
}
