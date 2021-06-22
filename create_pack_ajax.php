<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'includes/database_handler.php';

function searchUser($users, $query)
{
    $result = [];

    foreach ($users as $user) {
        if (
            strpos(strtolower($user['first_name']), strtolower($query)) !== false
            || strpos(strtolower($user['last_name']), strtolower($query)) !== false
        )
            array_push($result, $user);
    }

    return $result;
}

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

    $q = 'SELECT 
    basketball_cards.id,
    basketball_cards_variants.id as vid,
    full_name, position,
    team,
    jersey_number,
    team_abv,
    headshot_url,
    variant,
    variantURL
    FROM basketball_cards
    INNER JOIN basketball_cards_variants
    ON basketball_cards.id = basketball_cards_variants.card
    ORDER BY variant;';
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
