<?php
include('includes/database_handler.php');

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
               prénom : <?= $voirProfil['last_name'] ?>
           </div>
            <div>
               age : <?= $voirProfil['age'] ?>
	      </div>
		<div>
		<img src =<?php echo '"../uploads/' . $voirProfil['pseudo'] . '/' . $voirProfil['profile_picture'] . '" style="height:150px;" />'; ?>
		</div>
              <div>
               email : <?php echo$voirProfil['email'] ?>
              </div>
              <br><br>
              <div>
              ip : <?= long2ip($voirProfil['ip']);?> 
              </div>    
           </div>
     </div>
    </div>
</body>
</html>
