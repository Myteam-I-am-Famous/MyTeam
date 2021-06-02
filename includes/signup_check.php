<?php

include './database_handler.php';
include './functions.php';


if (!isset($_POST['submit'])) {
    header('location: ../login.php?accessdenied');
    exit();
}

if (emptyInputs([$_POST['nom'], $_POST['prenom'], $_POST['email'], $_POST['mdp']])) {
    header('location: ../login.php?message=emptyinput');
    exit();
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    header('location: ../login.php?message=invalidemail');
    exit();
}

if (!is_between(strlen($_POST['mdp']), 6, 12)) {
    header('location: ../login.php?message=passwordlenght');
    exit();
}
/* Gavin afouzbfuiazbfuiazbduiabfuiza
if ($_POST['mdp'] !== $_POST['mdprepeat']) {
    header('location: ../login.php?message=passworddontmatch');
    exit();
}

if (invalidAge($_POST['age'])) {
    header('location: ../login.php?message=invalidAge');
    exit();
}*/

if (userexists($dbh, $_POST['email'])) {
    header('location: ../login.php?message=userexists');
    exit();
}
/*if (isset($_FILES['image'])&& !empty($_FILES['image']['name'])){
    //verifier le type du fichier

    $acceptable = [
     'image/jpeg' ,
     'image/png' ,
     'image/gif' ,
    ];
    if (in_array($_FILES['image']['type'], $acceptable)) {
        //redirection si c'est pas le bon type
        // Rediriger vers la page inscription avec une erreur
    header('location:login.php?message=le fichier n\'est pas du bon type');
    exit;
    }

    //vérifier la taille du fichier
    $maxsize = 2 * 1024 * 1024 ;//2Mo


    if ($_FILES['image']['size'] > $maxsize) {
        header('location:login.php?message=le fichier est trop lourd');
    exit;

    }

    //creer un dossier uploads s'il n'existe pas déjà
    $path='uploads';
    if(!file_exists($path)){
        mkdir($path, 0777);
    }
    
$filename = $_FILES['image']['name'] ;
//creer un nom de fichier selon le modele

//recuperer l'extension


$array = explode('.', $filename);
$extension = end($array);

$filename = 'image-' . time() . '.' . $extension; 





$destination = $path . '/' . $filename ; // le chemin où le fichier sera enregistrer

move_uploaded_file($_FILES['image']['tmp_name'], $destination); // deplacement




  function getIp(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
 */
/*if(isset($_POST['email']) && !empty($_POST['email'])){
	setcookie(getIp(), $_POST['getIp()'], time() + (24 * 60 * 60));


	// Ecrire les tentatives de connexion dans un fichier log.txt

	// Ouverture du fichier (avec création si nécessaire)
	$log = fopen('log.txt', 'a+');

	// Formatage de la ligne à ajouter
	$line = date('Y/m/d - H:i:s') . ' -  adresse ip : ' . getIp() . "\n";

	// Ajout de la ligne au fichier
	fputs($log, $line);

	// Fermeture du fichier
	fclose($log);

}
*/

if (!createUser($dbh, $_POST['nom'], $_POST['prenom'], $_POST['age'], $_POST['email'], $_POST['mdp'], $_POST['file'])) {
    header('location: ../login.php?message=createuserfailure');
    exit();
}


header('location: ../index.php?message=accountcreated');
exit();

