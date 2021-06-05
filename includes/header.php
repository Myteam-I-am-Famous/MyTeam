<?php session_start(); ?>
<?php

function incrementer_compteur(string $fichier): void
{

    $compteur = 1;
    if (file_exists($fichier)) {
        $compteur = (int)file_get_contents($fichier);
        $compteur++;


        $file = fopen($fichier, 'w');
        fwrite($file, $compteur);

        fclose($file);
    } else {
        file_put_contents($fichier, "1");
    }
}

function nombre_vues(): string
{
    $fichier = dirname('.') . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'compteur.txt';
    incrementer_compteur($fichier);
    return file_get_contents($fichier);
}

$total = nombre_vues();

var_dump($total);

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Myteam</title>
    <link rel="stylesheet" href="css/style.css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/7d4db968a5.js" crossorigin="anonymous"></script>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
    <header>
        <div class="logo-container">
            <img src="./assets/images/myteam_logo_football.png" alt="logo" class="logo" />
            <h1>MyTeam</h1>
            <h4>Le site des amateurs de sports</h4>
            <!-- <video src="assets/videos/myteam_football.mp4" autoplay loop></video> -->
        </div>

        <nav>
            <ul class="nav-links">
                <li><a href="#" class="nav-link">Acceuil</a></li>
                <li><a href="myteam/index.html" class="nav-link">My Team</a></li>
                <li><a href="#" class="nav-link">Sports</a></li>
                <li><a href="#" class="nav-link">Boutique</a></li>
                <li><a href="#" class="nav-link">Actualités</a></li>
                <li><a href="subsciption.php" class="nav-link">S'abonner</a></li>
                <!-- <li><a href="#" class="nav-link"></a></li> -->
            </ul>
        </nav>

        <div class="account-container">
            <?php if (isset($_SESSION['uid'])) {
                echo '
                <a href="#">Mon compte</a>
                <a href="./includes/connection_check.php">Se déconnecter</a>
                ';
            } else {
                echo "
                <a href='login.php?status=login'>Se connecter</a>
                <a href='login.php?status=signup'>S'inscrire</a>
                ";
            }
            ?>

        </div>
    </header>
