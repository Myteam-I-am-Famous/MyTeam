<?php session_start();



header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'includes/functions.php';


if (isset($_GET['request']) && $_GET['request'] == 'read') {

    if (isset($_GET['recipient'])) {
        $q = 'SELECT * FROM messages
    WHERE
    (author = :author OR author = :recipient)
    AND
    (recipient = :recipient OR recipient = :author)
    ORDER BY time ASC;';
        $stmt = $dbh->prepare($q);
        $status = $stmt->execute(
            array(
                'author' => $_SESSION['uid'],
                'recipient' => $_GET['recipient']
            )
        );

        if ($status) {
            $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode([
                'status' => count($messages) > 0,
                'type' => 'conversation between ' . $_SESSION['uid'] . ' and ' . $_GET['recipient'] . '.',
                'uid' => $_SESSION['uid'],
                'messages' => $messages
            ]);
            exit;
        }
    }
    $messages = getDataFrom('messages', "id", "ASC");

    echo json_encode([
        'status' => count($messages) > 0,
        'uid' => $_SESSION['uid'],
        'messages' => $messages
    ]);
    exit;
}

if (aresetAndNotEmpty([
    $_POST['message'],
    $_POST['time'],
    $_POST['recipient']
])) {
    $q = 'INSERT INTO messages
VALUES(
    :id,
    :message,
    :time,
    :author,
    :recipient
);';
    $stmt = $dbh->prepare($q);
    $status = $stmt->execute(
        array(
            'id' => getMaxID('messages') + 1,
            'message' => $_POST['message'],
            'time' => $_POST['time'],
            'author' => $_SESSION['uid'],
            'recipient' => $_POST['recipient']
        )
    );

    if ($status) {
        echo json_encode([
            'status' => true,
            'message' => $_POST['message']
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => false,
            'message' => $_POST['message']
        ]);
        exit;
    }
}

echo json_encode([
    'status' => false,
    'error' => "could not get any data"
]);
exit;
