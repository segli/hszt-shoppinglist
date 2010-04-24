<?php
include_once('../lib/include_dao.php');
include_once('session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$household_id = $_GET['hid'];

if(isset($_GET['hid']) AND $_GET['hid'] >= 0) {
    $shoppinglists = DAOFactory::getShoppinglistDAO()->queryAllByUserIdAndHouseholdId($user_id, $household_id);
} else {
    $shoppinglists = DAOFactory::getShoppinglistDAO()->queryAllByUserId($user_id);
}


if (count($shoppinglists) > 0) {
    // Prepare Data
    $data = array(
        'shoppinglists' => $shoppinglists
    );

} else {

    // Prepare Data
    $data = array(
        'error' => '4',
        'message' => 'The user with the id ' . $user_id . ' has no shoppinglists'
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