<?php
include_once('../config/environment.php');

?>

<div class="mod modHouseholds">
    <div class="inner">
        <div class="hd">
            <h2 class="base">Existing</h2>
        </div>
        <div class="bd">
            
        </div>
        <div class="hd">
            <h2 class="base">Pending Invitations</h2>
        </div>
        <div class="bd">

        </div>
        <div class="hd">
            <h2 class="base">Create New</h2>
        </div>
        <div class="bd">
            <form class="create_household" action="controller_proxy.php?controller=createhousehold" method="post">
                <fieldset>
                    <div><label class="base">Household name</label>
                    <input name="household_name" /></div>
                    <input type="submit" value="create household" />
                </fieldset>
            </form>
        </div>
    </div>
</div>