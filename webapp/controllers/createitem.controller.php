<?php
include_once('../config/environment.php');
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('lib/authorization.class.php');
include_once('controllers/session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$item_name = $_POST['item_name'];
$shoppinglist_id = $_POST['sid'];

// Logic
$item = new Item();
$item->name = $item_name;
$item->status = 1;
$item->shoppinglistId = $shoppinglist_id;

if($item_name != "") {
    if(Authorization::auth_create_item($user_id, $shoppinglist_id)) {

        $exist = DAOFactory::getItemDAO()->queryAllByShoppinglistIdAndItemName($shoppinglist_id, $item_name);

        if(count($exist) == 0) {

            $id = DAOFactory::getItemDAO()->insert($item);

            if ($id > 0) {
                $data = array(
                    'itemId' => $id
                );

            } else {

                $msg = new Message ('Something went wrong during the item creation process.', 'error');
                $data = $msg->to_array();
            }
        } else {
            $msg = new Message ('An item with this name already exist on this shoppinglist!', 'error');
            $data = $msg->to_array();
        }
    } else {

        $msg = new Message ('Not authorized to insert an item to this shoppinglist.', 'error');
        $data = $msg->to_array();
    }
} else {
    $msg = new Message ('Please enter an item name!', 'error');
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