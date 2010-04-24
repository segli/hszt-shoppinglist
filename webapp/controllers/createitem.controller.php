<?php
include_once('../lib/include_dao.php');
include_once('../lib/authorization.class.php');
include_once('session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$item_name = $POST['item_name'];

// TODO: Remove
$shoppinglist_id = 3; // Muss aus POST oder GET gelesen werden.

// Logic
$item = new Item();
$item->name = $item_name;
$item->status = 0;
$item->shoppinglistId = $shoppinglist_id;


if(Authorization::auth_create_item($user_id, $shoppinglist_id)) {
    $id = DAOFactory::getItemDAO()->insert($item);

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
        'message' => 'Not authorized to insert an item to this shoppinglist.'
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