<?php
if(!isset($_GET['code']))
{
	header('location: ../index.php?message=nocode');
	exit();

}

echo '<h1>Votre code est ' . $_GET['code'] . '</h1>';
