<?php session_start();

include "./includes/functions.php";


header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');



if (!isset($_SESSION['uid'])) {
    header("location: shop_card.php?code=accessdenied");
    exit;
}

if (!isset($_POST['id'])) {
    header('location: shop_card.php?code=invalidid');
    exit;
}

$cards = getCardsByUID($_SESSION['uid']);
$hasCard = false;


foreach ((array) $cards as $key => $card) {
    if ($card['bid'] == $_POST['id']) {
        $hasCard = true;
        break;
    }
}

if (!$hasCard) {

    addCard(
        $_SESSION['uid'],
        $_POST['id'],
        $_POST['fullname'],
        $_POST['jersey'],
        $_POST['headshot'],
        $_POST['position'],
        $_POST['team'],
        $_POST['teamABV'],
        'NBA',
        $_POST['gp'],
        $_POST['min'],
        $_POST['fg'],
        $_POST['tp'],
        $_POST['ft'],
        $_POST['reb'],
        $_POST['ast'],
        $_POST['blk'],
        $_POST['stl'],
        $_POST['ppg'],
        98
);

    echo json_encode([
        'id' => $_POST['id'],
        "fullName" => $_POST['fullname'],
        "jersey" => $_POST['jersey'],
        "headshot" => $_POST['headshot'],
        "position" => $_POST['position'],
        "team" => $_POST['team'],
        "team_abv" => $_POST['teamABV'],
        "league" => 'NBA',
        "game_played" => $_POST['gp'],
        "min" => $_POST['min'],
        "fg" => $_POST['fg'],
        "tp" => $_POST['tp'],
        "ft" => $_POST['ft'],
        "reb" => $_POST['reb'],
        "ast" => $_POST['ast'],
        "blk" => $_POST['blk'],
        "stl" => $_POST['stl'],
        "ppg" => $_POST['ppg'],
        'result' => 'true',
        'code' => '0',
        'message' => 'the user does not have this card'
    ]);
} else {


    echo json_encode([
        'id' => $_POST['id'],
        "fullName" => $_POST['fullname'],
        "jersey" => $_POST['jersey'],
        "headshot" => $_POST['headshot'],
        "position" => $_POST['position'],
        "team" => $_POST['team'],
        "team_abv" => $_POST['teamABV'],
        "league" => 'NBA',
        "game_played" => $_POST['gp'],
        "min" => $_POST['min'],
        "fg" => $_POST['fg'],
        "tp" => $_POST['tp'],
        "ft" => $_POST['ft'],
        "reb" => $_POST['reb'],
        "ast" => $_POST['ast'],
        "blk" => $_POST['blk'],
        "stl" => $_POST['stl'],
        "ppg" => $_POST['ppg'],
        'result' => "false",
        "code" => "2",
        "message" => "the user already has this card"
    ]);
}
