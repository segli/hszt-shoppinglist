<?php
include_once('../config/environment.php');
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('lib/authorization.class.php');
include_once('controllers/session.controller.php');
include_once('lib/inputvalidation.class.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$household_id = $_POST['hid'];
$email = $_POST['email'];

if($email != $_SESSION['user']->email AND $email != "") {

    $invitation = DAOFactory::getInvitationDAO()->queryAllByEmailAndHouseholdId($email, $household_id);

    // Check if invitation for this user in this household already exist.
    if(count($invitation) == 0) {

        // Check if user is authorized to create an invitation.
        if(Authorization::auth_create_invitation($user_id, $household_id)) {

            $user = DAOFactory::getUserDAO()->queryByEmail($email);

            // Check if invited user is already registered
            if(count($user) > 0) {

                $households = DAOFactory::getUserHouseholdDAO()->queryAllByUserIdAndHouseholdIdAndOwner($user[0]->userId, $household_id);

                // Check if user is already in this household.
                if(count($households) == 0) {

                    $inv = new Invitation();
                    $inv->householdId = $household_id;
                    $inv->email = $user[0]->email;  // Email of the person to invitate!
                    $inv->userId = $user_id;        // UserId of the creator!
                    $inv->pending = 1;
                    $inv->dateCreated = date( 'Y-m-d H:i:s', time());
                    DAOFactory::getInvitationDAO()->insert($inv);

                    // TODO: Send email to invited user! To: $email

                    $msg = new Message ('Invitation created!', 'info');
                    $data = $msg->to_array();

                } else {
                    $msg = new Message ('The user is already in this household.', 'error');
                    $data = $msg->to_array();
                }

            } else {
                // User is not registered
                $inv = new Invitation();
                $inv->householdId = $household_id;
                $inv->email = $email;       // Email of the person to invitate!
                $inv->userId = $user_id;    // UserId of the creator!
                $inv->pending = 1;
                $inv->dateCreated = date( 'Y-m-d H:i:s', time());
                DAOFactory::getInvitationDAO()->insert($inv);

                // TODO: Send email to invited user! To: $email

                $msg = new Message ('Invitation created!', 'info');
                $data = $msg->to_array();
            }
        } else {
            $msg = new Message ('Not authorized to create an invitation for this household!', 'error');
            $data = $msg->to_array();
        }
    } else {
        $msg = new Message ('Invitation for this user in this household already exist!', 'error');
        $data = $msg->to_array();
    }
} else {
    $msg = new Message ('Please enter a email address!', 'error');
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