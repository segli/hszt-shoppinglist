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

            $hash = hash("sha256", $password . $user[0]->salt);
           
			if($user[0]->password == $hash) {
				return $user[0];
			} else {
                return null;
            }
		} else {
            return null;
        }
    }

    /**
     * @static
     * @param  {object} $user
     * @return string
     */
    public static function insert_user($user) {

        if(count(DAOFactory::getUserDAO()->queryByEmail($user->email)) == 0) {

            $salt = Authentication::generate_salt();
            $hash = Authentication::hash_password($user->password, $salt);

            $user->salt = $salt;
            $user->password = $hash;

            $id = DAOFactory::getUserDAO()->insert($user);
            return $id;
            
        } else {
            return null;
        }
    }

    /**
     * @static
     * @param  {object} $user
     * @return boolean
     */
    public static function fields_not_empty($user) {

        if($user->firstname == "" OR $user->lastname == "" OR
           $user->email == "" OR $user-password == "") {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @static
     * @param  {string} $password
     * @param  {string} $salt
     * @return string $hash
     */
    public static function hash_password($password, $salt) {
        return hash("sha256", $password . $salt);
    }

    /**
     * @static
     * @return string $salt
     */
    public static function generate_salt() {
        return substr(sha1(uniqid(microtime()) . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']), 3, 13);
    }

    /**
    * @static
    * @return boolean
    */
    public static function is_email_address($email) {

        return true;
        /*
		if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
			return true;
		} else {
			return false;
		}
		*/
		
	}

    /**
    * @static
    * @return boolean
    */
    public static function password_confirmation($pw1, $pw2) {
        if ($pw1 == $pw2) {
            return true;
        } else {
            return false;
        }
    }

    /**
    * @static
    * @return boolean
    */
    public static function password_complexity($password) {

        return true;
        /*
        if (strlen($password) < 6) {
			return false;
		} else {
			return true;
        }*/
    }


    
}