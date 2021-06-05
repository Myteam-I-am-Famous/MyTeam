<?php
include('includes/database_handler.php');

$dbname = "myteam_rebuild";
$host = 'localhost';
$dsn = "mysql:dbname=" . $dbname . ";host=" . $host;

$user = "myteam";
$password = "myteam";
$dbh = new PDO($dsn, $user, $password);

if(isset($_GET['id']) AND !empty($_GET['id'])){
    $getid =  trim($_GET['id']);
    $recupProfil = $dbh->prepare('SELECT * FROM users WHERE id = ?');
    $recupProfil->execute(array($getid));
    $voirProfil =$recupProfil->fetch();

    if(!isset($voirProfil['id'])){


        header('location : membres.php');
   
   }



}else{
   echo"Aucun id trouvé";
   header("Location: membres.php");

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?= $voirProfil['email'] ?></title>
</head>
<body>
    <div class="container">
     <div class="row">
           <div>
               nom : <?= $voirProfil['first_name'] ?>
           </div>
           <div>
               prenom : <?= $voirProfil['last_name'] ?>
           </div> 
           <div>
               age : <?= $voirProfil['age'] ?>
	      </div>
	       <div>
	       pfp : <?php echo '<img src="./myteam_rebuild/uploads/' . $voirProfil['pseudo'] . '/' . $voirProfil['profile_picture'] . '" style="height:150px;" />'; ?>
	      </div>
              <div>
               email : <?= $voirProfil['email'] ?>
              </div>
              <br><br>
              <div>
              ip : <?=long2ip($voirProfil['ip']);?> 
              </div>    
           </div>
     </div>
    </div>
</body>
</html>
