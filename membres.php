<?php
include('includes/database_handler.php');

$dbname = "myteam";
$host = 'localhost';
$dsn = "mysql:dbname=" . $dbname . ";host=" . $host;

$user = "myteam";
$password = "myteam";
$dbh = new PDO($dsn, $user, $password);
class User {
    
    static function select($uservalue) { // $uservalue c'est la valeurs qu'ont souhaite récupérer.
    global $dbh; // Ce qui permettra d'avoir accès à notre variable de base de données.
    if(isset($_GET['id']) AND !empty($_GET['id'])) { // On vérifie si l'utilisateur est bien connecté, il est déconnecté ont retourne false
       $getid= $_GET['id'];     
      $users_select = $dbh->prepare("select * from utilisateurs  WHERE id = ?");
      $users_select->execute(array($getid));
      $users_select = $users_select->fetch();
      $users_select = $users_select[$uservalue];
	    }}
    static function isBanned() {
      global $dbh; // Ce qui permettra d'avoir accès à notre variable de base de données.
      if(User::select('banned') == '1') { // si l'utilisateur est banni ont retourne true
        return true;
      } else { // sinon on retourne false.
        return false;
      }
   }
 
}
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
                <p><?= $user['email']; ?> <a href="profil.php?id=<?= $user['id']; ?>" style="color:blue;text-decoration:none;">Profil utilisateur
 <a href="bannir.php?id=<?= $user['id']; ?>" style="color:red ; text-decoration: none;">Supp DEF  le membre </a>

  <?php if($user['banned'] == '1'):?>
                            <button type="submit"  name="unban" value="<?= $user['email'] ?>" class="btn btn-warning btn-xs">UnBan</button>
                        <?php else: ?>
                            <button type="submit" name="ban" value="<?= $user['email'] ?>" class="btn btn-warning btn-xs">ban</button>
                        <?php endif; ?></p>
 <?php 
      }
 ?>

              <div>
                  <button id="location-button">LOCALISATION</button>
              </div>


         <script>
        $('#location-button').click(function(){
            if(naviagtor.geolocation)naviagtor.geolocation.getCurrentPosition(function(position){
                console.log(position);
                $.get ("http://maps.googleapis.com/maps/api/geocode/json?latIng="+ position.coords.latitude + ","+ position.coords.longitude +"&sensor-false",function(data){
                console.log("data");
                })
                

            });
            else
            console.log( "XXXX NO HAHA XXXXXX");

        });


    </script>
</body>
</html>
