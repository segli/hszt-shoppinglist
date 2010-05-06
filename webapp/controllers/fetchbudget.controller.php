<?php
include_once('../config/environment.php');
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('lib/authorization.class.php');
include_once('controllers/session.controller.php');
include_once('lib/inputvalidation.class.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$household_id = $_GET['hid'];


if(isset($_GET['hid']) AND $_GET['hid'] >= 0) {

    // Load budget for this household.
    $budget = DAOFactory::getBudgetDAO()->queryAllByUserIdAndHouseholdId($user_id, $household_id);

    if (count($budget) == 1) {
        $data = array(
            'budget' => $budget
        );

    } else {
        $msg = new Message ('This household has no budget created yet!', 'error ');
        $data = $msg->to_array();
    }
} else {
    $msg = new Message ('Please enter a household id!', 'info');
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