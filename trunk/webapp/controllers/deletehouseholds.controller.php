<?php
include_once('lib/include_dao.php');
include_once('lib/authorization.class.php');
include_once('lib/message.class.php');
include_once('session.controller.php');

// POST / GET variables
$user_id = $_SESSION['user']->userId;
$household_id = $_GET['hid'];


if(Authorization::auth_delete_household($user_id, $household_id)) {

    // Get all shoppinglists of this household.
    $shoppinglists = DAOFactory::getShoppinglistDAO()->queryByHouseholdId($household_id);

    // Delete all items on shoppinglists in this household.
    for($i = 0; $i < count($shoppinglists); $i++) {
        DAOFactory::getItemDAO()->deleteByShoppinglistId($shoppinglists[$i]->shoppinglistId);
        DAOFactory::getBillDAO()->deleteByShoppinglistId($shoppinglists[$i]->shoppinglistId);
    }

    // Delete shoppinglists in this household.
    DAOFactory::getShoppinglistDAO()->deleteByHouseholdId($household_id);
    // Delete budget of this household
    DAOFactory::getBudgetDAO()->deleteByHouseholdId($household_id);
    // Delete invitations for this household.
    DAOFactory::getInvitationDAO()->deleteByHouseholdId($household_id);
    // Delete all user_household entries.
    DAOFactory::getUserHouseholdDAO()->deleteByHouseholdId($household_id);
    // Delete household
    DAOFactory::getHouseholdDAO()->delete($household_id);

    $msg = new Message ('Household deleted', 'message');
    $data = $msg->to_array();

} else {
    $msg = new Message ('Not authorized to delete this household!', 'error');
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