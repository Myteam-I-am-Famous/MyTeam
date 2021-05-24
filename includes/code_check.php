<?php

include "./database_handler.php";
include 'functions.php';

if (!isset($_GET['code'])) {
	header('location: ../index.php?message=nocode');
	exit();
}

echo '<h1>Votre code est ' . $_GET['code'] . '</h1>';

echo 'useractivated : <br>';
echo useractivated($dbh, 'abdoudu78130@gmail.com');

echo '<br><br>userhash : <br>';
echo getuserinfo($dbh, 'hash', 'abdoudu78130@gmail.com');

echo '<br><br>hashedcode : <br>';
echo md5($_GET['code']);

echo '<br>';
