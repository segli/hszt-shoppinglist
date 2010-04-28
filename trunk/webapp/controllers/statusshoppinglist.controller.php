<?php
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('lib/authorization.class.php');
include_once('session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$shoppinglist_id = $_POST['sid'];
$status_id = $_POST['status']; // Stati: 0 = open, 1 = private, 2 = closed

if(Authorization::auth_status_shoppinglist($user_id, $shoppinglist_id)) {

    if($status_id >= 0 AND $status_id < 5) {

        $shoppinglist = DAOFactory::getShoppinglistDAO()->load($shoppinglist_id);
        $shoppinglist->status = $status_id;
        DAOFactory::getShoppinglistDAO()->update($shoppinglist);

        $msg = new Message ('Status updated!', 'message');
        $data = $msg->to_array();
    }
} else {
    $msg = new Message ('Not authorized to change the status of this shoppinglist!', 'error');
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





