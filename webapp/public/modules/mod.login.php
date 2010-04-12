<?php
include_once('../config/environment.php');

?>
<div class="mod modLogin">
    <div class="inner">
        <div class="hd">
            <h2 class="base">Login</h2>
        </div>
        <div class="bd">
            <form>
                <fieldset>
                    <div><label>E-Mail</label>
                    <input name="user_email" /></div>
                    <div><label>Password</label>
                    <input type="password" name="user_password" /></div>
                    <div><input type="submit" value="login" /></div>
                </fieldset>
            </form>
        </div>
    </div>
</div>