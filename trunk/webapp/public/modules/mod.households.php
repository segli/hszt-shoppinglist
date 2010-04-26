<?php
include_once('../config/environment.php');
include_once('../controllers/session.controller.php');
?>

<div class="mod modHouseholds">
    <div class="inner">
        <div class="hd">
            <h2 class="base">Existing</h2>
        </div>
        <div class="bd bdExisting"></div>
        <div class="hd">
            <h2 class="base">Pending Invitations</h2>
        </div>
        <div class="bd"></div>
        <div class="hd">
            <h2 class="base">Create New</h2>
        </div>
        <div class="bd">
            <form class="create" action="controller_proxy.php?controller=createhousehold" method="post">
                <fieldset>
                    <div><label class="base">Household name</label>
                    <input name="household_name" autocomplete="off" /></div>
                    <input type="submit" value="create household" />
                </fieldset>
            </form>
        </div>
        <div class="bd">
            <form class="invite" action="controller_proxy.php?controller=createinvitation" method="post">
                <fieldset>
                    <div><label class="base">Send invitation to:</label>
                    <input name="email" autocomplete="off" /></div>
                    <input type="submit" value="invite" />
                </fieldset>
            </form>
        </div>
    </div>
</div>