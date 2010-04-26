<?php
include('authorization.interface.php');
include('include_dao.php');

class Authorization implements iAuthorization {

    function __construct() {
    
    }


    public static function auth_create_shoppinglist($user_id, $household_id) {

        $householdlist = DAOFactory::getHouseholdDAO()->queryAllByUserId($user_id);

        for($i = 0; $i < count($householdlist); $i++) {
            if($householdlist[$i]->householdId == $household_id) {
                return true;
            }
        }

        return false;
    }

    public static function auth_create_item($user_id, $shoppinglist_id) {

        $shoppinglists = DAOFactory::getShoppinglistDAO()->queryAllByUserId($user_id);

        for($i = 0; $i < count($shoppinglists); $i++) {
            if($shoppinglists[$i]->shoppinglistId == $shoppinglist_id) {
                return true;
            }
        }

        return false;
    }

    public static function auth_create_invitation($user_id, $household_id) {

        $user = DAOFactory::getUserHouseholdDAO()->queryAllByUserIdAndHouseholdIdAndOwner($user_id, $household_id);

        if(count($user) == 1) {
            return true;
        } else {
            return false;
        }
    }

    
}