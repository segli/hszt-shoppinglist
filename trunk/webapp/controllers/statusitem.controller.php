<?php
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('lib/authorization.class.php');
include_once('controller/session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$item_id = $_POST['iid'];
$status_id = $_POST['status'];

if(Authorization::auth_status_item($user_id, $shoppinglist_id)) {

    if($status_id >= 0 AND $status_id < 5) {

        $item = DAOFactory::getItemDAO()->load($item_id);
        $item->status = $status_id;
        DAOFactory::getItemDAO()->update($item);

        $msg = new Message ('Status updated!', 'message');
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





