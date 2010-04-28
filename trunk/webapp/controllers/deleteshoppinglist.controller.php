<?php
include_once('lib/include_dao.php');
include_once('lib/authorization.class.php');
include_once('lib/message.class.php');
include_once('session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$shoppinglist_id = $_GET['sid'];

if(Authorization::auth_delete_shoppinglist($user_id, $shoppinglist_id)) {

    // Delete items on this shoppinglist
    DAOFactory::getItemDAO()->deleteByShoppinglistId($shoppinglist_id);
    // Delete all bill of this shoppinglist
    DAOFactory::getBillDAO()->deleteByShoppinglistId($shoppinglist_id);
    // Delete shoppinglist itself
    DAOFactory::getShoppinglistDAO()->delete($shoppinglist_id);

    $msg = new Message ('Shoppinglist deleted', 'message');
    $data = $msg->to_array();

} else {
    $msg = new Message ('Not authorized to delete this shoppinglist!', 'error');
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