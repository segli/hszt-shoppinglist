<?php
include_once('../config/environment.php');
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('lib/authorization.class.php');
include_once('controllers/session.controller.php');
include_once('lib/inputvalidation.class.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$user_email = $_SESSION['user']->email;

$invitations = DAOFactory::getInvitationDAO()->queryAllByEmail($user_email);

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