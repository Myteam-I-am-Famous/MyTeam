<?php

	include 'includes/database_handler.php';

//	$q = 'SELECT * FROM carte_inventory LEFT JOIN utilisateurs ON carte_inventory.utilisateur_id = utilisateurs.id;';
	$q = 'SELECT * FROM carte INNER JOIN carte_inventory ON carte.id = carte_inventory.carte_id WHERE carte_inventory.utilisateur_id = 4;';
	$stmt = $dbh->prepare($q);
	
	$status = $stmt->execute();

	if($status)
	{
		while($result = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			echo '<br><br>col :<br>';
			foreach($result as $data => $key)
				echo $data . ' : ' . $key . '<br>';
		}

	}

?>
