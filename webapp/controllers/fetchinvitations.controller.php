<?php
include_once('../lib/include_dao.php');
include_once('session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;

$invitations = DAOFactory::getInvitationDAO()->queryAllByUserId($user_id);

if (count($invitations) > 0) {

    $data = array(
        'invitations' => $invitations
    );

} else {

    $data = array(
        'error' => '4',
        'message' => 'No invitations found for this user.'
    );

}

// Convert to JSON
$json = json_encode($data);

// Set content type
header('Content-type: application/json');

// Prevent caching
header('Expires: 0');

// Send Response
print($json);
exit;