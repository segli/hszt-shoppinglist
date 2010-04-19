<?php
include_once('lib/include_dao.php');

session_start();

if (!isset($_SESSION['isAuth']) || !is_int($_SESSION['isAuth'] * 1)) {
    // Return to login page
    header('location: index.php');
    exit;
}

// POST / GET variables
$user_id = $_SESSION['isAuth'];

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