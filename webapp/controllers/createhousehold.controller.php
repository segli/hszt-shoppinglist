<?php
include_once('../lib/include_dao.php');
include_once('session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$household_name = $_POST['household_name'];

// Logic
$household = new Household();
$household->name = $household_name;

$id = DAOFactory::getHouseholdDAO()->insert($household);
$userhousehold = new UserHousehold();
$userhousehold->userId = $user_id;
$userhousehold->householdId = $id;
$userhousehold->isOwner = 1;

$userhousehold_id = DAOFactory::getUserHouseholdDAO()->insert($userhousehold);

if ($userhousehold_id > 0) {
    // Prepare Data
    $data = array(
        'userhouseholdid' => $userhousehold_id
    );

} else {

    // Prepare Data
    $data = array(
        'error' => '3',
        'message' => 'Something went wrong during the household creation process.'
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