<?php
include('lib/authentication.interface.php');

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
        session_start();
        return session_id();
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