<?php
include_once('../lib/include_dao.php');
include_once('../lib/authorization.class.php');
include_once('session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$shoppinglist_name = $_POST['shoppinglist_name'];
$household_id = $_POST['hid'];

// Logic
$shoppinglist = new Shoppinglist();
$shoppinglist->name = $shoppinglist_name;
$shoppinglist->status = 1;
$shoppinglist->householdId = $household_id;
$shoppinglist->userId = $user_id;
//$shoppinglist->dateCreated = time();


if (Authorization::auth_create_shoppinglist($user_id, $household_id)) {

    $id = DAOFactory::getShoppinglistDAO()->insert($shoppinglist);

    if ($id > 0) {
        $data = array(
            'shoppinglistId' => $id
        );

    } else {
        $data = array(
            'error' => '5',
            'message' => 'Something went wrong during the shoppinglist creation process.'
        );
    }
} else {
    $data = array(
        'error' => '5',
        'message' => 'Not authorized to create a shoppinglist in this household!'
    );
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