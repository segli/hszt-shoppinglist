<?php
interface iAuthentication {
    public static function authenticate_user($email, $password);
    public static function fields_not_empty($user);
    public static function hash_password($password, $salt);
    public static function generate_salt();
    public static function is_email_address($email);
    public static function password_confirmation($pw1, $pw2);
    public static function password_complexity($password);
}