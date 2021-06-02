<?php
include('includes/database_handler.php');

$dbname = "myteam";
$host = 'localhost';
$dsn = "mysql:dbname=" . $dbname . ";host=" . $host;

$user = "myteam";
$password = "myteam";
$dbh = new PDO($dsn, $user, $password);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher les membres</title>
</head>
<body>
    <!--afficher tous les membres -->
   <?php 
     $recupUsers = $dbh->query('select * from utilisateurs'); 
      while ($user = $recupUsers->fetch()){
          ?>

           <p><?= $user['email']; ?> <a href="profil.php?id=<?= $user['id']; ?>" style="color:blue;text-decoration:none;">Profil utilisateur</a> <a href="bannir.php?id=<?= $user['id']; ?>" style="color:red ; text-decoration: none;">Bannir le membre </a></p>
          <?php 
      }
    ?>

</body>
</html>
