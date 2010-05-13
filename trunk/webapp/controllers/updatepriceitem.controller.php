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
$price = $_POST['price'];

if(Authorization::auth_status_item($user_id, $shoppinglist_id)) {

    if(is_numeric($price)) {

        $item = DAOFactory::getItemDAO()->load($item_id);
        $item->price = $price;
        DAOFactory::getItemDAO()->update($item);

        $msg = new Message ('Price updated!', 'info');
        $data = $msg->to_array();
    }
} else {
    $msg = new Message ('Not authorized to change the price of this item!', 'error');
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





