<?php
include_once('../config/environment.php');
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('lib/authorization.class.php');
include_once('controllers/session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$household_id = $_GET['hid'];


if(isset($_GET['hid']) AND $_GET['hid'] >= 0) {
    $shoppinglists = DAOFactory::getShoppinglistDAO()->queryAllByUserIdAndHouseholdIdNotClosed($user_id, $household_id);
} else {
    $shoppinglists = DAOFactory::getShoppinglistDAO()->queryAllByUserIdNotClosed($user_id);
}

if (count($shoppinglists) > 0) {
    // Prepare Data
    $data = array(
        'shoppinglists' => $shoppinglists
    );

} else {
    $msg = new Message ('The user with the id ' . $user_id . ' has no open/private shoppinglists.', 'info');
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