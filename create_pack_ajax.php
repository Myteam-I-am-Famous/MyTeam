<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'includes/database_handler.php';



function searchAthlete($athletes, $query)
{
    $result = [];

    foreach ($athletes as $athlete) {
        if (
            strpos(strtolower($athlete['full_name']), strtolower($query)) !== false
            || strpos(strtolower($athlete['position']), strtolower($query)) !== false
            || strpos(strtolower($athlete['team']), strtolower($query)) !== false
            || strpos(strtolower($athlete['jersey_number']), strtolower($query)) !== false
            || strpos(strtolower($athlete['team_abv']), strtolower($query)) !== false
        )
            array_push($result, $athlete);
    }

    return $result;
}

if (isset($_POST['query'])) {

    $q = 'SELECT * FROM basketball_cards ORDER BY full_name;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute();
    if ($status) {
        $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = searchAthlete($response, $_POST['query']);
    } else
        $result = false;

    echo json_encode([
        'status' => $result != false,
        'response' => $result
    ]);
}
