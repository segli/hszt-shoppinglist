<?php
include_once('../config/environment.php');
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('lib/authorization.class.php');
include_once('controllers/session.controller.php');
include_once('lib/inputvalidation.class.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$item_id = $_POST['iid'];
$shoppinglist_id = $_POST['sid'];
$status_id = $_POST['status']; // Status: 0 = new, 1 = selected, 2 = commited

if(Authorization::auth_status_item($user_id, $shoppinglist_id)) {

    if($status_id >= 0 AND $status_id < 3) {

        $item = DAOFactory::getItemDAO()->load($item_id);
        $item->status = $status_id;
        DAOFactory::getItemDAO()->update($item);

        $msg = new Message ('Status updated!', 'info');
        $data = $msg->to_array();
    }
} else {
    $msg = new Message ('Not authorized to change the status of this item!', 'error');
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





