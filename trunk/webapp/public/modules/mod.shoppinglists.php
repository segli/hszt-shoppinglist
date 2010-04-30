<?php
include_once('../config/environment.php');
include_once('controllers/session.controller.php');

?>

<div class="mod modShoppinglists">
    <div class="inner">
        <div class="hd">
            <h2 class="base">My Shoppinglists</h2>
        </div>
        <div class="bd bdExisting"></div>
        <div class="hd">
            <h2 class="base">Create New</h2>
        </div>
        <div class="bd">
            <form class="create" action="controller_proxy.php?controller=createshoppinglist
            " method="post">
                <fieldset>
                    <div><label class="base">Shoppinglist name - <input type="checkbox" class="checkbox" name="private"> Private List</label>
                    <input name="shoppinglist_name" class="text" autocomplete="off" /><br />
                    </div>
                    <input type="submit" class="button" value="Add Shoppinglist" />
                </fieldset>
            </form>
        </div>
    </div>
</div>