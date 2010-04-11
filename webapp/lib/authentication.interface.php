<?php
interface iAuthentication {
    public static function authenticate_user($id, $password);
    public static function is_user_authenticated($id);
}