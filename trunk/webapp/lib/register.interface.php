<?php
interface iRegister {
    public static function register_user($user);
    public static function is_user_registered($email);
}