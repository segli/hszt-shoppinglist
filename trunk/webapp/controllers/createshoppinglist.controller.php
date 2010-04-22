<?php
include_once('lib/include_dao.php');
include_once('session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$shoppinglist_name = $_POST['shoppinglist_name'];

// TODO: Remove
$household_id = 3;

// Logic
$shoppinglist = new Shoppinglist();
$shoppinglist->name = $shoppinglist_name;
$shoppinglist->status = 1;
$shoppinglist->householdId = $household_id;

$id = DAOFactory::getShoppinglistDAO()->insert($shoppinglist);

if ($id > 0) {
    // Prepare Data
    $data = array(
        'shoppinglistId' => $id
    );

} else {

    // Prepare Data
    $data = array(
        'error' => '5',
        'message' => 'Something went wrong during the shoppinglist creation process.'
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