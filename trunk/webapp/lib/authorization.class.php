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

        $shoppinglists = DAOFactory::getShoppinglistDAO()->queryAllByUserIdNotClosed($user_id);

        for($i = 0; $i < count($shoppinglists); $i++) {
            if($shoppinglists[$i]->shoppinglistId == $shoppinglist_id) {

                $status = $shoppinglists[$i]->status;

                // True if shoppinglist is open or private but user is owner.
                if($status == 0 OR ($status == 1 AND $shoppinglists[$i]->userId == $user_id)) {
                    return true;
                } else {
                    return false;
                }
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

    public static function auth_create_bill($user_id, $shoppinglist_id) {
        // TODO: Implement auth_create_bill() method.
    }

    public static function auth_create_budget($user_id, $household_id) {
        // TODO: Implement auth_create_budget() method.
    }



    public static function auth_delete_household($user_id, $household_id) {

        $user = DAOFactory::getUserHouseholdDAO()->queryAllByUserIdAndHouseholdIdAndOwner($user_id, $household_id);

        if(count($user) == 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function auth_delete_item($user_id, $item_id) {

        $items = DAOFactory::getItemDAO()->queryAllByUserIdNotClosed($user_id);

        for($i = 0; $i < count($items); $i++) {
            if($items[$i]->itemId == $item_id) {
                return true;
            }
        }

        return false;
    }

    public static function auth_delete_shoppinglist($user_id, $shoppinglist_id) {

        $shoppinglist = DAOFactory::getShoppinglistDAO()->queryAllByShoppinglistIdAndOwnerIdNotClosed($shoppinglist_id, $user_id);
        
        if(count($shoppinglist) == 1) {
            return true;
        } else {
            return false;
        }
    }



    public static function auth_status_item($user_id, $shoppinglist_id) {

        $shoppinglists = DAOFactory::getShoppinglistDAO()->queryAllByUserIdNotClosed($user_id);

        for($i = 0; $i < count($shoppinglists); $i++) {
            if($shoppinglists[$i]->shoppinglistId == $shoppinglist_id) {

                $status = $shoppinglists[$i]->status;

                // True if shoppinglist is open or private but user is owner.
                if($status == 0 OR ($status == 1 AND $shoppinglists[$i]->userId == $user_id)) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        return false;
    }

    public static function auth_status_shoppinglist($user_id, $shoppinglist_id) {

        $shoppinglist = DAOFactory::getShoppinglistDAO()->queryAllByShoppinglistIdAndOwnerIdNotClosed($user_id, $shoppinglist_id);

        if(count($shoppinglist) == 1) {
            return true;
        } else {
            return false;
        }
    }
}