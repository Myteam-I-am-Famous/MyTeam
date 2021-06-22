<?php

include "includes/functions.php";

if (!isset($_GET['code']) && !isset($_GET['id'])) {
	header('location: ../..ndex.php?code=accessdenied');
	exit();
}

if (!useractivated($_GET['id'])) {
	activateuser($_GET['id']);
	header('location: ../../index.php?code=useractivated');
	exit();
}

header('location: ../../index.php?code=useralreadyactivated');
exit();

