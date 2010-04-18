<?php
interface iUserhelper {
    public static function get_households_by_userid($user_id);
    public static function get_invitations_by_userid($user_id);
}