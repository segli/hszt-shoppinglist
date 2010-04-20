<?php
include('lib/authentication.interface.php');
include('lib/include_dao.php');

class Authentication implements iAuthentication {

    function __construct() {
    
    }

    /**
     * @static
     * @param  {string} $id
     * @param  {string} $password
     * @return string
     */
    public static function authenticate_user($email, $password) {

        $user = DAOFactory::getUserDAO()->queryByEmail($email);
        
		if(count($user) == 1) {

            $hash = sha1($password . $user[0]->salt);

			if($user[0]->password == $hash) {
				return $user[0];
			} else {
                return null;
            }
		} else {
            return null;
        }
    }
}