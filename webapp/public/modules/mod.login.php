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
                    <input type="text" class="text" name="user_email" autocomplete="on" /></div>
                    <div><label class="base">Password</label>
                    <input type="password" class="text" name="user_password" autocomplete="on" /></div>
                    <div><input type="submit" class="button" value="Login" /></div>
                </fieldset>
            </form>
        </div>

    </div>
</div>