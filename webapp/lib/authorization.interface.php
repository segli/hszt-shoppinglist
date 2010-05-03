<?php
interface iAuthorization {
    public static function auth_create_shoppinglist($user_id, $household_id);
    public static function auth_create_item($user_id, $shoppinglist_id);
    public static function auth_create_invitation($user_id, $household_id);
    public static function auth_create_bill($user_id, $shoppinglist_id);
    public static function auth_create_budget($user_id, $household_id);

    public static function auth_delete_household($user_id, $household_id);
    public static function auth_delete_shoppinglist($user_id, $shoppinglist_id);
    public static function auth_delete_item($user_id, $item_id);

    public static function auth_status_shoppinglist($user_id, $household_id);
    public static function auth_status_item($user_id, $shoppinglist_id);
    public static function auth_status_invitation($user_id, $invitation_id);
}