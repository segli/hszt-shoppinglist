<?php
include_once('../config/environment.php');
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('lib/authorization.class.php');
include_once('controllers/session.controller.php');
include_once('lib/inputvalidation.class.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$email = $_SESSION['user']->email;
$invitation_id = $_POST['iid'];
$status = $_POST['status']; // Status: accept, decline

if(Authorization::auth_status_invitation($user_id, $email, $invitation_id)) {

    // Load current invitation
    $invitation = DAOFactory::getInvitationDAO()->load($invitation_id);

    if($invitation->pending == 0) {

        switch($status) {

            case "accept":

                // Add user to household
                $uh = new UserHousehold();
                $uh->isOwner = 0;
                $uh->householdId = $invitation->householdId;
                $uh->userId = $user_id;
                DAOFactory::getUserHouseholdDAO()->insert($uh);

                // Close invitation
                $invitation->pending = 0;
                DAOFactory::getInvitationDAO()->update($invitation);

                $msg = new Message ('Invitation accepted!', 'info');
                $data = $msg->to_array();

                break;

            case "decline":

                // Close invitation
                $invitation->pending = 0;
                DAOFactory::getInvitationDAO()->update($invitation);

                $msg = new Message ('Invitation declined!', 'info');
                $data = $msg->to_array();
                break;

            default:
                $msg = new Message ('Wrong status!', 'info');
                $data = $msg->to_array();
                break;
        }
    } else {
        $msg = new Message ('Invitation already accepted!', 'info');
        $data = $msg->to_array();
    }
} else {
    $msg = new Message ('Not authorized to accept or decline this invitation!', 'error');
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





