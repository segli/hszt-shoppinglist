<?php
include_once('../config/environment.php');

?>

<div class="mod modRegister">
    <div class="inner">
        <div class="hd">
            <h2 class="base">Register</h2>
        </div>
        <div class="bd">
            <form method="post" action="controller_proxy.php?controller=register">
                <fieldset>
                    <div><label class="base">First Name</label>
                    <input name="user_first_name" autocomplete="off" /></div>
                    <div><label class="base">Last Name</label>
                    <input name="user_last_name" autocomplete="off" /></div>
                    <div><label class="base">E-Mail</label>
                    <input name="user_email" autocomplete="off" /></div>
                    <div><label class="base">Password</label>
                    <input type="password" name="user_password" autocomplete="off" /></div>
                    <div><label class="base">Confirm Password</label>
                    <input type="password" name="user_confirm_password" autocomplete="off" /></div>
                    <div><input type="submit" value="Register" /></div>
                </fieldset>
            </form>
        </div>
    </div>
</div>