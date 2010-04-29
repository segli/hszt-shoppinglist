<?php
include_once('../config/environment.php');
include_once('../controllers/session.controller.php');
?>

<div class="mod modInvite">
    <div class="inner">
        <div class="hd">
            <h2 class="base">Share household with someone</h2>
        </div>
        
        <div class="bd">
            <form class="create" action="controller_proxy.php?controller=createinvitation" method="post">
                <fieldset>
                    <div><label class="base">Send invitation to:</label>
                    <input name="email" autocomplete="off" /></div>
                    <input type="submit" value="invite" />
                </fieldset>
            </form>
        </div>
    </div>
</div>