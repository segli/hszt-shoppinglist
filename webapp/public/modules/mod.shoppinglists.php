<?php
include_once('../config/environment.php');
include_once('../controllers/session.controller.php');

// household id from which the shoppingslists must be loaded. 
$household_id = $_GET['hid'];

?>

<div class="mod modShoppinglists">
    <div class="inner">
        <div class="hd">
            <h2 class="base">Existing</h2>
        </div>
        <div class="bd bdExisting"></div>
        <div class="hd">
            <h2 class="base">Create New</h2>
        </div>
        <div class="bd">
            <form class="create_shoppinglist" action="controller_proxy.php?controller=createshoppinglists" method="post">
                <fieldset>
                    <div><label class="base">Shoppinglist name</label>
                    <input name="shoppinglist_name" />
                    <input type="checkbox" name="private">Private List</div>
                    <input type="submit" value="add shoppinglist" />
                </fieldset>
            </form>
        </div>
    </div>
</div>