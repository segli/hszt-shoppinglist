<?php
include('lib/authentication.interface.php');
include('lib/include_dao.php');

class Authentication implements iAuthentication {
    function __construct(){
    
    }

    /**
     * @static
     * @param  {string} $id
     * @param  {string} $password
     * @return string
     */
    public static function authenticate_user($email, $password) {

        $user = DAOFactory::getUserDAO()->queryByEmail($email);

        return $user[0];
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