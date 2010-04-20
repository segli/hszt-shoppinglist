<?php
interface iAuthentication {
    public static function authenticate_user($email, $password);
    //public static function is_user_authenticated($id);
}