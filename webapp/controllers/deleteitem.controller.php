<?php
include_once('../config/environment.php');
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('lib/authorization.class.php');
include_once('controllers/session.controller.php');
include_once('lib/inputvalidation.class.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$item_id = $_GET['iid'];


if(Authorization::auth_delete_item($user_id, $item_id)) {

    // Delete items
    DAOFactory::getItemDAO()->delete($item_id);

    $msg = new Message ('Item deleted', 'info');
    $data = $msg->to_array();

} else {
    $msg = new Message ('Not authorized to delete this item!', 'error');
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