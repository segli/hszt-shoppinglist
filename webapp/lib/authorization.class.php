<?php
include('authorization.interface.php');
include('include_dao.php');

class Authorization implements iAuthorization {

    function __construct() {
    
    }


    public static function auth_create_shoppinglist($user_id, $household_id) {

        return true;
        /*
        $householdlist = DAOFactory::getHouseholdDAO()->queryAllByUserId($user_id);

        for($i = 0; $i < count($householdlist); $i++) {
            if($householdlist[$i]->household_id == $household_id) {
                return true;
            }
        }

        return false;
        */
    }

    public static function auth_create_item($user_id, $shoppinglist_id) {

        return true;
        /*

        $shoppinglists = DAOFactory::getShoppinglistDAO()->queryAllByUserId($user_id);

        for($i = 0; $i < count($shoppinglists); $i++) {
            if($shoppinglists[$i]->shoppinglist_id == $shoppinglist_id) {
                return true;
            }
        }

        return false;
        */
    }


    
}