<?php
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;

$invitations = DAOFactory::getInvitationDAO()->queryAllByUserId($user_id);

if (count($invitations) > 0) {

    $data = array(
        'invitations' => $invitations
    );

} else {
    $msg = new Message ('No invitations found for this user.', 'error');
    $data = $msg->to_array();
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