<?php session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'includes/database_handler.php';

if (isset($_POST['team_overall']) && isset($_SESSION['uid'])) {


    $q = 'UPDATE users SET team_overall = :team_overall WHERE id = :uid;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'team_overall' => $_POST['team_overall'],
            'uid' => $_SESSION['uid']
        )
    );


    echo json_encode([
        'status' => $status
    ]);
}

if (isset($_POST['initialize']) && isset($_SESSION['uid'])) {

    $q = 'SELECT * FROM basketball_cards_variants INNER JOIN basketball_variants_inventory ON basketball_cards_variants.id = basketball_variants_inventory.card INNER JOIN basketball_cards ON basketball_cards.id = basketball_cards_variants.card WHERE user = :uid;';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'uid' => $_SESSION['uid']
        )
    );

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    echo json_encode([
        'status' => $status,
        'data' => $result
    ]);
}
