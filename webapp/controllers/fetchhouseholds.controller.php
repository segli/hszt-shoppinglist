<?php
include_once('lib/include_dao.php');
include_once('session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;

// Logic
$households = DAOFactory::getHouseholdDAO()->queryAllByUserId($user_id);

if (count($households) > 0) {
    // Prepare Data
    $data = array(
        'households' => $households
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