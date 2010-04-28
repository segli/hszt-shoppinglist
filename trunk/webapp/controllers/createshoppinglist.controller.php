<?php
include_once('lib/include_dao.php');
include_once('lib/authorization.class.php');
include_once('lib/message.class.php');
include_once('session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$shoppinglist_name = $_POST['shoppinglist_name'];
$household_id = $_POST['hid'];
if(isset($_POST['private']) AND $_POST['private'] == "on") { $private = 1; } else { $private = 0;}

// Logic
$shoppinglist = new Shoppinglist();
$shoppinglist->name = $shoppinglist_name;
$shoppinglist->status = $private;
$shoppinglist->dateCreated = time();
$shoppinglist->householdId = $household_id;
$shoppinglist->userId = $user_id;
$shoppinglist->dateCreated = time();


if (Authorization::auth_create_shoppinglist($user_id, $household_id)) {

    $exist = DAOFactory::getShoppinglistDAO()->queryAllByHouseholdIdAndShoppinglistName($household_id, $shoppinglist_name);

    if(count($exist) == 0) {

        $id = DAOFactory::getShoppinglistDAO()->insert($shoppinglist);

        if ($id > 0) {
            $data = array(
                'shoppinglistId' => $id
            );

        } else {
            $msg = new Message ('Something went wrong during the shoppinglist creation process.', 'error');
            $data = $msg->to_array();
        }
    } else {
        $msg = new Message ('A shoppinglist with this name already exist in this household!', 'error');
        $data = $msg->to_array();
    }
} else {
    $msg = new Message ('Not authorized to create a shoppinglist in this household!', 'error');
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