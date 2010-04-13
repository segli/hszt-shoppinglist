<?php

include('authentication.interface.php');
include('include_dao.php');

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

        echo $user->password;

		return true;
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

?>