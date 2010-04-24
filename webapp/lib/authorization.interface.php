<?php
interface iAuthorization {
    public static function auth_create_shoppinglist($household_id, $user_id);
    public static function auth_create_item($shoppinglist_id, $user_id);

}