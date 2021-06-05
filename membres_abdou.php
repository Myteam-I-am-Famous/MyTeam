<?php
include('includes/database_handler.php');

$dbname = "myteam_rebuild";
$host = 'localhost';
$dsn = "mysql:dbname=" . $dbname . ";host=" . $host;

$user = "myteam";
$password = "myteam";

try {
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
    die();
}

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
     $recupUsers = $dbh->query('select * from users'); 
      while ($user = $recupUsers->fetch()){
          ?>
                <p><?= $user['email']; ?> <a href="profil_abdou.php?id=<?= $user['id']; ?>" style="color:blue;text-decoration:none;">Profil utilisateur
 <a href="bannir.php?id=<?= $user['id']; ?>" style="color:red ; text-decoration: none;">Supp DEF  le membre </a>

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
