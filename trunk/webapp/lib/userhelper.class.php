<?php
include('lib/userhelper.interface.php');
include('lib/include_dao.php');

class Userhelper implements iUserhelper {
    function __construct(){

    }

    /**
     * @static
     * @param  $user_id
     * @return 
     */
    public static function get_households_by_userid($user_id) {

        $household = DAOFactory::getUserHouseholdDAO()->queryByUserId($user_id);

        return $household[0];
    }

    /**
     * @static
     * @param  $user_id
     * @return bool
     */
    public static function get_invitations_by_userid($user_id) {
        return true;
    }

}