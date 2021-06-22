<?php session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'includes/functions.php';


if (!isset($_POST['id']) || empty($_POST['id']) || !isset($_SESSION['uid'])) {
    echo json_encode([
        'status' => false,
        'data' => 'invalid input'
    ]);
    exit;
}

$user = getDataByID($_SESSION['uid']);
$pack = getDataByID($_POST['id'], '*', 'basketball_packs');

if ($user[0]['mt_points'] < $pack[0]['price']) {
    echo json_encode([
        'status' => false,
        'mt_points' => $user[0]['mt_points'],
        'price' => $pack[0]['price'],
        'data' => 'not enough money'
    ]);
    exit;
}

$remainingPoints = $user[0]['mt_points'] - $pack[0]['price'];


$q = 'UPDATE users SET mt_points = :remainingPoints WHERE id = :uid;';
$stmt = $dbh->prepare($q);
$status = $stmt->execute(
    array(
        'remainingPoints' => $remainingPoints,
        'uid' => $_SESSION['uid']
    )
);


$cards = explode(',', $pack[0]['cards']);
$cardIndex = array_rand($cards, 1);
$card = getDataByID($cards[$cardIndex], '*', 'basketball_cards_variants');

$q = 'SELECT COUNT(*) FROM basketball_variants_inventory WHERE card = :card AND user = :uid;';
$stmt = $dbh->prepare($q);
$status = $stmt->execute(
    array(
        'card' => $card[0]['id'],
        'uid' => $_SESSION['uid']
    )
);

if ($stmt->fetch()[0] > 0) {

    $refund = intval($pack[0]['price'] / 2);

    $q = 'UPDATE users SET mt_points = (mt_points + :refund) WHERE id = :uid;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'refund' => $refund,
            'uid' => $_SESSION['uid']
        )
    );


    echo json_encode([
        'status' => false,
        'message' => 'duplicate',
        'mt_points' => $user[0]['mt_points'],
        'remainingPoints' => $remainingPoints,
        'price' => $pack[0]['price'],
        'refund' => $refund,
        'solution' => 'redeem 750 points'
    ]);
    exit;
}

$q = 'INSERT INTO basketball_variants_inventory
VALUES(
    :id,
    :user,
    :card
);';
$stmt = $dbh->prepare($q);
$status = $stmt->execute(
    array(
        'id' => getMaxID('basketball_variants_inventory') + 1,
        'user' => $_SESSION['uid'],
        'card' => $card[0]['id']
    )
);
echo json_encode([
    'status' => $status,
    'mt_points' => $user[0]['mt_points'],
    'remainingPoints' => $remainingPoints,
    'price' => $pack[0]['price'],
    'data' => $card
]);
