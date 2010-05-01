<?php
include_once('../config/environment.php');
include_once('controllers/session.controller.php');
?>

<div class="mod modHouseholds">
    <div class="inner">
        <div class="hd">
            <h2 class="base">My Households</h2>
        </div>
        <div class="bd bdExisting"></div>
        <div class="hd">
            <h2 class="base">Pending Invitations</h2>
        </div>
        <div class="bd bdInvitations"></div>
        <div class="hd">
            <h2 class="base">Create New</h2>
        </div>
        <div class="bd">
            <form class="create" action="controller_proxy.php?controller=createhousehold" method="post">
                <fieldset>
                    <div><label class="base">Household name</label>
                    <input name="household_name" class="text" autocomplete="off" /></div>
                    <input type="submit" class="button" value="Create Household" />
                </fieldset>
            </form>
        </div>
       
    </div>
</div>