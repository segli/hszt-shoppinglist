<?php
include_once('../config/environment.php');
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('lib/authorization.class.php');
include_once('controllers/session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$shoppinglist_id = $_GET['sid'];

if(isset($_GET['sid']) AND $_GET['sid'] >= 0) {
    $items = DAOFactory::getItemDAO()->queryAllByUserIdAndShoppinglistIdNotClosed($user_id, $shoppinglist_id);
} else {
    $items = DAOFactory::getItemDAO()->queryAllByUserIdNotClosed($user_id);
}

if (count($items) > 0) {
    // Prepare Data
    $data = array(
        'items' => $items
    );

} else {
    $msg = new Message ('The shoppinglist with the id ' . $shoppinglist_id . ' has no items or the list is closed.', 'info');
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