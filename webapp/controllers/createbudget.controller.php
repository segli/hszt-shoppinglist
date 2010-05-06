<?php
include_once('../config/environment.php');
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('lib/authorization.class.php');
include_once('controllers/session.controller.php');
include_once('lib/inputvalidation.class.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$household_id = $_POST['hid'];
$time_start = $_POST['time_start'];
$time_end = $_POST['time_end'];
$quota = $_POST['quota'];

if (Authorization::auth_create_budget($user_id, $household_id)) {

    // Check if variables are empty!
    $budget = new Budget();
    $budget->timeStart = $time_start;
    $budget->timeEnd = $time_end;
    $budget->householdId = $household_id;
    $budget->budgetQuota = $quota;
    $budget->budgetCurrent = 0;

    $exist = DAOFactory::getBudgetDAO()->queryByHouseholdId($household_id);

    if(count($exist) == 0) {

        DAOFactory::getBudgetDAO()->insert($budget);
        $msg = new Message ('Budget created!', 'info');
        $data = $msg->to_array();
    } else {
        $msg = new Message ('A budget already exist for this household!', 'error');
        $data = $msg->to_array();
    }
} else {
    $msg = new Message ('Not authorized to create a budget in this household!', 'error');
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