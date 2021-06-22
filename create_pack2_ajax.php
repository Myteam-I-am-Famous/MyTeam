<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'includes/functions.php';



function createPack($packName, $packPrice, $packCards)
{
    global $dbh;

    $cards = $packCards;

    if (is_array($cards)) {
        $cards = implode(',', $cards);
    }

    $q = 'INSERT INTO basketball_packs
    VALUES(
        :id,
        :name,
        :price,
        :cards
    );';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'id' => getMaxID('basketball_packs') + 1,
            'name' => $packName,
            'price' => $packPrice,
            'cards' => $cards
        )
    );

    return $status;
}


if (isset($_POST['cards'])) {

    createPack($_POST['name'], $_POST['price'], $_POST['cards']);

    echo json_encode([
        'response' => true,
        'data' => $_POST['cards']
    ]);
}
