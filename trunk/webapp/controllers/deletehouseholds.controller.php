<?php
include_once('../lib/include_dao.php');
include_once('session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$household_id = $_GET['household_id'];
// Logic
    // delete household
    // delete userhousehold
    // delete shoppinglist
    // delete item

if (true) {
    // Prepare Data
    $data = array(
        'household_id' => $household_id
    );

} else {

    // Prepare Data
    $data = array(
        'error' => '4',
        'message' => 'The user with the id ' . $user_id . ' has no households'
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