<?php
include_once('../config/environment.php');
include_once('lib/include_dao.php');
include_once('lib/message.class.php');
include_once('lib/authorization.class.php');
include_once('controllers/session.controller.php');
include_once('lib/inputvalidation.class.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$shoppinglist_id = $_POST['sid'];
// TODO: ITEMS AUSLESEN!!
$cost = $_POST['commit_cost'];

if($cost != "") {
    if(Authorization::auth_create_bill($user_id, $shoppinglist_id)) {

        // Create bill
        $bill = new Bill();
        $bill->cost = $cost;
        $bill->userId = $user_id;
        $bill->dateCreated = date( 'Y-m-d H:i:s', time());
        $bill->shoppinglistId = $shoppinglist_id;
        $id = DAOFactory::getBillDAO()->insert($bill);

        echo $id;
        
        // Update budget
        $budget = DAOFactory::getBudgetDAO()->queryAllByShoppinglistId($shoppinglist_id);

        var_dump($budget);
        exit;

        $budget->budgetCurrent = $budget->budgetCurrent + $cost;
        DAOFactory::getBudgetDAO()->update($budget);

        // TODO: Status der ITEMS updaten --> 2 : commited!

        $msg = new Message ('Bill created and budget updated!', 'info');
        $data = $msg->to_array();

    } else {
        $msg = new Message ('Not authorized to create a bill!', 'error');
        $data = $msg->to_array();
    }
} else {
    $msg = new Message ('Please enter a price!', 'info');
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