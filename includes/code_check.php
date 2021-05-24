<?php

include "./database_handler.php";
include 'functions.php';

if (!isset($_GET['code']) && !isset($_GET['id'])) {
	header('location: ../index.php?message=accessdenied');
	exit();
}

if (!useractivated($dbh, $_GET['id'])) {
	activateuser($dbh, $_GET['id']);
	header('location: ../index.php?message=useractivated');
	exit();
}

header('location: ../index.php?message=useralreadyactivated');
exit();
