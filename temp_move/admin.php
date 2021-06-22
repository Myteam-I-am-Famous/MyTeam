<?php


include 'includes/database_handler.php';


$q = 'SELECT pseudo, ip FROM users;';
$stmt = $dbh->prepare($q);

if($stmt->execute())
{
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

	foreach($result as $data)
	{
		var_dump(long2ip($data['ip']));
		var_dump($data['ip']);
	}
}
