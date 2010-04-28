<?php
include_once('../config/environment.php');
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('lib/authorization.class.php');
include_once('controllers/session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$shoppinglist_id = $_POST['sid'];
$status_id = $_POST['status']; // Status: 0 = open, 1 = private, 2 = closed

if(Authorization::auth_status_shoppinglist($user_id, $shoppinglist_id)) {

    if($status_id >= 0 AND $status_id < 3) {

        $shoppinglist = DAOFactory::getShoppinglistDAO()->load($shoppinglist_id);

        // If current status != closed
        if($shoppinglist[0]->status != 2) {

            // New status == closed
            if($status_id == 2) {
                $shoppinglist->status = $status_id;
                $shoppinglist->dateClosed = date('Y-m-d H:i:s', time());

                $msg = new Message ('Status changed, shoppinglist closed!', 'info');
                $data = $msg->to_array();
            } else {
                $shoppinglist->status = $status_id;

                $msg = new Message ('Status changed!', 'info');
                $data = $msg->to_array();
            }
        } else {
            $msg = new Message ('Shoppinglist closed! Status can not be changed!', 'error');
            $data = $msg->to_array();
        }

        DAOFactory::getShoppinglistDAO()->update($shoppinglist);
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





