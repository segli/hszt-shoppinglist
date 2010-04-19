<?php
include_once('../config/environment.php');

?>

<div class="mod modLogin">
    <div class="inner">
        <div class="hd">
            <h2 class="base">Login</h2>
        </div>
        <div class="bd">
            <form method="post" action="">
                <fieldset>
                    <div><label class="base">E-Mail</label>
                    <input name="user_email" /></div>
                    <div><label class="base">Password</label>
                    <input type="password" name="user_password" /></div>
                    <div><input type="submit" value="login" /></div>
                </fieldset>
            </form>
        </div>
        <div class="bd">
            <a href="register.php">Register</a>
        </div>
    </div>
</div>