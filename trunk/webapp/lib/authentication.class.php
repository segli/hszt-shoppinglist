<?php
include('lib/authentication.interface.php');
include_once('lib/include_dao.php');

class Authentication implements iAuthentication {
    function __construct(){
    
    }

    /**
     * @static
     * @param  {string} $id
     * @param  {string} $password
     * @return string
     */
    public static function authenticate_user($id, $password) {

        $user = DAOFactory::getUserDAO()->queryByEmail($id);


        return $user;
    }

    /**
     * @static
     * @param  {string} $id
     * @return bool
     */
    public static function is_user_authenticated($id) {
        return true;
    }

}