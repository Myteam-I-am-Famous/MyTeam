<?php session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include 'includes/functions.php';

if (!isset($_POST['event_id']) || empty($_POST['event_id'])) {
    echo json_encode([
        'status' => false,
        'response' => 'Could not get any event ID to work with !'
    ]);

    exit;
}

if (!isset($_SESSION['uid'])) {
    echo json_encode([
        'status' => false,
        'response' => 'Could not get any session to work with !'
    ]);

    exit;
}

$userEvent = getDataByID($_SESSION['uid'], 'event')[0];

if ($userEvent['event'] == $_POST['event_id']) {
    if (quitEvent($_SESSION['uid'], $_POST['event_id'])) {

        echo json_encode([
            'status' => true,
            'operation' => 'quit',
            'response' => 'Successfully removed user from the event.'
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => false,
            'response' => 'Failed to remove user from the event.'
        ]);
        exit;
    }
} else {


    if (joinEvent($_SESSION['uid'], $_POST['event_id'])) {

        echo json_encode([
            'status' => true,
            'operation' => 'join',
            'response' => 'Successfully added a new user to the event.'
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => false,
            'response' => 'Failed to add a new user to the event.'
        ]);
        exit;
    }
}
