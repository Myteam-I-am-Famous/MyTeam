<?php

include "./database_handler.php";
include 'functions.php';

if (!isset($_GET['code']) && !isset($_GET['id'])) {
	header('location: ../index.php?message=accessdenied');
	exit();
}


echo useractivated($dbh, $_GET['id']);


echo '<br><br>userhash : <br>';
echo getuserinfo($dbh, 'hash', 'abdoudu78130@gmail.com');

echo '<br><br>hashedcode : <br>';
echo md5($_GET['code']);

echo '<br>';
